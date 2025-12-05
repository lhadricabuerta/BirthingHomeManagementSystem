-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: bhms-my-ai-chatbot.i.aivencloud.com:10392
-- Generation Time: Dec 05, 2025 at 01:49 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lbh_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int NOT NULL,
  `village` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int NOT NULL,
  `client_id` int UNSIGNED NOT NULL,
  `branch_id` int NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_status`
--

CREATE TABLE `appointment_status` (
  `id` int NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `appointment_summary`
-- (See below for the actual view)
--
CREATE TABLE `appointment_summary` (
`appointment_created` timestamp
,`appointment_date` date
,`appointment_reason` text
,`appointment_time` time
,`appointment_updated` timestamp
,`branch` varchar(100)
,`client_name` varchar(201)
,`messenger_id` varchar(50)
,`status` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `baby_additional_info`
--

CREATE TABLE `baby_additional_info` (
  `id` bigint UNSIGNED NOT NULL,
  `registration_id` bigint UNSIGNED NOT NULL,
  `marriage_date` date DEFAULT NULL,
  `marriage_place` varchar(255) DEFAULT NULL,
  `birth_attendant` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `baby_fathers`
--

CREATE TABLE `baby_fathers` (
  `id` bigint UNSIGNED NOT NULL,
  `registration_id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `citizenship` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `baby_mothers`
--

