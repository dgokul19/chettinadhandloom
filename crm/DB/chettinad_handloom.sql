-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2018 at 11:28 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chettinad_handloom`
--

-- --------------------------------------------------------

--
-- Table structure for table `ch_app_users`
--

CREATE TABLE `ch_app_users` (
  `id` int(255) NOT NULL,
  `oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_no` bigint(255) DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DOB` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture_url` text COLLATE utf8_unicode_ci,
  `profile_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover_picture_url` text COLLATE utf8_unicode_ci,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userType` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '0',
  `userProfile_status` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_completed',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OTP` int(200) NOT NULL,
  `otp_is_verified` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ch_app_users`
--

INSERT INTO `ch_app_users` (`id`, `oauth_provider`, `oauth_uid`, `access_token`, `username`, `first_name`, `last_name`, `email`, `mobile_no`, `gender`, `DOB`, `locale`, `picture_url`, `profile_url`, `cover_picture_url`, `password`, `userType`, `created_at`, `modified`, `status`, `userProfile_status`, `last_login`, `OTP`, `otp_is_verified`) VALUES
(1, '', NULL, NULL, 'Cristiano Gokul D', 'Cristiano', 'Gokul D', 'dgokul19@gmail.com', 8122701839, NULL, NULL, NULL, NULL, NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2017-09-19 17:59:11', '2017-09-20 19:04:24', 1, 'not_completed', '0000-00-00 00:00:00', 636572, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ch_product_category`
--

