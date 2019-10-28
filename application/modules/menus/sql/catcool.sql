-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2019 at 12:04 PM
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
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `seo_keyword` varchar(255) DEFAULT NULL,
  `publish_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `images` varchar(255) DEFAULT NULL,
  `categories` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_ip` varchar(40) DEFAULT '0.0.0.0',
  `counter_view` int(11) DEFAULT '0',
  `counter_comment` int(11) DEFAULT '0',
  `counter_like` int(11) DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `language` varchar(30) DEFAULT 'vn',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `description`, `content`, `seo_title`, `seo_description`, `seo_keyword`, `publish_date`, `is_comment`, `images`, `categories`, `tags`, `author`, `source`, `sort_order`, `user_id`, `user_ip`, `counter_view`, `counter_comment`, `counter_like`, `published`, `language`, `is_delete`, `ctime`, `mtime`) VALUES
(1, 'dsfadfgfdg', 'dagfdg', 'dfgg', '', NULL, NULL, NULL, '0000-00-00 00:00:00', 'yes', NULL, NULL, NULL, NULL, NULL, 16, 0, '0.0.0.0', 0, 0, 0, 'yes', 'vn', 'no', '2019-07-17 16:57:57', '2019-07-17 09:57:57'),
(3, 'dsfds', 'fdfdf', 'dfd', 'fsdf', 'dsfds', 'fds', 'fdds', '0000-00-00 00:00:00', 'yes', NULL, NULL, NULL, NULL, NULL, 0, 0, '0.0.0.0', 0, 0, 0, 'yes', 'vn', 'no', '2019-07-17 16:58:56', '2019-07-17 10:22:03'),
(4, 'fadsf', 'dfdsf', 'dfdsf', '<p>dfdsaf</p>', NULL, NULL, NULL, '2019-07-24 15:24:00', 'yes', '[\"article\\/2019\\/07\\/23\\/luckybag_items_try13.png\"]', 'false', NULL, NULL, NULL, NULL, 0, '::1', 0, 0, 0, 'no', 'vn', 'no', '2019-07-23 15:43:47', '2019-07-24 02:13:48'),
(5, 'ddd', 'dd', 'dđ', '<p>ddđ</p>', NULL, NULL, NULL, '2019-07-23 15:48:00', 'yes', '[\"article\\/2019\\/07\\/23\\/screenshot-localhost-2019_07_19-13-54-17.png\",\"article\\/2019\\/07\\/23\\/luckybag_confirm1.png\"]', 'false', NULL, NULL, NULL, NULL, 0, '::1', 0, 0, 0, 'no', 'vn', 'no', '2019-07-23 15:48:15', '2019-07-24 02:03:32');

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
  `sort_order` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `description`, `context`, `language`, `sort_order`, `parent_id`, `published`, `ctime`, `mtime`) VALUES
(7, 'lê minh đạt', 'le-minh-dat', 'văn', 'menu', 'vn', 0, 0, 'no', '2019-07-10 16:28:07', '2019-07-13 12:51:08'),
(8, 'dat', 'dat', 'fgfd w', 'dsad', 'vn', 1, 0, 'yes', '2019-07-11 16:55:38', '2019-07-13 12:51:02'),
(9, 'test', 'test', '', NULL, 'vn', 0, 0, 'yes', '2019-07-24 14:45:55', '2019-07-24 07:45:55'),
(10, 'fdsfdsf', 'fdsfdsf', '', NULL, 'vn', 0, 0, 'yes', '2019-07-24 16:39:43', '2019-07-24 09:39:43'),
(12, '33333', '33333', 'fdgfd', NULL, 'vn', 0, 0, 'yes', '2019-07-24 16:44:18', '2019-07-24 09:44:18'),
(13, '33333555', '33333555', 'fdgfd', NULL, 'vn', 0, 0, 'yes', '2019-07-24 16:46:49', '2019-07-24 09:46:49'),
(14, '11111', '11111', '', NULL, 'vn', 0, 0, 'yes', '2019-07-24 16:56:39', '2019-07-24 09:56:39'),
(15, 'dsvdba', 'dsvdba', '', NULL, 'vn', 0, 0, 'yes', '2019-07-24 16:58:18', '2019-07-24 09:58:18'),
(16, 'đạt lê minh ', 'djat-le-minh', '', NULL, 'vn', 0, 0, 'yes', '2019-07-24 16:58:37', '2019-07-24 09:58:37'),
(17, 'master 3', 'master-3', '', NULL, 'vn', 0, 0, 'yes', '2019-07-24 17:06:29', '2019-07-24 10:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` int(10) UNSIGNED NOT NULL,
  `config_key` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `config_key`, `config_value`, `description`, `user_id`, `published`, `ctime`, `mtime`) VALUES
