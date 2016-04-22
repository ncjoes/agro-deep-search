-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2016 at 05:07 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

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
  `session_id` int(16) NOT NULL,
  `num_links_followed` int(11) NOT NULL DEFAULT '0',
  `num_documents_received` int(11) NOT NULL DEFAULT '0',
  `num_links_extracted` int(13) NOT NULL DEFAULT '0',
  `num_forms_extracted` int(13) NOT NULL DEFAULT '0',
  `num_bytes_received` int(16) DEFAULT NULL,
  `process_run_time` double DEFAULT NULL,
  `start_time` int(20) NOT NULL,
  `end_time` int(20) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_crawls`
--

INSERT INTO `app_crawls` (`id`, `crawler_id`, `session_id`, `num_links_followed`, `num_documents_received`, `num_links_extracted`, `num_forms_extracted`, `num_bytes_received`, `process_run_time`, `start_time`, `end_time`, `status`) VALUES
(132, '31761461249938', 13, 9, 8, 0, 0, 64311, 3, 1461249938, 1461249942, 1),
(133, '31761461249953', 13, 9, 8, 0, 0, 64311, 3, 1461249953, 1461249957, 1),
(134, '31761461250185', 13, 9, 8, 0, 0, 64311, 3, 1461250185, 1461250189, 1),
(135, '31761461250235', 13, 9, 8, 0, 0, 64311, 4, 1461250235, 1461250240, 1),
(136, '31761461250303', 13, 9, 8, 0, 0, 64311, 3, 1461250303, 1461250307, 1),
(137, '31761461250527', 13, 210, 178, 0, 0, 1706657, 66, 1461250527, NULL, 2),
(138, '31761461250581', 13, 9, 8, 0, 0, 64311, 7, 1461250581, 1461250588, 1),
(139, '31761461250729', 13, 38, 19, 0, 0, 1031016, 568, 1461250729, 1461251297, 0),
(140, '31761461250879', 13, 9, 8, 0, 0, 64311, 4, 1461250879, 1461250883, 1),
(141, '31761461254439', 13, 1, 0, 0, 0, 0, 1, 1461254439, NULL, 2),
(142, '31761461254537', 13, 9, 8, 0, 0, 64311, 4, 1461254537, 1461254541, 1),
(143, '31761461254582', 13, 234, 117, 0, 0, 7376326, 940, 1461254582, NULL, 2),
(144, '31761461256678', 13, 9, 8, 0, 0, 64311, 4, 1461256678, 1461256683, 1),
(145, '56481461290307', 13, 9, 8, 0, 0, 64311, 5, 1461290307, 1461290312, 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_crawl_settings`
--

CREATE TABLE `app_crawl_settings` (
  `id` int(3) NOT NULL,
  `var_name` varchar(150) NOT NULL,
  `current_value` text NOT NULL,
  `default_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_crawl_settings`
--

INSERT INTO `app_crawl_settings` (`id`, `var_name`, `current_value`, `default_value`) VALUES
(1, 'setFollowMode', '2', '2'),
(2, 'setFollowRedirects', '1', '1'),
(3, 'enableCookieHandling', '1', '1'),
(4, 'enableAggressiveLinkSearch', '1', '1'),
(5, 'obeyRobotsTxt', '0', '0'),
(6, 'obeyNoFollowTags', '0', '0'),
(7, 'setRequestLimit', '50000', '50000'),
(8, 'setTrafficLimit', '104857600', '104857600'),
(9, 'setContentSizeLimit', '2097152', '2097152'),
(10, 'setConnectionTimeout', '10', '10'),
(11, 'setStreamTimeout', '30', '30'),
(12, 'addContentTypeReceiveRule', '#text/html#', '#text/html#'),
(13, 'addURLFollowRule', '', ''),
(14, 'addURLFilterRule', '#\\.(jpg|png|gif|css|js)#', '#\\.(jpg|png|gif|css|js)#'),
(15, 'setCrawlingDepthLimit', '5', '5');

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
  `page_link` int(16) NOT NULL,
  `markup` text NOT NULL,
  `relevance` int(2) NOT NULL,
  `hash` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_links`
--

CREATE TABLE `app_links` (
  `id` int(16) NOT NULL,
  `crawl_id` int(16) DEFAULT NULL,
  `url` varchar(2000) NOT NULL,
  `url_hash` varchar(32) NOT NULL,
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
(2, '4', 'terms-of-use', 'Terms of Use', '<h1 style="text-align: center;">Enjoy ! It\'s Inexpensive</h1>\r\n<p class="lead" style="text-align: center;">Developed forÂ <strong>official use only</strong>Â for the Post Primary School Management Board, Enugu State.</p>', '<p><span style="font-family: \'Agency FB\'; font-size: 15px;">Use freely</span></p>', NULL, NULL, 1, 1460915820, 1460972371, 2, 1);

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
(6, 1, 1, 1461012785, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461013325, 0),
(7, 1, 1, 1461020394, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461020394, 0),
(8, 1, 1, 1461022831, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461022852, 0),
(9, 1, 1, 1461026768, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461026768, 0),
(10, 1, 1, 1461028677, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461034155, 0),
(11, 1, 1, 1461035100, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461197580, 0),
(12, 1, 1, 1461198220, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461198220, 0),
(13, 1, 1, 1461198231, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461290307, 1),
(14, 1, 1, 1461292295, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', '127.0.0.1', 1461292295, 1);

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
  ADD UNIQUE KEY `attribute` (`var_name`);

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
  ADD UNIQUE KEY `hash` (`hash`),
  ADD KEY `link_id` (`page_link`);

--
-- Indexes for table `app_links`
--
ALTER TABLE `app_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_hash` (`url_hash`),
  ADD KEY `ref_page_link` (`parent_page_link`),
  ADD KEY `crawl_id` (`crawl_id`);

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
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT for table `app_crawl_settings`
--
ALTER TABLE `app_crawl_settings`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
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
-- AUTO_INCREMENT for table `app_links`
--
ALTER TABLE `app_links`
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
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
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
  ADD CONSTRAINT `app_forms_ibfk_1` FOREIGN KEY (`page_link`) REFERENCES `app_links` (`id`) ON UPDATE CASCADE;

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
