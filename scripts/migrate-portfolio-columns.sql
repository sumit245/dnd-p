-- Adds category / badge / sort_order to portfolios (run once on production before seed-portfolio-products.php)
ALTER TABLE portfolios
  ADD COLUMN category VARCHAR(32) NOT NULL DEFAULT 'web' COMMENT 'Portfolio filter: erp | tms | hms | web | mobile' AFTER slug,
  ADD COLUMN badge VARCHAR(32) DEFAULT NULL COMMENT 'Short label shown on the card thumbnail (defaults to upper-cased slug)' AFTER category,
  ADD COLUMN sort_order INT NOT NULL DEFAULT 100 AFTER badge;

UPDATE portfolios SET category = slug, badge = UPPER(slug) WHERE slug IN ('erp', 'tms', 'hms');
UPDATE portfolios SET sort_order = CASE slug WHEN 'erp' THEN 900 WHEN 'tms' THEN 910 WHEN 'hms' THEN 920 ELSE sort_order END;
