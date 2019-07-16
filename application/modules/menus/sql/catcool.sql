-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 14, 2019 at 05:36 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catcool`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `context` varchar(100) DEFAULT '',
  `language` varchar(30) DEFAULT 'vn',
  `precedence` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `description`, `context`, `language`, `precedence`, `parent_id`, `published`, `ctime`, `mtime`) VALUES
(7, 'lê minh đạt', 'le-minh-dat', 'văn', 'menu', 'vn', 0, 0, 'no', '2019-07-10 16:28:07', '2019-07-13 12:51:08'),
(8, 'dat', 'dat', 'fgfd w', 'dsad', 'vn', 1, 0, 'yes', '2019-07-11 16:55:38', '2019-07-13 12:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `dummy`
--

CREATE TABLE `dummy` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `language` varchar(30) DEFAULT 'vn',
  `precedence` int(11) DEFAULT NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dummy`
--

INSERT INTO `dummy` (`id`, `title`, `description`, `language`, `precedence`, `published`, `ctime`, `mtime`) VALUES
(2, 'tên gì mầyvv', 'mô tả 2', 'english', 2, 'no', '2019-07-13 19:25:50', '2019-07-14 08:58:40'),
(7, 'dfgdfg', 'fdssaf', 'english', 1, 'yes', '2019-07-14 16:04:27', '2019-07-14 09:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'admin permission all', 'tất cả quyền thực thi'),
(4, 'admin read', 'Chỉ được xem'),
(5, 'admin edit', 'Chỉ được cập nhật'),
(6, 'admin add', 'Chỉ được thêm mới'),
(7, 'admin delete', 'Được xoá');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `context` varchar(100) DEFAULT '',
  `language` varchar(30) DEFAULT 'vn',
  `precedence` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `slug`, `description`, `context`, `language`, `precedence`, `user_id`, `parent_id`, `published`, `ctime`, `mtime`) VALUES
(1, 'Quản lý Danh mục', 'categories/manage', '', 'admin', 'vn', 0, 1, 0, 'yes', '2019-07-13 22:04:03', '2019-07-14 09:11:16'),
(2, 'Danh sách', 'cate', '', 'admin', 'vn', 0, 1, 1, 'yes', '2019-07-13 23:01:13', '2019-07-14 09:11:36'),
(3, 'Thêm mới danh mục', 'categories/manage/add', '', 'admin', 'vn', 0, 1, 1, 'yes', '2019-07-13 23:04:05', '2019-07-14 09:11:26'),
(4, 'System', 'system', '', 'admin', 'vn', 0, 1, 0, 'yes', '2019-07-13 23:27:29', '2019-07-13 16:27:29'),
(5, 'Tạo module', 'catcool/builder', '', 'admin', 'vn', 0, 1, 4, 'yes', '2019-07-13 23:30:03', '2019-07-13 16:30:03'),
(6, 'Dummy', 'dummy/manage', '', 'admin', 'vn', 0, 1, 4, 'yes', '2019-07-13 23:31:17', '2019-07-13 16:31:17'),
(7, 'Users', 'user', '', 'admin', 'vn', 2, 1, 0, 'yes', '2019-07-13 23:32:27', '2019-07-14 10:01:57'),
(10, 'Quản lý Danh mục', 'user/auth', '', 'admin', 'vn', 0, 1, 7, 'yes', '2019-07-13 23:36:53', '2019-07-13 16:36:53'),
(11, 'Template', 'user_guide/theme/concept-master/pages/general.html', '', 'admin', 'vn', 0, 1, 4, 'yes', '2019-07-13 23:38:53', '2019-07-13 16:38:53'),
(12, 'Quản lý Menu', 'menus/manage', '', 'admin', 'vn', 5, 1, 4, 'yes', '2019-07-13 23:42:40', '2019-07-14 10:00:36'),
(13, 'Tạo nhóm', 'user/auth/create_group', '', 'admin', 'vn', 0, 1, 7, 'yes', '2019-07-13 23:43:07', '2019-07-13 16:43:07'),
(14, 'etret', 'etret', 'tret', '', 'vn', 0, 1, 0, 'yes', '2019-07-14 18:14:41', '2019-07-14 11:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$ccTxQqJVXLJjZV2nTeXCNO2E68LwJuRuuj/Ujm.Are9mUVG/JQ.FS', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1563085936, 1, 'Admin', 'istrator', 'ADMIN', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(20, 1, 1),
(21, 1, 2),
(22, 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `dummy`
--
ALTER TABLE `dummy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dummy`
--
ALTER TABLE `dummy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `articles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NULL,
  `content` text NOT NULL DEFAULT '',
  `image` varchar(255) NULL,
  `seo_title` varchar(255) NULL,
  `seo_description` varchar(255) NULL,
  `seo_keyword` varchar(255) NULL,
  `publish_date` DATETIME NOT NULL DEFAULT '00-00-00 00\:00\:00',
  `is_comment` enum('yes','no') NOT NULL DEFAULT 'yes',
  `tags` varchar(255) NULL,
  `language` varchar(30) NULL DEFAULT 'vn',
  `precedence` int NULL,
  `user_id` int NOT NULL,
  `user_ip` varchar(40) NULL,
  `counter_view` int NULL,
  `counter_comment ` int NULL,
  `counter_like` int NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  `is_delete` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ctime` DATETIME NOT NULL DEFAULT '00-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
