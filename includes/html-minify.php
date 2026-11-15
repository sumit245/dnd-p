<?php
/**
 * Strip template indentation from HTML responses.
 *
 * The templates are indented for people to read, and that indentation ships
 * to every visitor: 20% of the bytes on /blog/ and 23% on /portfolio
 * (measured 15 Nov 2026). On pages that are mostly markup it also pushed the
 * text-to-HTML ratio under Semrush's 0.10 threshold, with 0.08 on both.
 *
 * What it removes, and nothing else:
 *   - whitespace between a newline and the first non-space character
 *   - trailing whitespace at the end of a line
 *   - runs of blank lines
 *   - HTML comments, except downlevel-revealed conditionals (<!--[if ...)
 *
 * Newlines themselves are kept. A newline between two inline elements still
 * renders as one space, so collapsing the indent cannot close up text that
 * was meant to have a gap; removing the newline too would.
 *
 * Left untouched: <pre>, <textarea>, <script> and <style> bodies. Leading
 * whitespace inside a textarea is part of its value, and a JavaScript line
 * comment or template literal can depend on line structure.
 *
 * Only text/html responses are rewritten. contact-handler.php, estimate.php,
 * includes/ai-brief.php and sitemap.php send JSON or XML, and declare it, so
 * the Content-Type check skips them.
 */

/** Collapse indentation outside protected elements. */
function html_minify_output(string $html): string
{
    // Bail on anything that is not HTML: the handler declared another type.
    foreach (headers_list() as $header) {
        if (stripos($header, 'content-type:') === 0) {
            if (stripos($header, 'text/html') === false) {
                return $html;
            }
            break;
        }
    }

    // Keep protected regions out of the way, then put them back verbatim.
    $pattern = '#(<(pre|textarea|script|style)\b[^>]*>.*?</\2\s*>)#is';
    $parts = preg_split($pattern, $html, -1, PREG_SPLIT_DELIM_CAPTURE);
    if ($parts === false) {
        return $html;
    }

    $out = '';
    foreach ($parts as $i => $part) {
        // preg_split with DELIM_CAPTURE yields: text, whole match, tag name,
        // text, ... so every third element from index 1 is a protected block
        // and the one after it is its tag name.
        if ($i % 3 !== 0) {
            if ($i % 3 === 1) {
                $out .= $part;
            }
            continue;
        }

        // Comments, but never a conditional: "<!--[if lt IE 9]>" and friends
        // are read by the browser, not ignored by it.
        $part = preg_replace('/<!--(?!\[if)(?!<!)(?:(?!-->).)*-->/s', '', $part);
        $part = preg_replace('/[ \t]+\n/', "\n", $part);   // trailing spaces
        $part = preg_replace('/\n[ \t]+/', "\n", $part);   // indentation
        $part = preg_replace('/\n{2,}/', "\n", $part);     // blank lines

        $out .= $part;
    }

    return $out;
}

// Pages that stream or send headers late are unaffected: the buffer is
// flushed at shutdown either way.
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    ob_start('html_minify_output');
}
