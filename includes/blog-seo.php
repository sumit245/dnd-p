<?php
/**
 * Per-post SEO overrides for blog articles, keyed by slug.
 *
 * Why this exists: blog/post.php builds the <title> as
 * `blogs.title . ' | Dashandots Blog'`, and blogs.title is written for the
 * page itself, where a long descriptive headline reads well. In a SERP it
 * does not: the agentic-AI headline is 74 characters, which reached 92 once
 * the brand suffix was appended (Semrush, 15 Nov 2026).
 *
 * The blogs table has no meta_title column and posts are written through the
 * admin, so this file is the code-reviewed place to override a title without
 * touching the headline readers see. The H1 still comes from blogs.title,
 * which is intentional: the title tag targets the query, the H1 speaks to
 * the reader.
 *
 * Keep `title` under 60 characters and `description` under 155. Both are
 * used verbatim, so include the brand yourself if you want it. A slug with
 * no entry falls back to the generated title in blog/post.php, which keeps
 * itself under 60 and always differs from the H1.
 */

return [

    'agentic-ai-software-development' => [
        // 52 chars. The headline's "A Complete Guide for Engineering Teams"
        // is what pushed it to 92; the topic itself is the searched part.
        'title' => 'Agentic AI in Software Development | Dashandots Blog',
    ],

];