CREATE TABLE `baby_mothers` (
  `id` bigint UNSIGNED NOT NULL,
  `registration_id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `maiden_middle_name` varchar(100) DEFAULT NULL,
  `citizenship` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `total_children_alive` int DEFAULT NULL,
  `children_still_living` int DEFAULT NULL,
  `children_deceased` int DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `baby_registrations`
--

CREATE TABLE `baby_registrations` (
  `id` bigint UNSIGNED NOT NULL,
  `delivery_id` bigint UNSIGNED NOT NULL,
  `baby_first_name` varchar(100) DEFAULT NULL,
  `baby_middle_name` varchar(100) DEFAULT NULL,
  `baby_last_name` varchar(100) DEFAULT NULL,
  `sex` enum('male','female') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `time_of_birth` time DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `type_of_birth` enum('single','twin','triplet') DEFAULT NULL,
  `birth_order` varchar(50) DEFAULT NULL,
  `weight_at_birth` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int NOT NULL,
  `branch_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int UNSIGNED NOT NULL,
  `messenger_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address_id` int DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `client_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_status`
--

CREATE TABLE `delivery_status` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emergency`
--

CREATE TABLE `emergency` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intrapartum_records`
--

CREATE TABLE `intrapartum_records` (
  `id` bigint UNSIGNED NOT NULL,
  `delivery_id` bigint UNSIGNED NOT NULL,
  `remarks_id` bigint UNSIGNED DEFAULT NULL,
  `bp` varchar(20) DEFAULT NULL,
  `temp` varchar(10) DEFAULT NULL,
  `rr` varchar(20) DEFAULT NULL,
  `pr` varchar(20) DEFAULT NULL,
  `fundic_height` varchar(20) DEFAULT NULL,
  `fetal_heart_tone` varchar(20) DEFAULT NULL,
  `internal_exam` varchar(50) DEFAULT NULL,
  `bag_of_water` enum('intact','ruptured') DEFAULT NULL,
  `baby_delivered` enum('yes','no') DEFAULT NULL,
  `placenta_delivered` enum('yes','no') DEFAULT NULL,
  `baby_sex` enum('male','female') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` bigint UNSIGNED NOT NULL,
  `item_name` varchar(150) NOT NULL,
  `category_id` int NOT NULL,
  `batch_no` varchar(100) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `unit_id` int NOT NULL,
  `reorder_level` int DEFAULT '10',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marital_status`
--

CREATE TABLE `marital_status` (
  `id` int NOT NULL,
  `marital_status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maternal_vitals`
--

CREATE TABLE `maternal_vitals` (
  `id` bigint UNSIGNED NOT NULL,
  `prenatal_visit_id` bigint UNSIGNED NOT NULL,
  `fht` smallint DEFAULT NULL,
  `fh` decimal(4,1) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `blood_pressure` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature` decimal(4,1) DEFAULT NULL,
  `respiratory_rate` smallint DEFAULT NULL,
  `pulse_rate` smallint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` int UNSIGNED NOT NULL,
  `patient_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marital_status_id` int DEFAULT NULL,
  `branch_id` int DEFAULT NULL,
  `age` int DEFAULT NULL,
  `spouse_fname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_lname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_deliveries`
--

CREATE TABLE `patient_deliveries` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `delivery_status_id` bigint UNSIGNED DEFAULT NULL,
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `prenatal_visit_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_immunizations`
--

CREATE TABLE `patient_immunizations` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `prenatal_visit_id` bigint UNSIGNED NOT NULL,
  `notes` text,
  `immunized_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_immunization_items`
--

CREATE TABLE `patient_immunization_items` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_immunization_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_medications`
--

CREATE TABLE `patient_medications` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `prescribed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_medication_items`
--

CREATE TABLE `patient_medication_items` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_medication_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_pdf_records`
--

CREATE TABLE `patient_pdf_records` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `prenatal_visit_id` bigint UNSIGNED DEFAULT NULL,
  `intrapartum_record_id` bigint UNSIGNED DEFAULT NULL,
  `postpartum_record_id` bigint UNSIGNED DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_data` longblob NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `baby_registration_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postpartum_records`
--

CREATE TABLE `postpartum_records` (
  `id` bigint UNSIGNED NOT NULL,
  `delivery_id` bigint UNSIGNED NOT NULL,
  `remarks_id` bigint UNSIGNED DEFAULT NULL,
  `postpartum_bp` varchar(20) DEFAULT NULL,
  `postpartum_temp` varchar(10) DEFAULT NULL,
  `postpartum_rr` varchar(20) DEFAULT NULL,
  `postpartum_pr` varchar(20) DEFAULT NULL,
  `newborn_weight` varchar(20) DEFAULT NULL,
  `newborn_hc` varchar(20) DEFAULT NULL,
  `newborn_cc` varchar(20) DEFAULT NULL,
  `newborn_ac` varchar(20) DEFAULT NULL,
  `newborn_length` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prenatal_status`
--

CREATE TABLE `prenatal_status` (
  `id` bigint UNSIGNED NOT NULL,
  `status_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prenatal_visit`
--

CREATE TABLE `prenatal_visit` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` int UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `prenatal_status_id` bigint UNSIGNED DEFAULT NULL,
  `remarks_id` bigint UNSIGNED DEFAULT NULL,
  `lmp` date DEFAULT NULL,
  `edc` date DEFAULT NULL,
  `aog` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravida` tinyint DEFAULT NULL,
  `para` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `id` bigint UNSIGNED NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','on-leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_work_days`
--

CREATE TABLE `staff_work_days` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `day` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shift` enum('Day','Night') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Day'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `two_factor_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visit_info`
--

CREATE TABLE `visit_info` (
  `id` bigint UNSIGNED NOT NULL,
  `prenatal_visit_id` bigint UNSIGNED NOT NULL,
  `branch_id` int DEFAULT NULL,
  `visit_number` tinyint NOT NULL,
  `visit_date` date NOT NULL,
  `next_visit_date` date DEFAULT NULL,
  `next_visit_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `appointment_summary`
--
DROP TABLE IF EXISTS `appointment_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`avnadmin`@`%` SQL SECURITY DEFINER VIEW `appointment_summary`  AS SELECT `c`.`messenger_id` AS `messenger_id`, concat(`c`.`first_name`,' ',`c`.`last_name`) AS `client_name`, `a`.`appointment_date` AS `appointment_date`, `a`.`appointment_time` AS `appointment_time`, `b`.`branch_name` AS `branch`, `a`.`appointment_reason` AS `appointment_reason`, `s`.`status_name` AS `status`, `a`.`created_at` AS `appointment_created`, `a`.`updated_at` AS `appointment_updated` FROM (((`appointment` `a` join `client` `c` on((`a`.`client_id` = `c`.`id`))) join `branch` `b` on((`a`.`branch_id` = `b`.`id`))) join `appointment_status` `s` on((`a`.`status_id` = `s`.`id`))) ORDER BY `a`.`appointment_date` ASC, `a`.`appointment_time` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_user` (`user_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `appointment_ibfk_1` (`client_id`);

--
-- Indexes for table `appointment_status`
--
ALTER TABLE `appointment_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_name` (`status_name`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `baby_additional_info`
--
ALTER TABLE `baby_additional_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bai_registration` (`registration_id`);

--
-- Indexes for table `baby_fathers`
--
ALTER TABLE `baby_fathers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bf_registration` (`registration_id`),
  ADD KEY `fk_bf_patient` (`patient_id`);

--
-- Indexes for table `baby_mothers`
--
ALTER TABLE `baby_mothers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bm_registration` (`registration_id`),
  ADD KEY `fk_bm_patient` (`patient_id`);

--
-- Indexes for table `baby_registrations`
--
ALTER TABLE `baby_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_br_delivery` (`delivery_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `messenger_id` (`messenger_id`),
  ADD KEY `fk_client_address` (`address_id`);

--
-- Indexes for table `delivery_status`
--
ALTER TABLE `delivery_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency`
--
ALTER TABLE `emergency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `intrapartum_records`
--
ALTER TABLE `intrapartum_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_intra_delivery` (`delivery_id`),
  ADD KEY `fk_intrapartum_remarks` (`remarks_id`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `idx_item_name` (`item_name`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `marital_status`
--
ALTER TABLE `marital_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maternal_vitals`
--
ALTER TABLE `maternal_vitals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maternal_vitals_prenatal_visit_id_foreign` (`prenatal_visit_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_id` (`patient_id`),
  ADD KEY `client_details_client_id_foreign` (`client_id`),
  ADD KEY `fk_patient_marital_status` (`marital_status_id`),
  ADD KEY `fk_patient_branch` (`branch_id`);

--
-- Indexes for table `patient_deliveries`
--
ALTER TABLE `patient_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pd_patient` (`patient_id`),
  ADD KEY `fk_pd_staff` (`staff_id`),
  ADD KEY `fk_pd_status` (`delivery_status_id`),
  ADD KEY `fk_prenatal_visit` (`prenatal_visit_id`);

--
-- Indexes for table `patient_immunizations`
--
ALTER TABLE `patient_immunizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient_immunizations_patient` (`patient_id`),
  ADD KEY `fk_patient_immunizations_prenatal` (`prenatal_visit_id`);

--
-- Indexes for table `patient_immunization_items`
--
ALTER TABLE `patient_immunization_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient_immunization` (`patient_immunization_id`),
  ADD KEY `fk_patient_immunization_item` (`item_id`);

--
-- Indexes for table `patient_medications`
--
ALTER TABLE `patient_medications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient_medications_patient` (`patient_id`);

--
-- Indexes for table `patient_medication_items`
--
ALTER TABLE `patient_medication_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_medication_items_parent` (`patient_medication_id`),
  ADD KEY `fk_medication_items_inventory` (`item_id`);

--
-- Indexes for table `patient_pdf_records`
--
ALTER TABLE `patient_pdf_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_pdf_records_patient_id_foreign` (`patient_id`),
  ADD KEY `patient_pdf_records_prenatal_visit_id_foreign` (`prenatal_visit_id`),
  ADD KEY `fk_baby_registration` (`baby_registration_id`),
  ADD KEY `fk_pdf_intrapartum` (`intrapartum_record_id`),
  ADD KEY `fk_pdf_postpartum` (`postpartum_record_id`);

--
-- Indexes for table `postpartum_records`
--
ALTER TABLE `postpartum_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_delivery` (`delivery_id`),
  ADD KEY `fk_postpartum_remarks` (`remarks_id`);

--
-- Indexes for table `prenatal_status`
--
ALTER TABLE `prenatal_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `consultation_status_status_name_unique` (`status_name`);

--
-- Indexes for table `prenatal_visit`
--
ALTER TABLE `prenatal_visit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prenatal_visit_client_id_foreign` (`client_id`),
  ADD KEY `fk_prenatal_staff` (`staff_id`),
  ADD KEY `fk_prenatal_status` (`prenatal_status_id`),
  ADD KEY `fk_prenatal_remarks` (`remarks_id`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_staff_id_unique` (`staff_id`),
  ADD KEY `staff_user_id_foreign` (`user_id`),
  ADD KEY `fk_branch_id` (`branch_id`);

--
-- Indexes for table `staff_work_days`
--
ALTER TABLE `staff_work_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_work_days_staff` (`staff_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visit_info`
--
ALTER TABLE `visit_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visit_info_prenatal_visit_id_foreign` (`prenatal_visit_id`),
  ADD KEY `idx_branch_id` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_status`
--
ALTER TABLE `appointment_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `baby_additional_info`
--
ALTER TABLE `baby_additional_info`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `baby_fathers`
--
ALTER TABLE `baby_fathers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `baby_mothers`
--
ALTER TABLE `baby_mothers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `baby_registrations`
--
ALTER TABLE `baby_registrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_status`
--
ALTER TABLE `delivery_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency`
--
ALTER TABLE `emergency`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intrapartum_records`
--
ALTER TABLE `intrapartum_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marital_status`
--
ALTER TABLE `marital_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maternal_vitals`
--
ALTER TABLE `maternal_vitals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_deliveries`
--
ALTER TABLE `patient_deliveries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_immunizations`
--
ALTER TABLE `patient_immunizations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_immunization_items`
--
ALTER TABLE `patient_immunization_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_medications`
--
ALTER TABLE `patient_medications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_medication_items`
--
ALTER TABLE `patient_medication_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_pdf_records`
--
ALTER TABLE `patient_pdf_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postpartum_records`
--
ALTER TABLE `postpartum_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prenatal_status`
--
ALTER TABLE `prenatal_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prenatal_visit`
--
ALTER TABLE `prenatal_visit`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_work_days`
--
ALTER TABLE `staff_work_days`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visit_info`
--
ALTER TABLE `visit_info`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `appointment_status` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `baby_additional_info`
--
ALTER TABLE `baby_additional_info`
  ADD CONSTRAINT `fk_bai_registration` FOREIGN KEY (`registration_id`) REFERENCES `baby_registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `baby_fathers`
--
ALTER TABLE `baby_fathers`
  ADD CONSTRAINT `fk_bf_patient` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bf_registration` FOREIGN KEY (`registration_id`) REFERENCES `baby_registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `baby_mothers`
--
ALTER TABLE `baby_mothers`
  ADD CONSTRAINT `fk_bm_patient` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bm_registration` FOREIGN KEY (`registration_id`) REFERENCES `baby_registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `baby_registrations`
--
ALTER TABLE `baby_registrations`
  ADD CONSTRAINT `fk_br_delivery` FOREIGN KEY (`delivery_id`) REFERENCES `patient_deliveries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_client_address` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `emergency`
--
ALTER TABLE `emergency`
  ADD CONSTRAINT `emergency_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `intrapartum_records`
--
ALTER TABLE `intrapartum_records`
  ADD CONSTRAINT `fk_intra_delivery` FOREIGN KEY (`delivery_id`) REFERENCES `patient_deliveries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_intrapartum_remarks` FOREIGN KEY (`remarks_id`) REFERENCES `remarks` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD CONSTRAINT `inventory_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `inventory_items_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `maternal_vitals`
--
ALTER TABLE `maternal_vitals`
  ADD CONSTRAINT `maternal_vitals_prenatal_visit_id_foreign` FOREIGN KEY (`prenatal_visit_id`) REFERENCES `prenatal_visit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `client_details_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_patient_branch` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_patient_marital_status` FOREIGN KEY (`marital_status_id`) REFERENCES `marital_status` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `patient_deliveries`
--
ALTER TABLE `patient_deliveries`
  ADD CONSTRAINT `fk_pd_patient` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `fk_pd_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `fk_pd_status` FOREIGN KEY (`delivery_status_id`) REFERENCES `delivery_status` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_prenatal_visit` FOREIGN KEY (`prenatal_visit_id`) REFERENCES `prenatal_visit` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `patient_immunizations`
--
ALTER TABLE `patient_immunizations`
  ADD CONSTRAINT `fk_patient_immunizations_patient` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_patient_immunizations_prenatal` FOREIGN KEY (`prenatal_visit_id`) REFERENCES `prenatal_visit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_immunization_items`
--
ALTER TABLE `patient_immunization_items`
  ADD CONSTRAINT `fk_patient_immunization` FOREIGN KEY (`patient_immunization_id`) REFERENCES `patient_immunizations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_patient_immunization_item` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_medications`
--
ALTER TABLE `patient_medications`
  ADD CONSTRAINT `fk_patient_medications_patient` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_medication_items`
--
ALTER TABLE `patient_medication_items`
  ADD CONSTRAINT `fk_medication_items_inventory` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `fk_medication_items_parent` FOREIGN KEY (`patient_medication_id`) REFERENCES `patient_medications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_pdf_records`
--
ALTER TABLE `patient_pdf_records`
  ADD CONSTRAINT `fk_baby_registration` FOREIGN KEY (`baby_registration_id`) REFERENCES `baby_registrations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pdf_intrapartum` FOREIGN KEY (`intrapartum_record_id`) REFERENCES `intrapartum_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pdf_postpartum` FOREIGN KEY (`postpartum_record_id`) REFERENCES `postpartum_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_pdf_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_pdf_records_prenatal_visit_id_foreign` FOREIGN KEY (`prenatal_visit_id`) REFERENCES `prenatal_visit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `postpartum_records`
--
ALTER TABLE `postpartum_records`
  ADD CONSTRAINT `fk_post_delivery` FOREIGN KEY (`delivery_id`) REFERENCES `patient_deliveries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_postpartum_remarks` FOREIGN KEY (`remarks_id`) REFERENCES `remarks` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `prenatal_visit`
--
ALTER TABLE `prenatal_visit`
  ADD CONSTRAINT `fk_prenatal_remarks` FOREIGN KEY (`remarks_id`) REFERENCES `remarks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_prenatal_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prenatal_status` FOREIGN KEY (`prenatal_status_id`) REFERENCES `prenatal_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prenatal_visit_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `fk_branch_id` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `staff_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_work_days`
--
ALTER TABLE `staff_work_days`
  ADD CONSTRAINT `fk_work_days_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_work_days_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
