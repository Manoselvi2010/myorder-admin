-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2020 at 02:49 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exchange_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin@exchange.com', '$2y$10$39G46wZgZw56cWmYZS9Qt.fE9W1DySGSsfpXbuUeX30Z8nmOqy7vK', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_bank_details`
--

CREATE TABLE `admin_bank_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `coin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_btc_addresses`
--

CREATE TABLE `admin_btc_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_btc_transactions`
--

CREATE TABLE `admin_btc_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `txid` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_eth_addresses`
--

CREATE TABLE `admin_eth_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_eth_transactions`
--

CREATE TABLE `admin_eth_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `txid` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE `commission` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `credential` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_02_14_075327_create_admin_table', 1),
(4, '2019_02_15_134910_create_admin_bank_details_table', 1),
(5, '2019_02_19_100738_create_user_btc_address_table', 1),
(6, '2019_02_19_100810_create_user_eth_address_table', 1),
(7, '2019_02_19_100826_create_user_xrp_address_table', 1),
(8, '2019_02_20_100510_create_user_kyc_table', 1),
(9, '2019_02_27_102605_create_admin_btc_address_table', 1),
(10, '2019_02_27_102618_create_admin_eth_address_table', 1),
(11, '2019_02_27_102627_create_admin_xrp_address_table', 1),
(12, '2019_02_27_121544_create_admin_btc_transaction_table', 1),
(13, '2019_02_27_121555_create_admin_eth_transaction_table', 1),
(14, '2019_02_27_121604_create_admin_xrp_transaction_table', 1),
(15, '2019_03_06_110438_creat_admin_ltc_transaction_table', 1),
(16, '2019_03_06_110454_creat_admin_ltc_address_table', 1),
(17, '2019_03_06_110849_creat_user_ltc_address_table_table', 1),
(18, '2019_03_12_124555_creat_commission_table', 1),
(19, '2019_03_06_110438_creat_admin_fors_transaction_table', 2),
(20, '2019_03_06_110454_creat_admin_fors_address_table', 2),
(21, '2019_05_02_094048_TwoOptiontable', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `twofa_option`
--

CREATE TABLE `twofa_option` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = deactive , 1= active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_btc_addresses`
--

CREATE TABLE `user_btc_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `narcanru` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_btc_addresses`
--

INSERT INTO `user_btc_addresses` (`id`, `user_id`, `address`, `narcanru`, `balance`, `created_at`, `updated_at`) VALUES
(1, 1, '1NYcfwr37extjAo3Wev7U2P7WEChaEojNS', 'eyJpdiI6Ik5rZ3k2NG9nSEgyRWMxMmJYWUhhT1E9PSIsInZhbHVlIjoiQ2hVMjM4TzM0ckNKVmp4SHlZb0c0VTZJQjhMNzZQN2ZEMFFQTWVcL0owemtUM3ZveEpQSmN1K0N6QVJ1WEh1dFdxVW5GMkl0VVA0RXIwTXlvNWVIV2tYSmxTWk85RWxMTVJ2OVwvZkg0ZjNlMD0iLCJtYWMiOiIzMmVkYmI4MmU0MTFjZjM5MDMxZDA3ZTI3ZDVjMTY3ZmNiZmYxYTRjMGNmMGFmYTM2ZmVmMzcwMGFkM2M2OGNlIn0=,eyJpdiI6IlIyME5xbDNPYk5NclVHdSttNnRQZkE9PSIsInZhbHVlIjoiMWxKekpKSjA5YitWVVVkMkRKRGNVZUJ2YmVzR3VqMzJKY21WbTI0ZVVSVDJtMzhZeXB0emhFc2YxTFwvakJteGEzb0tnNnZlWXFhQmZiUjNSb0o3eGFnPT0iLCJtYWMiOiJkMWIwYzk4YzBlZjhhMjczYTUyY2E1NTMzNTNhMWFjZDQwYjE3OGY4MjdlYWFiZjYzOTAwMDE1NjAwMDU3ODNlIn0=,eyJpdiI6ImJnMkVHd3RIMktZc0lQU3lnNXA3blE9PSIsInZhbHVlIjoiVERMVTZBSFJCSFN5Y3owXC85ZUkxaVBGb2ZGODRyRmdxdlA1VXZoOHN4YUNhcDNLVzJJSGp0QlVvXC91bHJXV0c2dG9MVVlSVk80RmxrT3daSERyYlQyMG9IV3hXcmVwMWVSNjFGbFBPOFwvQlE9IiwibWFjIjoiMDIyMTgzYmYzOTkyZWQ2NWU1M2NmNTgyYjY1Y2MyODY4MGIxNDNhOTFlNDUzZGU3N2ZmYzY2ZjA5YWQ2MTM3MSJ9', 0, '2020-03-10 04:22:37', '2020-03-10 04:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_eth_addresses`
--

CREATE TABLE `user_eth_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `narcanru` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_eth_addresses`
--

INSERT INTO `user_eth_addresses` (`id`, `user_id`, `address`, `narcanru`, `balance`, `created_at`, `updated_at`) VALUES
(1, 1, '0x5f2ae3426ebefc74050789ba9e155daf9d573738', 'eyJpdiI6IldnRzU0aDRaRnBsR3B5QnVCWFFLT2c9PSIsInZhbHVlIjoiWk1UTkl1M0h1VUFGU0h0WmNlZjdvRzBxN3lNS1wvbUhVbm1XQnpmakNqd2t6Y3MwdyszNEl2dUpxWGZpR0cwOXJiYTV1VGtReTZRalwvTSs2YXBBSmJKbUNpbVhHRjV2N0N5VFR5cGY1TEozcz0iLCJtYWMiOiIyNzBiMWMzY2UyZGIyNTRlOTY1M2MyODM5YjJlMjFjODRkYzZmODlkNWI2ZGEzOTQ2NTJlNDQ2NTU2ZTgzYmI1In0=,eyJpdiI6ImlkVGVEUzgxRzVIek04WjlmKzd6Wnc9PSIsInZhbHVlIjoid3BSVEIySjNvbHphTEJZc0FsaTVlcm1XZmY0MXV3Njg0cVF4WUxZSzNvQkoyMXdjb2gycUVoYlNVMHpVbCtyZ0MxQXcxSTRPeXRLK1JVV2F6V216ZFFCMVdFcEZ0U29VdkZ3TDZ0UkFLUDZPa0FNRzFuY3c2Z2RFUDNadXZzSTFQVXdkcEMrMlNHNVQ1U3FYNHFEUlV2N2drXC9oMXk2TWFRYWV5VEgzQVZ6TjFKT0U4YWp2YUFyRzhBcENsTEM0VSIsIm1hYyI6IjNjOWI3ZWNiNTZjZGY4OTcyYzdlM2IwM2ZkYjQ0YTYzN2I5NjdlYTFjODA4MjQzNDM3YzRkYWNiOTUyYjY2YWIifQ==', 0, '2020-03-10 04:23:14', '2020-03-10 04:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_kycs`
--

CREATE TABLE `user_kycs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_kycs`
--

INSERT INTO `user_kycs` (`id`, `user_id`, `email`, `created_at`, `updated_at`) VALUES
(1, '1', 'sathishprabu447@gmail.com', '2020-03-10 04:23:14', '2020-03-10 04:23:14'),
(2, '1', 'sathishprabu447@gmail.com', '2020-03-20 00:47:57', '2020-03-20 00:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_ltc_addresses`
--

CREATE TABLE `user_ltc_addresses` (
  `id` int(150) NOT NULL,
  `user_id` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `narcanru` text NOT NULL,
  `balance` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_ltc_addresses`
--

INSERT INTO `user_ltc_addresses` (`id`, `user_id`, `address`, `narcanru`, `balance`, `created_at`, `updated_at`) VALUES
(1, '2', 'LVoY5VpCjc9YSov8gjobtixGhNWzgq4nK8', 'eyJpdiI6IkRoclliMHZPZXRqVUl4XC9sTVhzT1JRPT0iLCJ2YWx1ZSI6ImVscnFnVDZybGQ4R3F1VlloOFd3d0JhY3RoWW9RaW9ib0hHOHdwTThpcHVhT2VYdDRjcFlaUFZRem40XC91eUtNanNKWlhGdzJTSGlNK2x1b3hqdTZwRFhSc1Q3YjFZVVlyVUYyRGdtODdvUT0iLCJtYWMiOiIyOWJiNDc3OTJmOGVhNTVjMmY4MTYxNWY0MWQ0NDMzMzVjM2NlYWZmZThhYjEwMjdhNWRlYjNkY2U4OGEyMmE3In0=,eyJpdiI6Ik1CK2hvbGFzYUhyYWl1Vk5GZjY4b0E9PSIsInZhbHVlIjoicDdFZWpPOGxTXC9WZzBXVERrK0FJSmZZQ3M3WEt5TnNUdnowQXFKbmUwbFpva3QwXC9uVmRZanZuazd4Z0dDZDEwbm92V2k2WXNTYjlLbWMzQXJaM1wvdGc9PSIsIm1hYyI6ImZjMzY0MmVhODg5ZTM5NGFiZjNmMzEyYmI1MjhmM2MzNjEyNzRlNGZjZmNmNWYyYWVkYWUyZTUyYzEyMDU5ZDYifQ==,eyJpdiI6IjA3WXU1QVwvZzlrd2RuNEJSUlVuSklnPT0iLCJ2YWx1ZSI6IkFFdklIT0NmXC8zNUVDOWRDVmlocnFlanB5TFBjNkg3RHVcL0JpaEE0Zis1eWVzZTZyckdtSjdYYnN4STlpakh4S2VqakpOREduVWJUNk9BbHZuakVsQzFyNjZyWXY2SGRuc1hmZ0YxQnpUN009IiwibWFjIjoiNDliZDI4YTJlZThiYjliYWNmMjVmYWMzZTA0Y2E3NWU5ODgxZjY0Yjk3YTBiY2JiZmRhZGE4NjRkNjE4YjM0MCJ9', '0', '2020-03-18 20:23:28', '2020-03-18 20:23:28'),
(2, '1', 'LXYbNseaMVPQ7vqtmQirZYfA47dVXGRPjA', 'eyJpdiI6Ikg2b1NRakE4UllsZ2FoRExtOG9ZNnc9PSIsInZhbHVlIjoiSzc0d0JiSzZ4R1pnbnlVQmVQY3daWW5qcm84ejZxM1JHOG4yWXM0K3FFVTNVcEtBU3Zvc1wvUzNmOUlmZmFmS1BnbnNCMUswdVNjTmFISFdKY2c0UG9hRXZPVzhZNnYzdHBcL1JMRzdGMzlLbz0iLCJtYWMiOiI2NGE5ZTk1Y2NmNzljNmRhNTE1ZmFkZjQ3ZTY1MTg2MTAyNWQzMTcxZjEwYWU4YzJjNzkxMTMzN2Q0NDlhOTQxIn0=,eyJpdiI6IkFOUlMzRHBvUVpxYmRVKytSVzRyNWc9PSIsInZhbHVlIjoiZFUwVjFkc0JZZE9Gc0VHcjBVQ0ZDa3RZSEhDYnNLYW1Wb3owUFR1WXhLR2FMcnRmemlaTVlzZUFPcE1cL0xta2JYKzNDWnRIR084dVwvSm9QRXU3QklRdz09IiwibWFjIjoiYzg2YzViNDQyODcwODg3YTUxNTZmNzM3M2U0ZWJkNjg3YTg1MTUyOTc4YmMyNmViMWM4ZmFkMjFkYTQyMTBhNSJ9,eyJpdiI6ImdjUktKaUdaeTJCbXI2Q3NrVFJob0E9PSIsInZhbHVlIjoiZ2lRT1g2d1k5VkxVckpjcmwxU1MwWURuRysrXC9ZbzduSWRiYTk2a0xLM3VmNDBZUXBnNG5mMWx3bDJrWHlnTlVkYU1abmZsbk9hRzJGZXUyK04zMmM5TUNEV2JhdDFNZmZwQWUySkh3ZzRRPSIsIm1hYyI6IjUzYTAzNjhkN2FlYTViYWJkNmY3YmYyNDU3OWVkOWU3ZDNjZDZiYTU2YzYzN2Q1Yjc4OTYxMTM1ZWJjNjgwMDAifQ==', '0', '2020-03-20 00:43:18', '2020-03-20 00:43:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_bank_details`
--
ALTER TABLE `admin_bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_btc_addresses`
--
ALTER TABLE `admin_btc_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_btc_transactions`
--
ALTER TABLE `admin_btc_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_eth_addresses`
--
ALTER TABLE `admin_eth_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_eth_transactions`
--
ALTER TABLE `admin_eth_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `twofa_option`
--
ALTER TABLE `twofa_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_btc_addresses`
--
ALTER TABLE `user_btc_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_eth_addresses`
--
ALTER TABLE `user_eth_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_kycs`
--
ALTER TABLE `user_kycs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_ltc_addresses`
--
ALTER TABLE `user_ltc_addresses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_bank_details`
--
ALTER TABLE `admin_bank_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_btc_addresses`
--
ALTER TABLE `admin_btc_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_btc_transactions`
--
ALTER TABLE `admin_btc_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_eth_addresses`
--
ALTER TABLE `admin_eth_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_eth_transactions`
--
ALTER TABLE `admin_eth_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commission`
--
ALTER TABLE `commission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `twofa_option`
--
ALTER TABLE `twofa_option`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_btc_addresses`
--
ALTER TABLE `user_btc_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_eth_addresses`
--
ALTER TABLE `user_eth_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_kycs`
--
ALTER TABLE `user_kycs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_ltc_addresses`
--
ALTER TABLE `user_ltc_addresses`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
