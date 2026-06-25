-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2026 at 08:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecomc`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-cc@gmail.com|127.0.0.1', 'i:1;', 1781164571),
('laravel-cache-cc@gmail.com|127.0.0.1:timer', 'i:1781164571;', 1781164571),
('laravel-cache-cc1@gmail.com|127.0.0.1', 'i:1;', 1781923594),
('laravel-cache-cc1@gmail.com|127.0.0.1:timer', 'i:1781923594;', 1781923594),
('laravel-cache-nana@gmail.com|127.0.0.1', 'i:3;', 1781165088),
('laravel-cache-nana@gmail.com|127.0.0.1:timer', 'i:1781165088;', 1781165088),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:5:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"view Products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:14:\"view dashboard\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:19:\"Background tracking\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"Hardware access\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"view consumer\";s:1:\"c\";s:3:\"web\";}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"building A\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:4:\"Role\";s:1:\"c\";s:3:\"web\";}}}', 1782437024);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_kh` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `name_kh`, `parent_id`, `image`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'All', NULL, 0, NULL, 'all', NULL, 1, '2026-05-20 19:30:02', '2026-05-20 19:30:12'),
(2, 'Electronics', NULL, 0, NULL, 'electronics', NULL, 1, '2026-05-20 19:30:31', '2026-05-20 19:30:31'),
(3, 'Accessories', NULL, 0, NULL, 'accessories', NULL, 1, '2026-05-20 19:30:40', '2026-06-10 20:13:23'),
(5, 'Furniture', NULL, 0, NULL, 'furniture', NULL, 1, '2026-05-20 19:31:04', '2026-05-20 19:31:04'),
(6, 'Kitchen', NULL, 0, NULL, 'kitchen', NULL, 1, '2026-05-20 19:31:07', '2026-05-20 19:31:07'),
(7, 'Food', 'អាហារ', 0, NULL, 'food', 'fool', 1, '2026-06-06 22:02:41', '2026-06-06 22:02:41'),
(8, 'សម្ភារះកីឡា', 'Sport', 1, 'categories/lNF4I2UKjaSbOpj1Mnwv5rJwlCtmco4QjDftPeue.png', '', NULL, 1, '2026-06-24 23:24:56', '2026-06-24 23:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_23_015029_create_categories_table', 1),
(5, '2026_04_23_015048_create_slides_table', 1),
(6, '2026_04_23_015103_create_products_table', 1),
(7, '2026_04_30_031548_create_permission_tables', 1),
(8, '2026_06_03_000001_create_orders_table', 2),
(9, '2026_06_03_000002_create_order_items_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `email`, `phone`, `address`, `total`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ramo Ut', 'ramo0702022@gmail.com', '70742577', '3', 199.70, 'credit_card', 'completed', '2026-06-03 03:33:17', '2026-06-03 03:33:17'),
(2, 1, 'cc', 'cc@gmail.com', '70771350', '4', 599.10, 'credit_card', 'completed', '2026-06-03 19:22:06', '2026-06-03 19:22:06'),
(3, 1, 'Ramo', 'ramo0702022@gmail.com', '70742577', 'pp', 100.99, 'cash_on_delivery', 'completed', '2026-06-03 19:29:57', '2026-06-03 19:29:57'),
(4, 1, 'R', 'ramo0702022@gmail.com', '70742577', 'pp', 199.70, 'cash_on_delivery', 'completed', '2026-06-04 22:02:02', '2026-06-04 22:02:02'),
(5, 1, 'Mina', 'mina0702022@gmail.com', '70771351', 'pp', 199.90, 'bank_transfer', 'completed', '2026-06-04 22:06:52', '2026-06-04 22:06:52'),
(6, 2, 'nn', 'nn@gmail.com', '70742577', 'PP', 199.70, 'credit_card', 'completed', '2026-06-06 22:24:27', '2026-06-06 22:24:27'),
(7, 4, 'Nana', 'nana@gmail.com', '70771352', 'nana PP', 199.70, 'cash_on_delivery', 'completed', '2026-06-07 21:39:07', '2026-06-07 21:39:07'),
(8, 1, 'ramo', 'ramo@gmail.com', '70771359', 'PP', 627.00, 'cash_on_delivery', 'completed', '2026-06-24 18:26:52', '2026-06-24 18:26:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Smart Fitness Tracker', 199.70, 1, '2026-06-03 03:33:17', '2026-06-03 03:33:17'),
(2, 2, 3, 'Smart Fitness Tracker', 199.70, 3, '2026-06-03 19:22:06', '2026-06-03 19:22:06'),
(3, 3, 4, 'claude', 100.99, 1, '2026-06-03 19:29:57', '2026-06-03 19:29:57'),
(4, 4, 3, 'Smart Fitness Tracker', 199.70, 1, '2026-06-04 22:02:02', '2026-06-04 22:02:02'),
(5, 5, 1, 'Sport', 199.90, 1, '2026-06-04 22:06:52', '2026-06-04 22:06:52'),
(6, 6, 3, 'Smart Fitness Tracker', 199.70, 1, '2026-06-06 22:24:27', '2026-06-06 22:24:27'),
(7, 7, 3, 'Smart Fitness Tracker', 199.70, 1, '2026-06-07 21:39:07', '2026-06-07 21:39:07'),
(8, 8, 9, 'Modern Flatlay & Design Objects', 209.00, 3, '2026-06-24 18:26:52', '2026-06-24 18:26:52');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view Products', 'web', '2026-05-20 20:14:08', '2026-05-20 20:14:08'),
(2, 'view dashboard', 'web', '2026-06-24 05:39:26', '2026-06-24 05:39:26'),
(3, 'Background tracking', 'web', '2026-06-24 05:42:06', '2026-06-24 05:42:06'),
(4, 'Hardware access', 'web', '2026-06-24 05:42:19', '2026-06-24 05:42:19'),
(5, 'view consumer', 'web', '2026-06-24 18:23:43', '2026-06-24 18:23:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_kh` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `sales` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `name_kh`, `image`, `slug`, `description`, `price`, `category_id`, `stock`, `is_active`, `is_featured`, `views`, `sales`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'Sport', 'ប្រភេទ', 'products/5S6J52h7tU4WIxS3ZP415lDMQo8sRAobBLaIB1XR.avif', 'sport-1779330575', 'In commerce and marketing, a product is anything of value offered to a market to satisfy a customer\'s need or want. This encompasses tangible physical goods, intangible digital assets, and interactive services.', 199.90, NULL, 999, 1, 1, 0, 0, 0.00, '2026-05-20 19:29:35', '2026-06-04 22:06:52'),
(2, 'Minimalist Leather Watch', 'នាឡិកាស្បែកបែប Minimalist', 'products/yOr0XFn3ycNtJmMbk8cXNOiGygP7mMKinwgr8dgR.avif', 'minimalist-leather-watch-1779334101', 'Minimalist Leather Watch', 122.90, 3, 100, 1, 1, 0, 0, 0.00, '2026-05-20 20:28:21', '2026-06-02 20:55:15'),
(3, 'Smart Fitness Tracker', 'កម្មវិធីតាមដានសុខភាពឆ្លាតវៃ', 'products/TfQlGhEbUDEHARij1ME3x59iICTRtqagOjPAroST.avif', 'smart-fitness-tracker-1779335659', 'Smart fitness trackers are versatile wearables designed to monitor your health, physical activity, and sleep. Depending on your goals, you can choose between traditional bands with screens, screenless trackers for discreet wear, or comprehensive smartwatches that offer offline maps, calling, and mobile payments.', 199.70, 5, 7, 1, 1, 0, 0, 0.00, '2026-05-20 20:54:19', '2026-06-07 21:39:07'),
(4, 'claude', 'ai', 'products/lHoi3Z9VopQYXOKRjyDej2h2xIt9gneZjanyxvTY.jpg', 'claude-1779551175', 'A kitchen is the heart of the home, combining food preparation, dining, and social interaction. Achieving a balance between practical ergonomics and timeless style is essential.', 100.99, 7, 4, 1, 1, 0, 0, 0.00, '2026-05-23 08:45:00', '2026-06-24 06:17:13'),
(5, 'NGUON USA', 'NGUON USA', NULL, 'nguon-usa-1779789969', 'NGUON USA', 199.90, NULL, 10, 1, 1, 0, 0, 0.00, '2026-05-26 03:06:09', '2026-06-02 20:53:09'),
(6, 'Sleek Minimalist Fashion With Strap Dial Women\'s', 'ម៉ូដ​សាមញ្ញ​ទាន់សម័យ​ជាមួយ​ខ្សែ​នាឡិកា​សម្រាប់​នារី', 'products/ztIJZi0579RTTexJP7byZCwqFH7XmfrhrS09JJ3e.jpg', 'sleek-minimalist-fashion-with-strap-dial-womens-1780808286', NULL, 10000.00, 2, 10, 1, 0, 0, 0, 0.00, '2026-06-06 21:58:07', '2026-06-06 21:58:07'),
(7, 'Minimalist Studio Rack & Apparel', NULL, 'products/meyUrXNzU7h9s4RY2plk6OozngxKu5jRNPFW4PZx.avif', 'minimalist-studio-rack-apparel-1781166832', 'Minimalist Studio Rack & Apparel', 199.90, 2, 100, 1, 1, 0, 0, 0.00, '2026-06-11 01:33:52', '2026-06-11 01:35:24'),
(8, 'Neutral Tone Luxury Wardrobe', 'ទូខោអាវប្រណីតពណ៌អព្យាក្រឹត', 'products/91nX5abUCovVTNovZ3m4ApbMyC3gttSlh99dTMDk.avif', 'neutral-tone-luxury-wardrobe-1781167078', 'Neutral Tone Luxury Wardrobe', 299.00, 2, 100, 1, 1, 0, 0, 0.00, '2026-06-11 01:37:58', '2026-06-11 01:40:13'),
(9, 'Modern Flatlay & Design Objects', 'វត្ថុរចនា និង​ប្លង់​ទំនើបៗ', 'products/Ood32ooUdUA7EknvYFiKWlz6kMNoX8xva3VLZ8A9.avif', 'modern-flatlay-design-objects-1781167157', 'Modern Flatlay & Design Objects', 209.00, 2, 97, 1, 1, 0, 0, 0.00, '2026-06-11 01:39:17', '2026-06-24 18:26:52'),
(10, 'Bright Architectural Living Space', 'កន្លែងរស់នៅបែបស្ថាបត្យកម្មភ្លឺស្វាង', 'products/mbqzv6MOU0kl1t6gJiCZOf4Pa8jGDFt8ItQsikv3.avif', 'bright-architectural-living-space-1781167382', 'Bright Architectural Living Space', 999.99, 6, 100, 1, 1, 0, 0, 0.00, '2026-06-11 01:43:02', '2026-06-11 01:43:14'),
(11, 'Contemporary Neutral Fashion Detail', 'ម៉ូដទាន់សម័យអព្យាក្រឹត', 'products/bMqn7Zy7Cyl1eI5nE1vpE5UvYFj2Gzu9MIrA7Fp3.avif', 'contemporary-neutral-fashion-detail-1781167465', 'Contemporary Neutral Fashion Detail', 799.00, 2, 100, 1, 1, 0, 0, 0.00, '2026-06-11 01:44:25', '2026-06-11 01:44:44'),
(12, 'Premium Crafted Linen & Textures', 'ក្រណាត់ទេសឯក និងវាយនភាពផលិតដោយប្រណិត', 'products/Wvhv1iURdg1UZqVSTkiYZmvHW3UMAqHuniUICylF.avif', 'premium-crafted-linen-textures-1781167539', 'Premium Crafted Linen & Textures', 101.00, 2, 80, 1, 1, 0, 0, 0.00, '2026-06-11 01:45:39', '2026-06-11 01:46:03'),
(13, 'Bright Interior Minimal Workspace', 'ផ្ទៃខាងក្នុងភ្លឺចែងចាំង កន្លែងធ្វើការតិចតួចបំផុត', 'products/gb62q59wfOWfbWTebSjeSd5p0rzPPZVYbUMTqqgZ.avif', 'bright-interior-minimal-workspace-1781167612', 'Bright Interior Minimal Workspace', 79.00, 2, 70, 1, 1, 0, 0, 0.00, '2026-06-11 01:46:52', '2026-06-11 01:47:05'),
(14, 'Foods to Eat to help you lose Weight', 'អាហារដែលត្រូវញ៉ាំដើម្បីជួយអ្នកឱ្យស្រកទម្ងន់', 'products/b2A650AANVwo5OFPdm4ptOCe1epvhFy9FnoP4w4c.jpg', 'foods-to-eat-to-help-you-lose-weight-1782307249', 'description Foods to Eat to help you lose Weight\r\nWhen it comes to weight loss, fiber is crucial. It\'s satiating because it slows digestion and keeps us feeling fuller longer. This is super important when we\'re cutting back on calories, a common approach to weight loss. Consuming a serving of chia seeds—roughly 2 tablespoons—satisfies about a quarter of daily fiber needs.1\r\nU.S. Department of Agriculture. FoodData Central. Chia seeds.\r\n\r\n Chia seeds are easy to incorporate into meals, especially breakfast and snacks on top of yogurt bowls or in smoothies.', 59.90, 7, 52, 1, 1, 0, 0, 0.00, '2026-06-24 06:20:49', '2026-06-24 18:21:28');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'building A', 'web', '2026-05-20 20:14:29', '2026-05-20 20:14:29'),
(2, 'Role', 'web', '2026-06-24 05:36:33', '2026-06-24 05:36:33'),
(3, 'edit product', 'web', '2026-06-24 16:35:12', '2026-06-24 16:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('WnlHVCH3Kkl4mSP15Tiy3RvWmAH9F97UYDxk3Fcz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJNVGlzZkk3MVdxT0taMDFQZDc5U0I2VVhlYXBOUlYwV0g2MEtIZlA4IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifSwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2NhdGVnb3JpZXMifX0=', 1782369550);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_kh` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `title`, `title_kh`, `image`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'hell slides', NULL, NULL, 'hell-slides-2279', 'hi', 1, '2026-06-19 19:46:42', '2026-06-19 19:46:42'),
(2, 'cc', 'cc', 'slides/od0xod6YdXRIw6YoWhJVU5eFE84B5IsN44rkdxvg.jpg', 'cc-6987', 'cc', 1, '2026-06-24 00:24:14', '2026-06-24 00:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ramo Ut', 'ramo0702022@gmail.com', NULL, '$2y$12$XHECpRSFgCq2XPYTIg5h0OQ6ZQjaDa7Dc7e6YoDSOyGAiDc9OePhm', NULL, '2026-05-20 19:24:52', '2026-05-20 19:24:52'),
(2, 'cc', 'cc2@gmail.com', NULL, '$2y$12$U8CVXVNA0/0iPuh1a3B5qOYNts73rpAWyPhBwMeFpBQ6bz0PbMpRG', NULL, '2026-05-20 20:18:08', '2026-05-20 20:18:08'),
(3, 'consumer', 'consumer@gmail.com', NULL, '$2y$12$CZLldap8/e5GOvjqO3.kaOItNO6n9SgvQq.PBm79rfAQzWM.PA.jq', NULL, '2026-06-06 22:46:38', '2026-06-06 22:46:38'),
(4, 'Nana', 'nana@gmail.com', NULL, '$2y$12$KeXFMx5xy8h7puI0Q1pQWugxIaA3LC/rcLEbtS4RZbjOFCGtyMyiK', NULL, '2026-06-07 21:39:07', '2026-06-07 21:39:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slides_slug_unique` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
