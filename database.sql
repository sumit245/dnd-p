CREATE DATABASE IF NOT EXISTS `dashandots_cms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `dashandots_cms`;

-- --------------------------------------------------------
-- Table structure for table `admins`
-- --------------------------------------------------------
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin (username: admin, password: password)
INSERT INTO `admins` (`username`, `password_hash`) VALUES
('admin', '$2y$12$VI5D.CoRJnnwZc.oMW0fPOf1WQ7iyFwhVdVeXFvagVzltfmrTOMca');

-- --------------------------------------------------------
-- Table structure for table `site_settings`
-- --------------------------------------------------------
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default settings
INSERT INTO `site_settings` (`key_name`, `value`) VALUES
('hero_title', 'Custom ERP & CRM for Growing SMEs'),
('hero_description', 'Dashandots designs secure, scalable ERP, CRM, dashboard, portal, and mobile platforms for growing businesses that need clearer operations, stronger controls, and reliable long-term support.'),
('about_us_text', 'Dashandots Technology is a full-cycle software development and technology consulting company based in India. We combine the rigour of large enterprise IT firms with the agility and transparency that small and mid-sized businesses need.');

-- --------------------------------------------------------
-- Table structure for table `blogs`
-- --------------------------------------------------------
CREATE TABLE `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `feature_image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `keywords` varchar(500) DEFAULT NULL COMMENT 'Comma-separated SEO keywords',
  `category` varchar(100) DEFAULT NULL COMMENT 'Post category',
  `read_time` smallint unsigned DEFAULT NULL COMMENT 'Estimated read time in minutes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `portfolios`
-- --------------------------------------------------------
CREATE TABLE `portfolios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(32) NOT NULL DEFAULT 'web' COMMENT 'Portfolio filter: erp | tms | hms | web | mobile',
  `industry` varchar(32) DEFAULT NULL COMMENT 'Industry slug - see includes/portfolio-taxonomy.php',
  `badge` varchar(32) DEFAULT NULL COMMENT 'Short label shown on the card thumbnail (defaults to upper-cased slug)',
  `sort_order` int(11) NOT NULL DEFAULT 100,
  `short_description` text NOT NULL,
  `client_name` varchar(120) DEFAULT NULL,
  `client_url` varchar(255) DEFAULT NULL,
  `detailed_description` longtext DEFAULT NULL,
  `demo_url` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `tile_color` varchar(7) DEFAULT NULL COMMENT '#RRGGBB for the initials tile when no screenshot',
  `gallery_images` text DEFAULT NULL COMMENT 'Comma-separated list of secondary screenshot URLs',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_portfolios_industry` (`industry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default portfolio items (ERP, TMS, HMS)
INSERT INTO `portfolios` (`title`, `slug`, `category`, `industry`, `badge`, `sort_order`, `short_description`, `detailed_description`, `demo_url`, `username`, `password`, `image_path`) VALUES
('Enterprise Resource Planning (ERP)', 'erp', 'erp', 'manufacturing', 'ERP', 900, 'A modular ERP system designed for manufacturing, trading, and service businesses. Integrates inventory, HR, sales, and accounts.', 'Full suite ERP with multi-branch capabilities.', 'https://erp.dashandots.com/login', 'admin@erp.com', 'password123', 'https://placehold.co/600x400/1e293b/ffffff?text=ERP+Dashboard'),
('Transport Management System (TMS)', 'tms', 'tms', 'logistics', 'TMS', 910, 'End-to-end logistics platform for fleet management, freight tracking, route optimization, and digital proof of delivery.', 'Complete solution for transport and logistics operations.', 'https://tms.dashandots.com/login', 'dispatcher@tms.com', 'logisticspass', 'https://placehold.co/600x400/1e293b/ffffff?text=TMS+Dashboard'),
('Hospital Management System (HMS)', 'hms', 'hms', 'healthcare', 'HMS', 920, 'Comprehensive clinic and hospital management. Handles appointments, billing, electronic medical records (EMR), and pharmacy.', 'Modern patient and facility management software.', 'https://hms.dashandots.com/login', 'doctor@hms.com', 'health2024', 'https://placehold.co/600x400/1e293b/ffffff?text=HMS+Dashboard');
