-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2016 at 04:09 PM
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
-- Indexes for dumped tables
--

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
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bb_post_categories`
--
ALTER TABLE `bb_post_categories`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bb_sessions`
--
ALTER TABLE `bb_sessions`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bb_users`
--
ALTER TABLE `bb_users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bb_users_privileges`
--
ALTER TABLE `bb_users_privileges`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
