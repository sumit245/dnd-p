<?php
/**
 * Replace em-dashes in database-held content.
 *
 * Most site copy lives in files and was converted directly. These rows do not:
 * the erp / tms / hms portfolio entries, blog posts written through the admin,
 * and site_settings values. They exist only in the database, so this script
 * applies the same rules the files got:
 *
 *   :   defining or elaborating on what came before (the default)
 *   ;   joining two clauses, including before a conjunction or an imperative
 *   |   separating parallel labels, and brand suffixes in titles
 *   ( ) a matched pair of dashes wrapping an aside
 *
 * Standalone em-dashes used as an empty-value glyph are left alone.
 *
 * Dry run by default; prints every change and writes nothing:
 *   php scripts/replace-emdashes-in-db.php
 *
 * Apply, after writing a .sql backup of every affected row:
 *   php scripts/replace-emdashes-in-db.php --apply
 *
 * Idempotent: running it twice changes nothing the second time. Run it on each
 * environment separately, since every environment has its own database.
 */

require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/db.php';

$apply = in_array('--apply', $argv ?? [], true);

/** Columns worth rewriting, by table. */
const TARGETS = [
    'portfolios'    => ['title', 'short_description', 'detailed_description'],
    'blogs'         => ['title', 'excerpt', 'content'],
    'site_settings' => ['value'],
];

const DASH = "\u{2014}";

const CONJUNCTION = ['and','but','so','yet','or','while','with'];
const PRONOUN     = ['we','it','they','you','your','our','this','that','there','he','she','i'];
const IMPERATIVE  = ['ask','send','reply','see','check','use','pick','log','try','tell',
                     'email','write','start','run','book','browse','then'];

/** First word after the dash, lowercased and stripped of markup. */
function next_word(string $after): string
{
    $after = preg_replace('/^\s*(<[^>]+>\s*)*/', '', $after);
    preg_match('/^[A-Za-z]+/', (string)$after, $m);
    return strtolower($m[0] ?? '');
}

/**
 * Rewrite one string. Returns [newValue, [[rule, context], ...]].
 */
function convert(string $value): array
{
    $log = [];
    // Normalise the entity so one pass handles both forms.
    $value = str_replace('&mdash;', DASH, $value);
    if (!str_contains($value, DASH)) {
        return [$value, $log];
    }

    // 1. matched pair wrapping a short aside -> parentheses
    $value = preg_replace_callback(
        '/\s*' . DASH . '\s*(?<aside>[^' . DASH . '.!?]{1,90})\s*' . DASH . '\s*(?<tail>[a-z<])/u',
        static function (array $m) use (&$log): string {
            $log[] = ['( )', trim($m['aside'])];
            return ' (' . rtrim($m['aside']) . ') ' . $m['tail'];
        },
        $value
    );

    // 2. everything else, dash by dash
    $out = '';
    $rest = $value;
    while (($pos = mb_strpos($rest, DASH)) !== false) {
        $before = mb_substr($rest, 0, $pos);
        $after  = mb_substr($rest, $pos + 1);

        $trimmedBefore = rtrim($before);
        $isolated = preg_match('/(>|"|\')\s*$/', $before) && preg_match('/^\s*(<|"|\')/', $after);

        if ($isolated) {                                            // empty-value glyph
            $out  .= $before . DASH;
            $rest  = $after;
            continue;
        }

        $word = next_word($after);
        if (preg_match('#</(strong|b)>\s*$#i', $trimmedBefore)) {
            $rule = ':';
        } elseif (in_array($word, CONJUNCTION, true) || in_array($word, PRONOUN, true) || in_array($word, IMPERATIVE, true)) {
            $rule = ';';
        } else {
            $rule = ':';
        }

        $log[] = [$rule, trim(mb_substr($trimmedBefore, -40)) . ' [' . $rule . '] ' . trim(mb_substr(ltrim($after), 0, 40))];
        $out  .= $trimmedBefore . $rule . (preg_match('/^\s/', $after) ? ' ' : ' ');
        $rest  = ltrim($after);
    }

    return [$out . $rest, $log];
}

$changes = [];
foreach (TARGETS as $table => $columns) {
    $have    = $pdo->query("SHOW COLUMNS FROM `$table`")->fetchAll(PDO::FETCH_COLUMN);
    $missing = array_values(array_diff($columns, $have));
    $columns = array_values(array_intersect($columns, $have));
    // Say so rather than skipping in silence: a renamed column would otherwise
    // leave rows converted everywhere except here, with nothing to show why.
    if ($missing) {
        fwrite(STDERR, sprintf("warning: %s has no column(s) %s; not converted\n",
            $table, implode(', ', $missing)));
    }
    if (!$columns) {
        continue;
    }
    $key  = in_array('id', $have, true) ? 'id' : $have[0];
    $rows = $pdo->query('SELECT `' . $key . '`, `' . implode('`, `', $columns) . "` FROM `$table`")
                ->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        foreach ($columns as $col) {
            $old = (string)($row[$col] ?? '');
            if (!str_contains($old, DASH) && !str_contains($old, '&mdash;')) {
                continue;
            }
            [$new, $log] = convert($old);
            if ($new !== $old) {
                $changes[] = compact('table', 'key', 'col', 'log') + ['id' => $row[$key], 'new' => $new];
            }
        }
    }
}

if (!$changes) {
    echo "Nothing to change.\n";
    exit;
}

$total = 0;
foreach ($changes as $c) {
    printf("%s #%s . %s  (%d)\n", $c['table'], $c['id'], $c['col'], count($c['log']));
    foreach ($c['log'] as [$rule, $ctx]) {
        printf("    %-3s %s\n", $rule, preg_replace('/\s+/', ' ', $ctx));
        $total++;
    }
}
printf("\n%d replacement(s) across %d column(s).\n", $total, count($changes));

if (!$apply) {
    echo "Dry run. Re-run with --apply to write, after a backup is taken.\n";
    exit;
}

// Back up every affected row before writing.
$stamp  = date('Ymd-His');
$backup = __DIR__ . "/../backups/emdash-rows-$stamp.sql";
@mkdir(dirname($backup), 0775, true);
$fh = fopen($backup, 'w');
fwrite($fh, "-- Rows as they were before scripts/replace-emdashes-in-db.php ran at $stamp\n");
foreach ($changes as $c) {
    $stmt = $pdo->prepare("SELECT `{$c['col']}` FROM `{$c['table']}` WHERE `{$c['key']}` = ?");
    $stmt->execute([$c['id']]);
    $was = (string)$stmt->fetchColumn();
    fwrite($fh, sprintf(
        "UPDATE `%s` SET `%s` = %s WHERE `%s` = %s;\n",
        $c['table'], $c['col'], $pdo->quote($was), $c['key'], $pdo->quote((string)$c['id'])
    ));
}
fclose($fh);
echo "Backup written to $backup\n";

$pdo->beginTransaction();
try {
    foreach ($changes as $c) {
        $stmt = $pdo->prepare("UPDATE `{$c['table']}` SET `{$c['col']}` = ? WHERE `{$c['key']}` = ?");
        $stmt->execute([$c['new'], $c['id']]);
    }
    $pdo->commit();
    printf("Applied %d replacement(s).\n", $total);
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, "Rolled back: " . $e->getMessage() . "\n");
    exit(1);
}
