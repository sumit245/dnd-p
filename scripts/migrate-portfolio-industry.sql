-- Adds industry / client / tile-colour columns to portfolios.
-- Run once (after migrate-portfolio-columns.sql, before seed-portfolio-products.php).
ALTER TABLE portfolios
  ADD COLUMN industry VARCHAR(32) DEFAULT NULL COMMENT 'Industry slug - see includes/portfolio-taxonomy.php' AFTER category,
  ADD COLUMN client_name VARCHAR(120) DEFAULT NULL AFTER short_description,
  ADD COLUMN client_url VARCHAR(255) DEFAULT NULL AFTER client_name,
  ADD COLUMN tile_color VARCHAR(7) DEFAULT NULL COMMENT '#RRGGBB for the initials tile when no screenshot' AFTER image_path,
  ADD INDEX idx_portfolios_industry (industry);

UPDATE portfolios SET industry = CASE slug
  WHEN 'erp' THEN 'manufacturing'
  WHEN 'tms' THEN 'logistics'
  WHEN 'hms' THEN 'healthcare'
  ELSE industry END
WHERE industry IS NULL;
