<?php
/**
 * Add an "agentic engineering for software development teams" section to the
 * agentic-AI blog post.
 *
 * Why: the phrase is a target query (user request, 15 Nov 2026) and appeared
 * nowhere on the site, although this 2,000-word post covers the subject. The
 * post argues what agentic AI is; this section covers the part a team lead
 * actually has to decide, which is how the practice is organised around it.
 *
 * The post lives in the blogs table, not in a file, so a git deploy does not
 * carry it. Run this once per environment, like
 * scripts/update-agentic-ai-readability.php.
 *
 * Dry run (default: reports what would change, writes nothing):
 *   php scripts/add-agentic-engineering-section.php
 *
 * Apply:
 *   php scripts/add-agentic-engineering-section.php --apply
 *
 * Idempotent: a second run reports the section is already present. The
 * previous content is written to backups/ before any update.
 */

require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/db.php';

const SLUG = 'agentic-ai-software-development';

// Inserted immediately before this heading, so the post reads: what agents
// are, how they work, how they compare, how a team organises around them,
// then the practical integration steps.
const ANCHOR = '<h2>Practical Steps to Integrate Agentic AI Into Your Workflow</h2>';

const MARKER = '<h2>Agentic Engineering for Software Development Teams</h2>';

$apply = in_array('--apply', $argv, true);

$section = <<<'HTML'
<h2>Agentic Engineering for Software Development Teams</h2>
<p>Agentic engineering is the team practice that grows up around these tools. It is not the tool itself. A single developer running an agent on a side project is using agentic AI. A team that has agreed who reviews agent output, which parts of the codebase an agent may touch, and what has to be true before that output merges, is doing agentic engineering.</p>
<p>The distinction matters because the failure mode is organisational, not technical. Agents raise the volume of code a team produces long before they raise the volume it can review. A team that doubles its output and keeps one reviewer has not got faster. It has moved the queue.</p>
<h3>What changes for the team</h3>
<ul>
<li><strong>Review becomes the bottleneck, so it becomes the priority.</strong> If agents write more code, reviewing it is the scarce work. Budget senior time for review rather than treating it as something done between tasks.</li>
<li><strong>The test suite becomes infrastructure, not hygiene.</strong> An agent checks its work against your tests. Weak coverage does not slow an agent down; it just lets bad output through. Coverage is what makes the loop safe.</li>
<li><strong>Specifications get written down again.</strong> A vague ticket produces vague code faster than before. Teams that do well with agents tend to write sharper tickets than they used to.</li>
<li><strong>Ownership stays human.</strong> The engineer who merges agent output owns it in review, on call and at the post-mortem. Nothing about the tooling changes that, and saying so early prevents an argument later.</li>
</ul>
<h3>Where to draw the line</h3>
<p>Most teams settle on a boundary rather than a blanket rule. Scaffolding, test writing, migrations, API documentation and repetitive refactors go to agents. Authentication, payments, permission logic and anything touching regulated data stay with people, with agent assistance at most. That boundary is worth writing down, because otherwise each developer draws it differently and the review standard drifts.</p>
<p>For a team adopting this deliberately, the honest first step is not choosing an agent. It is checking whether your test suite and your review capacity could absorb twice the code. If the answer is no, that is the work to do first.</p>
HTML;

$stmt = $pdo->prepare('SELECT id, content FROM blogs WHERE slug = ?');
$stmt->execute([SLUG]);
$row = $stmt->fetch();

if (!$row) {
    fwrite(STDERR, "No blog row for slug " . SLUG . " in this database.\n");
    exit(1);
}

if (str_contains($row['content'], MARKER)) {
    echo "Section already present; nothing to do.\n";
    exit(0);
}

if (!str_contains($row['content'], ANCHOR)) {
    fwrite(STDERR, "Anchor heading not found. The post differs from the expected\n"
        . "version; run scripts/update-agentic-ai-readability.php first, or\n"
        . "check the content by hand before re-running.\n");
    exit(1);
}

$new = str_replace(ANCHOR, $section . "\n" . ANCHOR, $row['content']);

$backupDir = __DIR__ . '/../backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0775, true);
}
$backup = $backupDir . '/blog-' . SLUG . '-' . date('Ymd-His') . '.html';
file_put_contents($backup, $row['content']);
echo "Previous content saved to " . $backup . "\n";

if (!$apply) {
    printf("Dry run. %d chars would become %d. Re-run with --apply to write.\n",
        strlen($row['content']), strlen($new));
    exit(0);
}

$upd = $pdo->prepare('UPDATE blogs SET content = ?, updated_at = NOW() WHERE id = ?');
$upd->execute([$new, $row['id']]);
printf("Updated blog #%d (%d rows).\n", $row['id'], $upd->rowCount());
