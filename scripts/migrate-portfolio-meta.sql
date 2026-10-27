-- Adds per-row SEO overrides to portfolios (run once on production).
--
-- Demo pages built their <title> from portfolios.title and their meta
-- description from short_description. Both are written for the page itself, so
-- titles ran past 70 characters and 13 descriptions past 180 (up to 249) and
-- truncated in search results.
--
-- Both columns are optional. demo/view.php resolution order is:
--   meta_title / meta_description  ->  includes/demo-seo.php  ->  generated fallback
-- The generated fallback appends the brand to the title and truncates the
-- short description on a word boundary at 155 characters.
--
-- Keep meta_title under 60 characters and meta_description between 120 and 155.

ALTER TABLE `portfolios`
  ADD COLUMN `meta_title` varchar(70) DEFAULT NULL
    COMMENT 'SEO <title> override, max 60 chars; brand is NOT appended' AFTER `short_description`,
  ADD COLUMN `meta_description` varchar(170) DEFAULT NULL
    COMMENT 'SEO meta description override, 120-155 chars' AFTER `meta_title`;