CREATE TABLE `ch_product_category` (
  `id` int(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cover_picture_url` varchar(255) NOT NULL,
  `has_discount` tinyint(1) NOT NULL DEFAULT '0',
  `discount_percentage` int(100) DEFAULT NULL,
  `discount_price` float(34,2) DEFAULT NULL,
  `quantity_available` int(255) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ch_product_category`
--

INSERT INTO `ch_product_category` (`id`, `category_name`, `description`, `cover_picture_url`, `has_discount`, `discount_percentage`, `discount_price`, `quantity_available`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Cotton Silk Saree', 'Fine sarees in pure & Blended cotton silk', 'chettinaad-handloom-category-01.jpg', 0, NULL, NULL, 0, 1, '2017-09-25 15:26:25', '2017-09-25 16:01:38'),
(2, 'Chettinad Cotton', 'Tradition sarees from Chettinaad', 'chettinaad-handloom-category-02.jpg', 0, NULL, NULL, 0, 1, '2017-09-25 15:26:25', '2017-09-25 16:02:37'),
(3, 'Pure Silk', 'Fine sarees in pure & Blended cotton silk', 'chettinaad-handloom-category-03.jpg', 0, NULL, NULL, 0, 1, '2017-09-25 15:26:26', '2017-09-25 16:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `ch_product_details`
--

CREATE TABLE `ch_product_details` (
  `id` int(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `sub_category_id` int(255) NOT NULL,
  `product_code` varchar(200) NOT NULL,
  `pdt_name` varchar(255) NOT NULL,
  `pdt_description` text NOT NULL,
  `tags` text NOT NULL,
  `model_id` int(255) NOT NULL,
  `unit` varchar(200) NOT NULL DEFAULT 'Nos',
  `price` float(34,2) NOT NULL DEFAULT '0.00',
  `has_discount` tinyint(1) NOT NULL DEFAULT '0',
  `discount_price` float(34,2) DEFAULT NULL,
  `discount_percentage` int(100) DEFAULT NULL,
  `available_quantity` int(255) NOT NULL DEFAULT '0',
  `status` varchar(200) NOT NULL DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ch_product_details`
--

INSERT INTO `ch_product_details` (`id`, `category_id`, `sub_category_id`, `product_code`, `pdt_name`, `pdt_description`, `tags`, `model_id`, `unit`, `price`, `has_discount`, `discount_price`, `discount_percentage`, `available_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'S1200', 'Prd 1 cat 1', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:54:53'),
(2, 1, 2, 'S1201', 'Prd 2 cat 1', 'Colours  - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 1, 'Nos', 550.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:54:59'),
(3, 1, 1, 'S1202', 'Prd 3 cat 1', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:55:06'),
(4, 1, 2, 'S1203', 'Prd 4 cat 1', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:55:15'),
(5, 2, 2, 'S1204', 'Prd 1 cat 2', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:55:30'),
(6, 2, 1, 'S1205', 'Prd 2 cat 2', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:55:38'),
(7, 2, 2, 'S1206', 'Prd 3 cat 2', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:55:54'),
(8, 2, 1, 'S1207', 'Prd 4 cat 2', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:56:02'),
(9, 3, 2, 'S1208', 'Prd 1 cat 3', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:56:26'),
(10, 3, 1, 'S1209', 'Prd 2 cat 3', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:56:33'),
(11, 3, 2, 'S1210', 'Prd 3 cat 3', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:56:46'),
(12, 3, 1, 'S1211', 'Prd 4 cat 3', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:56:53'),
(13, 3, 2, 'S1212', 'Prd 5 cat 3', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:56:59'),
(14, 3, 1, 'S1213', 'Prd 6 cat 3', 'Colours of Navarathri - one of the best and famous weaves of Chettinad cotton, fusion of checks and small 		temples ( small korvai\'s ). With running blouse 6.2 mts.', 'chettinad saree, temple', 2, 'Nos', 1200.00, 0, NULL, NULL, 20, 'available', '2017-09-25 21:07:19', '2017-10-10 16:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `ch_product_images`
--

CREATE TABLE `ch_product_images` (
  `id` int(255) NOT NULL,
  `pdt_p_id` int(255) NOT NULL,
  `picture_url` varchar(255) NOT NULL,
  `is_cover_image` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ch_product_images`
--

INSERT INTO `ch_product_images` (`id`, `pdt_p_id`, `picture_url`, `is_cover_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '21462951_862472593900360_7157000771093658319_n.jpg', 1, 1, '2017-09-25 21:13:57', '0000-00-00 00:00:00'),
(2, 2, '21557711_862472533900366_6771048742462787759_n.jpg', 1, 1, '2017-09-25 21:13:57', '0000-00-00 00:00:00'),
(3, 3, '21686160_865607723586847_9131820961906272919_n.jpg', 1, 1, '2017-09-25 21:13:58', '2017-10-10 17:02:31'),
(4, 4, '21686497_865607820253504_3815712585052775698_n.jpg', 1, 1, '2017-09-25 21:13:58', '2017-10-10 17:02:39'),
(5, 5, '21686503_865607733586846_5281409182680729357_n.jpg', 1, 1, '2017-09-25 21:13:58', '2017-10-10 17:03:20'),
(6, 5, '21740410_862472637233689_2721665325719786549_n.jpg', 0, 1, '2017-09-25 21:14:09', '2017-10-10 17:03:30'),
(7, 6, '21742951_862472697233683_5415665798075924953_n.jpg', 1, 1, '2017-09-25 21:13:57', '2017-10-10 17:03:49'),
(8, 7, '21743097_862472473900372_832839277474174928_n.jpg', 1, 1, '2017-09-25 21:13:57', '2017-10-10 17:04:04'),
(9, 8, '21743366_862472560567030_9165288951848360615_n.jpg', 1, 1, '2017-09-25 21:13:58', '2017-10-10 17:04:12'),
(10, 9, '21751376_862472507233702_4987860865625485853_n.jpg', 1, 1, '2017-09-25 21:13:58', '2017-10-10 17:04:30'),
(11, 10, '21761871_865607923586827_1879398264120530599_n.jpg', 1, 1, '2017-09-25 21:13:58', '2017-10-10 17:04:40'),
(12, 11, '21761922_865607883586831_4538826253402953544_n.jpg', 1, 1, '2017-09-25 21:14:09', '2017-10-10 17:05:25'),
(13, 12, '21761940_865607860253500_4188092046821231635_n.jpg', 1, 1, '2017-09-25 21:13:58', '2017-10-10 17:05:38'),
(14, 13, '21764728_865607773586842_7731789789331003612_n.jpg', 1, 1, '2017-09-25 21:13:58', '2017-10-10 17:05:47'),
(15, 14, '21764789_865607756920177_8987463458533234952_n.jpg', 1, 1, '2017-09-25 21:14:09', '2017-10-10 17:05:54');

-- --------------------------------------------------------

--
-- Table structure for table `ch_product_model`
--

CREATE TABLE `ch_product_model` (
  `id` int(255) NOT NULL,
  `model_code` varchar(255) NOT NULL,
  `model_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ch_product_model`
--

INSERT INTO `ch_product_model` (`id`, `model_code`, `model_name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'R1', 'Regular plain', 'Regular plain saree pattern', 1, '2017-09-25 20:58:48', '2017-09-25 20:59:02'),
(2, 'TEMPLE', 'Temple buttas', 'Temple buttas desgins', 1, '2017-09-25 20:58:48', '2017-09-25 20:59:06'),
(3, 'ANNAPATCHAI', 'Annapatchai', 'Annapatchai crafts', 1, '2017-09-25 20:58:49', '2017-09-25 20:59:12');

-- --------------------------------------------------------

--
-- Table structure for table `ch_product_sub_category`
--

CREATE TABLE `ch_product_sub_category` (
  `id` int(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cover_picture_url` varchar(255) DEFAULT NULL,
  `has_discount` tinyint(1) NOT NULL DEFAULT '0',
  `discount_percentage` int(100) DEFAULT NULL,
  `discount_price` float(34,2) DEFAULT NULL,
  `quantity_available` int(255) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ch_product_sub_category`
--

INSERT INTO `ch_product_sub_category` (`id`, `category_id`, `sub_category_name`, `description`, `cover_picture_url`, `has_discount`, `discount_percentage`, `discount_price`, `quantity_available`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'sub-cat-1-1', '[description for sub-cat-1-1]', NULL, 0, NULL, NULL, 0, 1, '2017-09-25 19:36:29', '0000-00-00 00:00:00'),
(2, 1, 'sub-cat-1-2', '[description for sub-cat-1-1]', NULL, 0, NULL, NULL, 0, 1, '2017-09-25 19:36:29', '0000-00-00 00:00:00'),
(3, 2, 'sub-cat-2-1', '[description for sub-cat-2-1]', NULL, 0, NULL, NULL, 0, 1, '2017-09-25 19:36:29', '0000-00-00 00:00:00'),
(4, 2, 'sub-cat-2-2', '[description for sub-cat-2-2]', NULL, 0, NULL, NULL, 0, 1, '2017-09-25 19:36:29', '2017-09-25 19:36:48'),
(5, 3, 'sub-cat-3-1', '[description for sub-cat-3-1]', NULL, 0, NULL, NULL, 0, 1, '2017-09-25 19:36:29', '2017-09-25 19:36:52'),
(6, 3, 'sub-cat-3-2', '[description for sub-cat-3-2]', NULL, 0, NULL, NULL, 0, 1, '2017-09-25 19:36:29', '2017-09-25 19:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `ch_subcribers_news_letters`
--

CREATE TABLE `ch_subcribers_news_letters` (
  `id` int(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `app_user_id` int(255) DEFAULT NULL,
  `client_name` varchar(200) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ch_web_enquiries`
--

CREATE TABLE `ch_web_enquiries` (
  `id` int(255) NOT NULL,
  `en_name` varchar(255) NOT NULL,
  `en_email_id` varchar(100) NOT NULL,
  `en_phone` bigint(255) NOT NULL,
  `en_subject` varchar(255) NOT NULL,
  `en_msg` text NOT NULL,
  `arrived_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>new, 2=>read,3=>reminder',
  `status` varchar(20) NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ch_web_enquiries`
--

INSERT INTO `ch_web_enquiries` (`id`, `en_name`, `en_email_id`, `en_phone`, `en_subject`, `en_msg`, `arrived_at`, `flag`, `status`) VALUES
(1, 'ka', 'asd2@am.com', 34, '', 'werwer', '2017-09-05 17:09:54', 1, 'open'),
(2, 'goki', 'asadad@gmcil.com', 8122701839, '', 'aasdasd', '2017-09-06 18:17:47', 1, 'open');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ch_app_users`
--
ALTER TABLE `ch_app_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_product_category`
--
ALTER TABLE `ch_product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_product_details`
--
ALTER TABLE `ch_product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_product_images`
--
ALTER TABLE `ch_product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_product_model`
--
ALTER TABLE `ch_product_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_product_sub_category`
--
ALTER TABLE `ch_product_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_subcribers_news_letters`
--
ALTER TABLE `ch_subcribers_news_letters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- Indexes for table `ch_web_enquiries`
--
ALTER TABLE `ch_web_enquiries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ch_app_users`
--
ALTER TABLE `ch_app_users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ch_product_category`
--
ALTER TABLE `ch_product_category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ch_product_details`
--
ALTER TABLE `ch_product_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ch_product_images`
--
ALTER TABLE `ch_product_images`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ch_product_model`
--
ALTER TABLE `ch_product_model`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ch_product_sub_category`
--
ALTER TABLE `ch_product_sub_category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ch_subcribers_news_letters`
--
ALTER TABLE `ch_subcribers_news_letters`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ch_web_enquiries`
--
ALTER TABLE `ch_web_enquiries`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