(1, 'language', '\"vn\"', 'Ngôn ngữ mặc định', 1, 'yes', '2019-08-15 15:01:06', '2019-08-15 08:01:06'),
(2, 'is_multi_language', 'TRUE', 'Đa ngôn ngữ?', 1, 'yes', '2019-08-15 15:18:11', '2019-08-15 08:18:11'),
(3, 'multi_language', '[\'vn\' => \'vietnam\', \'english\' => \'english\']', 'Danh sách ngôn ngữ', 1, 'no', '2019-08-15 15:19:06', '2019-09-03 04:21:13'),
(4, 'is_show_select_language', 'false', 'Hiển thị Selectbox ngôn ngữ?', 1, 'yes', '2019-08-15 15:21:34', '2019-08-15 08:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `dummy`
--

CREATE TABLE `dummy` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `language` varchar(30) DEFAULT 'vn',
  `sort_order` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dummy`
--

INSERT INTO `dummy` (`id`, `title`, `description`, `language`, `sort_order`, `published`, `ctime`, `mtime`) VALUES
(2, 'tên gì mầyvv', 'mô tả 2', 'english', 2, 'no', '2019-07-13 19:25:50', '2019-07-14 08:58:40'),
(7, 'tessss', 'sss', 'english', 1, 'no', '2019-07-14 16:04:27', '2019-08-08 04:45:22'),
(8, 'dat le', 'mo ta', 'vn', 1, 'yes', '2019-07-14 16:04:27', '2019-08-08 04:45:22'),
(9, '111111', 'mo ta', 'english', 1, 'yes', '2019-07-14 16:04:27', '2019-08-08 04:45:22'),
(10, '2222', 'mo ta', 'english', 1, 'yes', '2019-07-14 16:04:27', '2019-08-08 04:45:22'),
(11, '3333', 'mo ta', 'english', 3, 'no', '2019-07-14 16:04:27', '2019-08-08 04:45:22'),
(12, 'them moi 22', 'mo ta', 'vn', NULL, 'yes', '2019-08-08 14:03:43', '2019-08-08 07:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `code` varchar(100) NOT NULL DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `user_id`, `published`, `ctime`, `mtime`) VALUES
(1, 'vietnam', 'vn', 1, 'yes', '2019-08-19 16:48:48', '2019-08-19 09:48:48'),
(2, 'english', 'english', 1, 'yes', '2019-08-19 16:50:15', '2019-09-03 03:51:39');

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
  `icon` varchar(100) DEFAULT NULL,
  `nav_key` varchar(100) DEFAULT '',
  `label` varchar(100) DEFAULT '',
  `attributes` varchar(255) DEFAULT NULL,
  `selected` varchar(255) DEFAULT '',
  `language` varchar(30) DEFAULT 'vn',
  `sort_order` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `slug`, `description`, `context`, `icon`, `nav_key`, `label`, `attributes`, `selected`, `language`, `sort_order`, `user_id`, `parent_id`, `is_admin`, `hidden`, `published`, `ctime`, `mtime`) VALUES
(1, 'System', '#', '', '', 'fas fa-cogs fa-spin', '', '', '', 'catcool', 'vn', 0, 1, 0, 'yes', 'no', 'yes', '2019-09-03 14:44:12', '2019-09-03 07:44:12'),
(2, 'Configs', 'catcool/configs/manage', '', '', 'fas fa-cog', '', '', '', 'catcool/configs', 'vn', 0, 1, 1, 'yes', 'no', 'yes', '2019-09-03 15:05:56', '2019-09-03 08:05:56'),
(3, 'Languages', 'catcool/languages/manage', '', '', 'fas fa-flag-checkered', '', '', '', 'catcool/languages', 'vn', 0, 1, 0, 'yes', 'no', 'yes', '2019-09-03 15:27:38', '2019-09-03 08:27:38'),
(4, 'Modules', 'catcool/modules/manage', '', '', '', '', '', '', 'catcool/modules', 'vn', 0, 1, 1, 'yes', 'no', 'yes', '2019-09-03 15:57:27', '2019-09-03 08:57:27'),
(5, 'Routes', 'catcool/routes/manage', '', '', '', '', '', '', 'catcool/routes', 'vn', 0, 1, 1, 'yes', 'no', 'yes', '2019-09-03 16:17:12', '2019-09-03 09:17:12'),
(6, 'Tạo module', 'catcool/buibuilder', '', '', 'fas fa-file-medical', '', '', '', 'catcool/buibuilder', 'vn', 0, 1, 1, 'yes', 'no', 'yes', '2019-09-03 16:22:44', '2019-09-03 09:22:44'),
(7, 'Dummy', 'dummy/manage', '', '', 'fas fa-copy', '', '', '', 'dummy', 'vn', 0, 1, 1, 'yes', 'no', 'yes', '2019-09-03 16:31:21', '2019-09-03 09:31:21'),
(8, 'Menus', 'menus/manage', '', '', 'fas fa-sitemap', '', '', '', 'menus', 'vn', 0, 1, 0, 'yes', 'no', 'yes', '2019-09-03 16:32:29', '2019-09-03 09:32:29'),
(9, 'Danh mục', ' categories/manage', '', '', 'fas fa-list', '', '', '', 'categories', 'vn', 0, 1, 0, 'yes', 'no', 'yes', '2019-09-03 16:35:35', '2019-09-03 09:35:35'),
(10, 'Users', 'users/manage', '', '', 'fas fa-user', '', '', '', 'users', 'vn', 0, 1, 0, 'yes', 'no', 'yes', '2019-09-03 16:38:33', '2019-09-03 09:38:33'),
(11, 'Thêm mới User', 'users/manage/add', '', '', 'fas fa-user-plus', '', '', '', 'users', 'vn', 0, 1, 10, 'yes', 'no', 'yes', '2019-09-03 16:39:52', '2019-09-03 09:39:52'),
(12, 'Groups', 'users/groups/manage', '', '', NULL, '', '', '', 'groups', 'vn', 0, 1, 10, 'yes', 'no', 'yes', '2019-09-03 16:43:42', '2019-09-03 09:43:42'),
(13, 'Permissions', 'permissions/manage', '', '', 'fas fa-key', '', '', '', 'permissions', 'vn', 0, 1, 0, 'yes', 'no', 'yes', '2019-09-03 16:48:33', '2019-09-03 09:48:33'),
(14, 'relationships', 'relationships/manage', '', '', '', '', '', '', 'relationships', 'vn', 0, 1, 0, 'yes', 'no', 'yes', '2019-09-03 16:54:54', '2019-09-03 09:54:54'),
(15, 'Images', 'images/manage', '', '', 'fas fa-images', '', '', '', 'images', 'vn', 0, 1, 0, 'yes', 'no', 'yes', '2019-09-03 17:02:48', '2019-09-03 10:02:48'),
(16, 'Tin tức', 'articles/manage', '', '', 'far fa-newspaper', '', '', '', 'articles', 'vn', 0, 1, 0, 'yes', 'no', 'yes', '2019-09-03 17:09:24', '2019-09-03 10:09:24'),
(17, 'Template', 'user_guide/theme/concept-master/pages/icon-fontawesome.html', '', '', '', '', '', '', '', 'vn', 0, 1, 1, 'yes', 'no', 'yes', '2019-09-04 10:50:04', '2019-09-04 03:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `module` varchar(100) NOT NULL DEFAULT '',
  `sub_module` varchar(100) DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module`, `sub_module`, `user_id`, `published`, `ctime`, `mtime`) VALUES
