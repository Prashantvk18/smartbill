-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2025 at 02:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartbill`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_data`
--

CREATE TABLE `bill_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `bill_no` varchar(255) NOT NULL,
  `bill_date` date NOT NULL,
  `whatsapp_number` varchar(15) DEFAULT NULL,
  `is_warranty` tinyint(1) NOT NULL DEFAULT 0,
  `is_guarantee` tinyint(1) NOT NULL DEFAULT 0,
  `details` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_sign` tinyint(1) NOT NULL DEFAULT 0,
  `is_stamp` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `pdf_send` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_pdf` tinyint(1) NOT NULL DEFAULT 0,
  `pdf_generate_date` date DEFAULT NULL,
  `pdf_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_data`
--

INSERT INTO `bill_data` (`id`, `shop_id`, `customer_name`, `bill_no`, `bill_date`, `whatsapp_number`, `is_warranty`, `is_guarantee`, `details`, `total_amount`, `paid`, `balance`, `is_sign`, `is_stamp`, `created_by`, `updated_by`, `pdf_send`, `created_at`, `updated_at`, `is_pdf`, `pdf_generate_date`, `pdf_path`) VALUES
(1, 1, 'Pranay', '12345-2025-0001', '2025-12-22', '8652897550', 0, 0, NULL, 35.00, 35.00, 0.00, 1, 1, 1, NULL, 0, '2025-12-22 03:43:07', '2025-12-23 07:39:33', 0, NULL, NULL),
(3, 1, 'Ramesh', '12345-2025-0002', '2025-12-23', NULL, 1, 0, '6 month cement warranty', 560.00, 60.00, 500.00, 0, 1, 1, NULL, 1, '2025-12-23 01:56:35', '2025-12-23 06:39:22', 1, '2025-12-23', 'bills/12345-2025-0002.pdf'),
(4, 1, 'Ramesh', '12345-2025-0003', '2025-12-23', '8652897550', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, 1, NULL, 1, '2025-12-23 04:54:24', '2025-12-23 06:44:03', 1, '2025-12-23', 'bills/12345-2025-0003.pdf'),
(5, 1, 'Gitanjali', '12345-2025-0004', '2025-12-23', '8652897550', 1, 0, 'Paint warranty 6 month', 325.00, 325.00, 0.00, 0, 0, 1, NULL, 0, '2025-12-23 07:41:14', '2025-12-23 07:44:46', 1, '2025-12-23', 'bills/12345-2025-0004.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `item_data`
--

CREATE TABLE `item_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` bigint(20) UNSIGNED NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_data`
--

INSERT INTO `item_data` (`id`, `bill_id`, `bill_no`, `item_name`, `quantity`, `price`, `added_by`, `created_at`, `updated_at`) VALUES
(14, 3, '12345-2025-0002', 'Cement', 10, 50.00, 1, '2025-12-23 05:30:41', '2025-12-23 05:30:41'),
(15, 3, '12345-2025-0002', 'Sutali', 10, 2.00, 1, '2025-12-23 05:30:41', '2025-12-23 05:30:41'),
(16, 3, '12345-2025-0002', 'Screw', 20, 2.00, 1, '2025-12-23 05:30:41', '2025-12-23 05:30:41'),
(17, 1, '12345-2025-0001', 'Wire', 1, 10.00, 1, '2025-12-23 07:39:14', '2025-12-23 07:39:14'),
(18, 1, '12345-2025-0001', 'Screw', 5, 5.00, 1, '2025-12-23 07:39:14', '2025-12-23 07:39:14'),
(25, 5, '12345-2025-0004', 'Paint', 2, 100.00, 1, '2025-12-23 07:44:41', '2025-12-23 07:44:41'),
(26, 5, '12345-2025-0004', 'Brush', 5, 15.00, 1, '2025-12-23 07:44:41', '2025-12-23 07:44:41'),
(27, 5, '12345-2025-0004', 'Wire', 5, 10.00, 1, '2025-12-23 07:44:41', '2025-12-23 07:44:41');

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
(4, '2025_12_20_090240_create_shops_table', 2),
(5, '2025_12_22_070026_create_shop_payments_table', 3),
(6, '2025_12_22_081514_add_column_shops_table', 4),
(7, '2025_12_22_082134_create_bill_data_table', 4),
(8, '2025_12_22_082338_create_item_data_table', 4),
(9, '2025_12_22_115655_add_pdf_columns_to_bill_data_table', 5),
(10, '2025_12_22_115934_add_address_to_shops_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_code` varchar(5) NOT NULL,
  `address` text DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `dop` date DEFAULT NULL,
  `doe` date DEFAULT NULL,
  `signature_path` varchar(255) DEFAULT NULL,
  `stamp_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `shop_name`, `shop_code`, `address`, `owner_id`, `created_by`, `updated_by`, `is_paid`, `paid_amount`, `dop`, `doe`, `signature_path`, `stamp_path`, `created_at`, `updated_at`) VALUES
(1, 'Mahalaxmi Steel', '12345', 'Near Panchpakadi Road No 23 Wagle Estate Thane(w) 400604', 1, 1, 1, 1, 1000.00, '2025-12-23', '2026-12-23', 'shops/signatures/mwhPFDE91VPflIywaeeHVwXSn2DuSedPbvpUpo38.png', 'shops/stamps/QH5zyx9N6DCEx5gZF68XM4WkK1JxdDt7zFnLdUg7.png', '2025-12-20 03:39:43', '2025-12-23 07:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `shop_payments`
--

CREATE TABLE `shop_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `activated_by` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `dop` date NOT NULL,
  `doe` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop_payments`
--

INSERT INTO `shop_payments` (`id`, `shop_id`, `activated_by`, `amount`, `dop`, `doe`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1000.00, '2025-12-22', '2026-12-22', '2025-12-22 01:39:43', '2025-12-22 01:39:43'),
(2, 1, 1, 1000.00, '2025-12-23', '2026-12-23', '2025-12-23 07:47:26', '2025-12-23 07:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `unique_name` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `unique_name`, `mobile`, `dob`, `password`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'Pranay', 'Paddy18', '8652897550', '1999-11-06', '$2y$12$oM6tM7qPy3FqEUaxAs.bae2UoXamCsugQ3GtXxCkUpBc/IzTxnEsi', 1, '2025-12-20 03:06:32', '2025-12-22 01:24:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill_data`
--
ALTER TABLE `bill_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bill_data_bill_no_unique` (`bill_no`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `item_data`
--
ALTER TABLE `item_data`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shops_shop_code_unique` (`shop_code`);

--
-- Indexes for table `shop_payments`
--
ALTER TABLE `shop_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_payments_shop_id_foreign` (`shop_id`),
  ADD KEY `shop_payments_activated_by_foreign` (`activated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_unique_name_unique` (`unique_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill_data`
--
ALTER TABLE `bill_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_data`
--
ALTER TABLE `item_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shop_payments`
--
ALTER TABLE `shop_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `shop_payments`
--
ALTER TABLE `shop_payments`
  ADD CONSTRAINT `shop_payments_activated_by_foreign` FOREIGN KEY (`activated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shop_payments_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
