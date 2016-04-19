-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2016 at 11:15 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `www_nwubanfarms_deepsearch`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_crawls`
--

CREATE TABLE `app_crawls` (
  `id` int(16) NOT NULL,
  `crawler_id` varchar(100) NOT NULL,
  `start_time` int(20) NOT NULL,
  `end_time` int(20) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_crawl_settings`
--

CREATE TABLE `app_crawl_settings` (
  `id` int(3) NOT NULL,
  `name` varchar(150) NOT NULL,
  `value` varchar(255) NOT NULL,
  `default_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_features`
--

CREATE TABLE `app_features` (
  `id` int(16) NOT NULL,
  `term` text NOT NULL,
  `context` int(1) NOT NULL,
  `avg_frequency` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_forms`
--

CREATE TABLE `app_forms` (
  `id` int(16) NOT NULL,
  `page_link_id` int(16) NOT NULL,
  `markup` text NOT NULL,
  `relevance` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_page_links`
--

CREATE TABLE `app_page_links` (
  `id` int(16) NOT NULL,
  `url` varchar(2000) NOT NULL,
  `anchor` varchar(1000) NOT NULL,
  `around_text` text NOT NULL,
  `page_title` varchar(1000) DEFAULT NULL,
  `parent_page_link` int(16) DEFAULT NULL,
  `last_crawl_time` int(20) DEFAULT NULL,
  `target_distance` int(1) DEFAULT NULL,
  `ext_reward` float DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bb_comments`
--

CREATE TABLE `bb_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent` int(16) UNSIGNED DEFAULT '0',
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(16) NOT NULL,
  `date_time` int(32) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bb_events_log`
--

CREATE TABLE `bb_events_log` (
  `id` int(16) NOT NULL,
  `session_id` int(16) NOT NULL,
  `time` int(32) NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bb_posts`
--

CREATE TABLE `bb_posts` (
  `id` int(16) NOT NULL,
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guid` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `featured_image` int(16) DEFAULT NULL COMMENT 'uploads.id',
  `category` int(16) DEFAULT NULL COMMENT 'site_posts_categories.id',
  `author` int(16) DEFAULT NULL COMMENT 'users.id',
  `date_created` int(32) NOT NULL,
  `last_update` int(32) NOT NULL,
  `cardinality` int(3) DEFAULT '1',
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bb_posts`
--

INSERT INTO `bb_posts` (`id`, `post_type`, `guid`, `title`, `content`, `excerpt`, `featured_image`, `category`, `author`, `date_created`, `last_update`, `cardinality`, `status`) VALUES
(1, '4', 'privacy-policy', 'Privacy Policy', '<p>nothing much</p>', '<p>nothing</p>', NULL, NULL, 1, 1460915520, 1460915865, 1, 1),
(2, '4', 'terms-of-use', 'Terms of Use', '<h1 style="text-align: center;">Enjoy ! It''s Inexpensive</h1>\r\n<p class="lead" style="text-align: center;">Developed forÂ <strong>official use only</strong>Â for the Post Primary School Management Board, Enugu State.</p>', '<p><span style="font-family: ''Agency FB''; font-size: 15px;">Use freely</span></p>', NULL, NULL, 1, 1460915820, 1460972371, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_post_categories`
--

CREATE TABLE `bb_post_categories` (
  `id` int(16) NOT NULL,
  `guid` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(16) DEFAULT NULL COMMENT 'site_posts_categories.id',
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bb_sessions`
--

CREATE TABLE `bb_sessions` (
  `id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL COMMENT 'users.id',
  `privilege` int(16) NOT NULL,
  `start_time` int(32) NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity_time` int(32) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bb_sessions`
--

INSERT INTO `bb_sessions` (`id`, `user_id`, `privilege`, `start_time`, `user_agent`, `ip_address`, `last_activity_time`, `status`) VALUES
(1, 1, 1, 1460912268, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1460912671, 0),
(2, 1, 1, 1460913024, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1460913355, 0),
(3, 1, 1, 1460913373, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1460987160, 0),
(4, 1, 1, 1461012537, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461012537, 0),
(5, 1, 1, 1461012537, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461012537, 1),
(6, 1, 1, 1461012785, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461013325, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_uploads`
--

CREATE TABLE `bb_uploads` (
  `id` int(16) NOT NULL,
  `author` int(16) DEFAULT NULL COMMENT 'site_users.id',
  `upload_time` int(32) NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int(10) NOT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bb_uploads`
--

INSERT INTO `bb_uploads` (`id`, `author`, `upload_time`, `location`, `file_name`, `file_size`, `status`) VALUES
(0, 1, 1460987160, 'Uploads/staff-photos', 'p5714e518aa378.jpg', 79674, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_users`
--

CREATE TABLE `bb_users` (
  `id` int(16) NOT NULL,
  `photo` int(16) DEFAULT NULL COMMENT 'uploads.id',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` int(10) DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'maps_states.id',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'maps_countries.id',
  `biography` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bb_users`
--

INSERT INTO `bb_users` (`id`, `photo`, `title`, `first_name`, `middle_name`, `last_name`, `email`, `phone`, `password`, `address1`, `address2`, `city`, `zip_code`, `state`, `country`, `biography`, `status`) VALUES
(1, 0, 'Mr', 'Chukwuemeka', 'Joseph', 'Nwobodo', 'jc.nwobodo@gmail.com', '08133621591', 'b07786e737af399ed2efd79ba8fbb4fd', 'University of Nigeria, Nsukka', '', 'Nsukka', 0, 'Enugu', 'Nigeria', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_users_privileges`
--

CREATE TABLE `bb_users_privileges` (
  `id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL,
  `privilege` int(2) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bb_users_privileges`
--

INSERT INTO `bb_users_privileges` (`id`, `user_id`, `privilege`, `status`) VALUES
(1, 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_crawls`
--
ALTER TABLE `app_crawls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_crawl_settings`
--
ALTER TABLE `app_crawl_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attribute` (`name`);

--
-- Indexes for table `app_features`
--
ALTER TABLE `app_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_forms`
--
ALTER TABLE `app_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_id` (`page_link_id`);

--
-- Indexes for table `app_page_links`
--
ALTER TABLE `app_page_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_page_link` (`parent_page_link`);

--
-- Indexes for table `bb_comments`
--
ALTER TABLE `bb_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`,`user_id`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `bb_events_log`
--
ALTER TABLE `bb_events_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `bb_posts`
--
ALTER TABLE `bb_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pamalink` (`guid`),
  ADD KEY `parent` (`featured_image`,`category`,`author`),
  ADD KEY `category` (`category`),
  ADD KEY `featured_image` (`featured_image`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `bb_post_categories`
--
ALTER TABLE `bb_post_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guid` (`guid`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `bb_sessions`
--
ALTER TABLE `bb_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`privilege`),
  ADD KEY `priviledge` (`privilege`);

--
-- Indexes for table `bb_uploads`
--
ALTER TABLE `bb_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `bb_users`
--
ALTER TABLE `bb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `photo_id` (`photo`);

--
-- Indexes for table `bb_users_privileges`
--
ALTER TABLE `bb_users_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_crawls`
--
ALTER TABLE `app_crawls`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_crawl_settings`
--
ALTER TABLE `app_crawl_settings`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_features`
--
ALTER TABLE `app_features`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_forms`
--
ALTER TABLE `app_forms`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_page_links`
--
ALTER TABLE `app_page_links`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bb_comments`
--
ALTER TABLE `bb_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bb_events_log`
--
ALTER TABLE `bb_events_log`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bb_posts`
--
ALTER TABLE `bb_posts`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bb_post_categories`
--
ALTER TABLE `bb_post_categories`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bb_sessions`
--
ALTER TABLE `bb_sessions`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `bb_users`
--
ALTER TABLE `bb_users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bb_users_privileges`
--
ALTER TABLE `bb_users_privileges`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_forms`
--
ALTER TABLE `app_forms`
  ADD CONSTRAINT `app_forms_ibfk_1` FOREIGN KEY (`page_link_id`) REFERENCES `app_page_links` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `bb_events_log`
--
ALTER TABLE `bb_events_log`
  ADD CONSTRAINT `bb_events_log_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `bb_sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bb_posts`
--
ALTER TABLE `bb_posts`
  ADD CONSTRAINT `bb_posts_ibfk_1` FOREIGN KEY (`author`) REFERENCES `bb_users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `bb_post_categories`
--
ALTER TABLE `bb_post_categories`
  ADD CONSTRAINT `bb_post_categories_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `bb_post_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `bb_sessions`
--
ALTER TABLE `bb_sessions`
  ADD CONSTRAINT `bb_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `bb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bb_uploads`
--
ALTER TABLE `bb_uploads`
  ADD CONSTRAINT `bb_uploads_ibfk_1` FOREIGN KEY (`author`) REFERENCES `bb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `bb_users_privileges`
--
ALTER TABLE `bb_users_privileges`
  ADD CONSTRAINT `bb_users_privileges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `bb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