(1, 'users', 'groups', 1, 'yes', '2019-08-19 11:20:07', '2019-08-19 04:20:07'),
(2, 'users', '', 1, 'yes', '2019-08-19 11:20:07', '2019-08-19 04:20:07'),
(3, 'permissions', NULL, 1, 'yes', '2019-09-03 11:12:15', '2019-09-03 04:12:15'),
(4, 'categories', NULL, 1, 'yes', '2019-09-03 11:13:10', '2019-09-03 04:13:10'),
(5, 'dummy', NULL, 1, 'yes', '2019-09-03 11:13:25', '2019-09-03 04:13:25'),
(6, 'images', NULL, 1, 'yes', '2019-09-03 11:13:37', '2019-09-03 04:13:37'),
(7, 'menus', NULL, 1, 'yes', '2019-09-03 11:13:48', '2019-09-03 04:13:48'),
(8, 'relationships', NULL, 1, 'yes', '2019-09-03 11:14:04', '2019-09-03 04:14:04'),
(9, 'catcool', NULL, 1, 'yes', '2019-09-03 11:14:33', '2019-09-03 04:14:33'),
(10, 'catcool', 'configs', 1, 'yes', '2019-09-03 11:15:31', '2019-09-03 04:15:31'),
(11, 'catcool', 'languages', 1, 'yes', '2019-09-03 11:15:59', '2019-09-03 04:15:59'),
(12, 'catcool', 'modules', 1, 'yes', '2019-09-03 11:16:08', '2019-09-03 04:16:08'),
(13, 'catcool', 'translations', 1, 'yes', '2019-09-03 11:17:30', '2019-09-03 04:17:30'),
(14, 'catcool', 'routes', 1, 'yes', '2019-09-03 11:17:42', '2019-09-03 04:17:42'),
(15, 'articles', NULL, 1, 'yes', '2019-09-03 11:18:27', '2019-09-03 04:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `published`) VALUES
(1, 'users/manage/delete', 'User Manage', 'yes'),
(2, 'users/manage/add', 'User add', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE `relationships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_table` varchar(100) NOT NULL,
  `candidate_key` int(11) NOT NULL,
  `foreign_table` varchar(100) NOT NULL,
  `foreign_key` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(10) UNSIGNED NOT NULL,
  `module` varchar(255) NOT NULL DEFAULT '',
  `resource` varchar(255) NOT NULL DEFAULT '',
  `route` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `module`, `resource`, `route`, `user_id`, `published`, `ctime`, `mtime`) VALUES
(1, 'dummy', 'dummy', 'copy-module', 1, 'no', '2019-08-14 16:30:19', '2019-08-14 09:30:19'),
(2, 'menus', 'manage', 'quan-ly-menu', 1, 'yes', '2019-08-15 09:55:01', '2019-08-15 02:55:01'),
(3, 'ttttttt', 'fds', 'sfsd', 1, 'yes', '2019-08-15 10:33:41', '2019-08-15 03:33:41');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `lang_key` varchar(100) NOT NULL DEFAULT '',
  `lang_value` varchar(100) NOT NULL DEFAULT '',
  `lang_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
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
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT '0000-00-00',
  `gender` tinyint(1) DEFAULT '1',
  `image` varchar(255) DEFAULT NULL,
  `super_admin` tinyint(1) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(30) DEFAULT 'vn',
  `ip_address` varchar(45) NOT NULL,
  `ctime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `address`, `dob`, `gender`, `image`, `super_admin`, `status`, `is_delete`, `language`, `ip_address`, `ctime`, `mtime`) VALUES
