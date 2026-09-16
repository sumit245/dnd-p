-- Migration: Add 'graphics' as a valid portfolio category
-- The `category` column already accepts any varchar(32) value.
-- This migration simply documents the new value and updates the column comment.
-- Run this against the dashandots_cms database.

ALTER TABLE `portfolios`
  MODIFY COLUMN `category` varchar(32) NOT NULL DEFAULT 'web'
  COMMENT 'Portfolio filter: erp | tms | hms | web | mobile | graphics';

-- Example: Insert a graphics portfolio item
-- INSERT INTO `portfolios` (`title`, `slug`, `category`, `industry`, `badge`, `sort_order`, `short_description`)
-- VALUES ('Brand Identity — Acme Corp', 'acme-brand', 'graphics', 'service', 'DESIGN', 500,
--         'Complete brand identity package including logo, colors, typography, and marketing collateral.');
