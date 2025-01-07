-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 23, 2024 at 11:57 AM
-- Server version: 8.0.40
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_logi_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

DROP TABLE IF EXISTS `balances`;
CREATE TABLE IF NOT EXISTS `balances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `balances_student_id_foreign` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `center`
--

DROP TABLE IF EXISTS `center`;
CREATE TABLE IF NOT EXISTS `center` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `center_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `center`
--

INSERT INTO `center` (`id`, `name`, `address`, `mobile`, `email`, `image`, `created_at`, `updated_at`) VALUES
(1, 'LogipromptTechnoSolutions', 'Opp:, Technopark Phase-1, Pallinada, Kazhakkoottam, Thiruvananthapuram, Kerala', '8921866155', 'logitechnosolutions@gmail.com', 'image/1734952066_logilogo.jpg', '2024-12-23 11:07:46', '2024-12-23 11:07:46'),
(2, 'Logiprompt ProAcademy', 'Opp:, Technopark Phase-1, Pallinada, Kazhakkoottam, Thiruvananthapuram, Kerala', '8921866154', 'logipromptproaccademy@gmail.com', 'image/1734952264_proaccademy.jpg', '2024-12-23 11:11:04', '2024-12-23 11:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `client_details`
--

DROP TABLE IF EXISTS `client_details`;
CREATE TABLE IF NOT EXISTS `client_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `salutation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ProfilePicture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobileDialCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `officialWebsite` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `officePhone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyAddress` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shippingAddress` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_details`
--

INSERT INTO `client_details` (`id`, `salutation`, `name`, `ProfilePicture`, `country`, `mobileDialCode`, `mobile`, `gender`, `companyName`, `officialWebsite`, `gstNumber`, `officePhone`, `city`, `state`, `postalCode`, `companyAddress`, `shippingAddress`, `note`, `logo`, `userId`, `created_at`, `updated_at`) VALUES
(1, 'Ms', 'Jenny', 'profilePicture/1734951432_teacher.jfif', 'IN', '91', '9076543212', 'Female', 'Jenny group', 'www.jennygroup.com', 'MJ567URF34ED78', '9876564578', 'TVM', 'Kerala', '678954', 'Tvm, Kerala', 'Tvm, Kerala', 'ok', 'logo/1734951432_h1.jfif', '2', '2024-12-23 10:57:12', '2024-12-23 10:57:12');

-- --------------------------------------------------------

--
-- Table structure for table `client_invoice_details`
--

DROP TABLE IF EXISTS `client_invoice_details`;
CREATE TABLE IF NOT EXISTS `client_invoice_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoiceDate` date NOT NULL,
  `clientName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionMethod` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoiceNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionTitle` json NOT NULL,
  `unitPrice` json NOT NULL,
  `description` json DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount` json DEFAULT NULL,
  `gsts` json DEFAULT NULL,
  `bankAccount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstamount` decimal(8,2) DEFAULT NULL,
  `subtotal` decimal(8,2) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_invoice_details_invoicenumber_unique` (`invoiceNumber`),
  UNIQUE KEY `client_invoice_details_transactionid_unique` (`transactionId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_invoice_details`
--

INSERT INTO `client_invoice_details` (`id`, `invoiceDate`, `clientName`, `project`, `transactionMethod`, `transactionId`, `invoiceNumber`, `transactionTitle`, `unitPrice`, `description`, `total`, `note`, `document`, `created_at`, `updated_at`, `amount`, `gsts`, `bankAccount`, `gstamount`, `subtotal`, `title`) VALUES
(1, '2024-12-23', '1', '1', 'Bank Transfer', 'Logi1235', '1', '\"[\\\"Admin dashboard\\\"]\"', '\"[\\\"75000\\\"]\"', '\"[null]\"', 88500.00, 'ok', 'Invoicedocument/1734951613_INVOICE#LOG23-006 (1).pdf', '2024-12-23 11:00:13', '2024-12-23 11:21:17', '[\"75000.00\"]', '[\"13500.00\"]', NULL, 13500.00, 75000.00, 'Designing');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `coursename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` int NOT NULL,
  `duration` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `coursename`, `fee`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'MERN', 50000, 5, '2024-12-23 10:53:15', '2024-12-23 10:53:15'),
(2, 'PHP', 45000, 4, '2024-12-23 10:53:33', '2024-12-23 10:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `expensehead`
--

DROP TABLE IF EXISTS `expensehead`;
CREATE TABLE IF NOT EXISTS `expensehead` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `head` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `head` bigint UNSIGNED DEFAULT NULL,
  `invoiceno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `center` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_head_foreign` (`head`),
  KEY `expenses_center_foreign` (`center`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
CREATE TABLE IF NOT EXISTS `fees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` json DEFAULT NULL,
  `splitup` json DEFAULT NULL,
  `taxes` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `feemaster` json DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `title`, `subtitle`, `splitup`, `taxes`, `created_at`, `updated_at`, `feemaster`) VALUES
(1, 'Student fee', '[\"Tuition fee\", \"Stationary\"]', '\"[\\\"70\\\",\\\"30\\\"]\"', '\"[[\\\"1\\\"],[\\\"2\\\"]]\"', '2024-12-23 11:13:43', '2024-12-23 11:13:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

DROP TABLE IF EXISTS `general_settings`;
CREATE TABLE IF NOT EXISTS `general_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `prefix` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `startingNo` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `prefix`, `startingNo`, `created_at`, `updated_at`) VALUES
(1, 'LOGI2024-', 1, '2024-12-23 10:51:53', '2024-12-23 10:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `gstreports`
--

DROP TABLE IF EXISTS `gstreports`;
CREATE TABLE IF NOT EXISTS `gstreports` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gsts`
--

DROP TABLE IF EXISTS `gsts`;
CREATE TABLE IF NOT EXISTS `gsts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `gstvalue` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gsts`
--

INSERT INTO `gsts` (`id`, `gstvalue`, `created_at`, `updated_at`) VALUES
(1, 18.00, '2024-12-23 10:52:09', '2024-12-23 10:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `incomedetails`
--

DROP TABLE IF EXISTS `incomedetails`;
CREATE TABLE IF NOT EXISTS `incomedetails` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `head` bigint UNSIGNED DEFAULT NULL,
  `center` bigint UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoiceno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `incomedetails_head_foreign` (`head`),
  KEY `incomedetails_center_foreign` (`center`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incomedetails`
--

INSERT INTO `incomedetails` (`id`, `head`, `center`, `date`, `name`, `amount`, `method`, `invoiceno`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-12-23', 'Jenny', 88500.00, 'Bank Transfer', '1', '2024-12-23 11:00:13', '2024-12-23 11:21:17'),
(3, 2, NULL, '2024-12-23', 'Aby', 5000.00, 'Upi', '2', '2024-12-23 11:45:14', '2024-12-23 11:45:14');

-- --------------------------------------------------------

--
-- Table structure for table `income_heads`
--

DROP TABLE IF EXISTS `income_heads`;
CREATE TABLE IF NOT EXISTS `income_heads` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `head` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `income_heads`
--

INSERT INTO `income_heads` (`id`, `head`, `created_at`, `updated_at`) VALUES
(1, 'Client project', '2024-12-23 11:24:29', '2024-12-23 11:24:29'),
(2, 'Student fee', '2024-12-23 11:24:42', '2024-12-23 11:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoiceNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoiceid` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `studentinvoiceid` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoicenumber_unique` (`invoiceNumber`),
  KEY `invoices_invoiceid_foreign` (`invoiceid`),
  KEY `invoices_studentinvoiceid_foreign` (`studentinvoiceid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoiceNumber`, `invoiceid`, `created_at`, `updated_at`, `studentinvoiceid`) VALUES
(1, '1', 1, '2024-12-23 11:00:13', '2024-12-23 11:00:13', NULL),
(3, '2', NULL, '2024-12-23 11:45:14', '2024-12-23 11:45:14', 2);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_20_113326_create_courses_table', 1),
(6, '2024_11_21_061644_create_students_table', 1),
(7, '2024_11_21_062658_create_client_details_table', 1),
(8, '2024_11_22_072611_update_students_table', 1),
(9, '2024_11_22_100737_create_projects_table', 1),
(10, '2024_11_25_070725_create_general_settings_table', 1),
(11, '2024_11_26_052800_create_client_invoice_details', 1),
(12, '2024_11_26_090914_create_gsts_table', 1),
(13, '2024_11_26_094440_create-invoices', 1),
(14, '2024_11_27_043257_create_studentinvoices_table', 1),
(15, '2024_11_27_084111_update_invoices', 1),
(16, '2024_11_29_090918_update_client_invoice_details', 1),
(17, '2024_11_30_093522_update_client_invoices', 1),
(18, '2024_12_02_150413_update_studentinvoices_table', 1),
(19, '2024_12_02_154630_update_user', 1),
(20, '2024_12_07_143234_create_gstreports_table', 1),
(21, '2024_12_09_123533_create_taxes_table', 1),
(22, '2024_12_10_100656_create_balances_table', 1),
(23, '2024_12_11_144156_create_fees_table', 1),
(24, '2024_12_12_115956_create_center', 1),
(25, '2024_12_13_114336_update_fees_table', 1),
(26, '2024_12_16_113902_update_studentinvoices_table', 1),
(27, '2024_12_16_124359_update_studentinvoices_table', 1),
(28, '2024_12_19_173019_update_student_invoice', 1),
(29, '2024_12_23_113621_create_income_head', 1),
(30, '2024_12_23_113747_create_incomedetails', 1),
(31, '2024_12_23_114124_expensehead', 1),
(32, '2024_12_23_114838_expenses', 2),
(33, '2024_12_23_143006_update_expenses_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `shortcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `projectname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `startdate` date NOT NULL,
  `deadline` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `shortcode`, `projectname`, `category`, `department`, `client`, `summary`, `notes`, `startdate`, `deadline`, `created_at`, `updated_at`) VALUES
(1, 'JS', 'jenny attendence system', 'Client_Project', 'Designing', '1', 'Emergency', 'ok', '2024-12-24', '2025-01-25', '2024-12-23 10:59:09', '2024-12-23 10:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `studentinvoices`
--

DROP TABLE IF EXISTS `studentinvoices`;
CREATE TABLE IF NOT EXISTS `studentinvoices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `invoicedate` date DEFAULT NULL,
  `transactionmethod` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoiceno` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generatedby` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankaccount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balanceamount` decimal(10,2) DEFAULT NULL,
  `unitprice` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `gst` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `actual_unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fees_id` bigint UNSIGNED DEFAULT NULL,
  `splitup` json DEFAULT NULL,
  `gstAmt` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `studentinvoices_invoiceno_unique` (`invoiceno`),
  UNIQUE KEY `studentinvoices_transactionid_unique` (`transactionid`),
  KEY `studentinvoices_student_id_foreign` (`student_id`),
  KEY `studentinvoices_fees_id_foreign` (`fees_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `studentinvoices`
--

INSERT INTO `studentinvoices` (`id`, `student_id`, `invoicedate`, `transactionmethod`, `transactionid`, `invoiceno`, `notes`, `description`, `generatedby`, `bankaccount`, `balanceamount`, `unitprice`, `amount`, `gst`, `total_amount`, `created_at`, `updated_at`, `actual_unit_price`, `fees_id`, `splitup`, `gstAmt`) VALUES
(2, 1, '2024-12-23', 'Upi', '87090Ah', '2', NULL, 'Internship', 'Logiprompt', 'Sbi', 45000.00, 5000.00, 4394.67, 605.33, 5000.00, '2024-12-23 11:45:14', '2024-12-23 11:45:14', 0.00, 1, '[\"3500\", \"1500\"]', '[\"533.90\", \" 71.43\"]');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `studentname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `fees` decimal(10,2) NOT NULL,
  `admissionnumber` bigint NOT NULL,
  `stedadmissionnumber` bigint DEFAULT NULL,
  `admissiondate` date NOT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstno` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `additionalcontactno` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `frequency` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `salutation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_email_unique` (`email`),
  UNIQUE KEY `students_admissionnumber_unique` (`admissionnumber`),
  UNIQUE KEY `students_aadhar_unique` (`aadhar`),
  KEY `students_course_id_foreign` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `studentname`, `email`, `course_id`, `fees`, `admissionnumber`, `stedadmissionnumber`, `admissiondate`, `gender`, `mobile`, `gstno`, `aadhar`, `additionalcontactno`, `address`, `image`, `file`, `description`, `frequency`, `created_at`, `updated_at`, `salutation`) VALUES
(1, 'Aby', 'aby@gmail.com', 2, 45000.00, 1234, 1122334, '2024-12-23', 'male', '9087654534', NULL, '908765453467', NULL, 'Nilamel, Kollam', 'image/1734951825_student1.jfif', 'file/1734951825_INVOICE#LOG23-006 (1).pdf', '+2 only', NULL, '2024-12-23 11:03:45', '2024-12-23 11:03:45', 'Mr');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
CREATE TABLE IF NOT EXISTS `taxes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `taxname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percentage` json DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `taxname`, `subtitle`, `percentage`, `total`, `created_at`, `updated_at`) VALUES
(1, 'GST', '[\"SGST\",\"CGST\"]', '[\"9\", \"9\"]', 18.00, '2024-12-23 11:11:54', '2024-12-23 11:11:54'),
(2, 'Stationarytax', '[\"Stationary\"]', '[\"5\"]', 5.00, '2024-12-23 11:12:14', '2024-12-23 11:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$nyFGqM1obZkAMAO36na32.uSBkzw7Q2vvIw8bvfJazPVyZ7XJiQT.', NULL, NULL, NULL, 'admin'),
(2, 'Jenny', 'jenny@gmail.com', NULL, '$2y$10$3433s2bk0o1kutcFyXpi.uv/P5hYZqORn5g3EXk8R/y0AZ7tG1Ume', NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balances`
--
ALTER TABLE `balances`
  ADD CONSTRAINT `balances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_center_foreign` FOREIGN KEY (`center`) REFERENCES `center` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_head_foreign` FOREIGN KEY (`head`) REFERENCES `expensehead` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incomedetails`
--
ALTER TABLE `incomedetails`
  ADD CONSTRAINT `incomedetails_center_foreign` FOREIGN KEY (`center`) REFERENCES `center` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incomedetails_head_foreign` FOREIGN KEY (`head`) REFERENCES `income_heads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_invoiceid_foreign` FOREIGN KEY (`invoiceid`) REFERENCES `client_invoice_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_studentinvoiceid_foreign` FOREIGN KEY (`studentinvoiceid`) REFERENCES `studentinvoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `studentinvoices`
--
ALTER TABLE `studentinvoices`
  ADD CONSTRAINT `studentinvoices_fees_id_foreign` FOREIGN KEY (`fees_id`) REFERENCES `fees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `studentinvoices_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