(1, 'admin', '$2y$12$9L5zoOUCIchYDGlFM/yVC.NlaGxhGb1P0QXwTOkR02QMjVJQTOqr6', 'admin@admin.com', NULL, '', NULL, NULL, NULL, 'f0f91483a74e347d459af09731a4b25adf19852a', '$2y$10$7YvyHU9XBPG5HTKGBbcpvOOS87u1e2y/HCXyEKB9OsRLNgWNRzd76', 1268889823, 1567561978, 1, 'Admin', 'istrator', 'ADMIN', '0', NULL, '0000-00-00', 1, NULL, 1, NULL, 'no', 'vn', '127.0.0.1', '0000-00-00 00:00:00', '2019-09-04 01:52:58'),
(2, 'lmd.dat@gmail.com', '$2y$10$/gcrN1Ai2waDIsl5oXoceeEQZCdFSh7egz3AIA/GOHXLVyKOgNC6G', 'lmd.dat@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1564627061, NULL, 1, 'gfdg', 'gfd', 'dsadsadsa', '982523331', '90 Nguyễn Đình Chiểu P. Đa Kao', '0000-00-00', 0, NULL, 1, NULL, 'no', 'vn', '::1', '0000-00-00 00:00:00', '2019-08-08 03:00:17'),
(4, 'admin11', '$2y$10$AZ6rJc2T0p0ycI79/4ZigO1TCVOTfuLCtg9k/rtZLINwqewjZGAnq', 'lmdd.dat@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1565173913, NULL, 1, 'đạt', 'lê', 'cong ty', '982523331', '90 Nguyễn Đình Chiểu P. Đa Kao', '2019-08-04', 1, 'article/2019/08/06/screenshot-localhost-2019_07_19-13-54-17.png', 0, NULL, 'yes', 'vn', '::1', '2019-08-06 10:09:40', '2019-08-08 04:39:11'),
(8, 'admin22', '$2y$10$AZ6rJc2T0p0ycI79/4ZigO1TCVOTfuLCtg9k/rtZLINwqewjZGAnq', 'lm3d.dat@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1565173913, NULL, 1, 'đạt', 'lê', 'cong ty', '982523331', '90 Nguyễn Đình Chiểu P. Đa Kao', '2019-08-04', 1, 'article/2019/08/06/screenshot-localhost-2019_07_19-13-54-17.png', 0, NULL, 'yes', 'vn', '::1', '2019-08-06 10:09:40', '2019-08-08 04:39:11');

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
(1, 1, 1),
(2, 1, 2),
(3, 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `publish_date` (`publish_date`),
  ADD KEY `published` (`published`,`is_delete`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `languages`
--
ALTER TABLE `languages`
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
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `relationships`
--
ALTER TABLE `relationships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_key` (`candidate_table`,`candidate_key`,`foreign_table`,`foreign_key`),
  ADD KEY `candidate_table` (`candidate_table`,`candidate_key`),
  ADD KEY `foreign_table` (`foreign_table`,`foreign_key`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lang_key` (`lang_key`,`module_id`,`lang_id`);

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
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dummy`
--
ALTER TABLE `dummy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `relationships`
--
ALTER TABLE `relationships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
