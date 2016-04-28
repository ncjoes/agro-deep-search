-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2016 at 12:31 PM
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
-- Table structure for table `app_crawl_settings`
--

CREATE TABLE `app_crawl_settings` (
  `id` int(3) NOT NULL,
  `var_name` varchar(150) NOT NULL,
  `current_value` text,
  `default_value` text,
  `multi_valued` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_crawl_settings`
--

INSERT INTO `app_crawl_settings` (`id`, `var_name`, `current_value`, `default_value`, `multi_valued`) VALUES
(1, 'setFollowMode', '3', '3', 0),
(2, 'setFollowRedirects', '1', '1', 0),
(3, 'enableCookieHandling', '1', '1', 0),
(4, 'enableAggressiveLinkSearch', '1', '1', 0),
(5, 'obeyRobotsTxt', '0', '0', 0),
(6, 'obeyNoFollowTags', '0', '0', 0),
(7, 'setRequestLimit', '50000', '50000', 0),
(8, 'setTrafficLimit', '104857600', '104857600', 0),
(9, 'setContentSizeLimit', '2097152', '2097152', 0),
(10, 'setConnectionTimeout', '10', '10', 0),
(11, 'setStreamTimeout', '30', '30', 0),
(15, 'setCrawlingDepthLimit', '5', '5', 0),
(21, 'addContentTypeReceiveRule', '#text/html#|#text/css#', '#text/html#|#text/css#', 1),
(22, 'addURLFilterRule', 'jpg|png|gif|css|js|pdf|exe|apk|m4a|mp4', 'jpg|png|gif|css|js|pdf|exe|apk|m4a|mp4', 1),
(23, 'setLinkExtractionTags', 'href', 'href', 1),
(24, 'addURLFollowRule', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_crawl_settings`
--
ALTER TABLE `app_crawl_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attribute` (`var_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_crawl_settings`
--
ALTER TABLE `app_crawl_settings`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
