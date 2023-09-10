-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2023 at 09:28 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clean-blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(8, 'ff', 'ff', '2023-08-24 23:17:49', '2023-08-24 23:17:49');

-- --------------------------------------------------------

--
-- Table structure for table `favourite_posts`
--

CREATE TABLE `favourite_posts` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favourite_posts`
--

INSERT INTO `favourite_posts` (`id`, `post_id`, `user_id`) VALUES
(2, 2, 1),
(3, 1, 1),
(6, 6, 1),
(7, 10, 1),
(8, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `from_user`, `to_user`, `message`, `created_at`) VALUES
(1, 1, 2, 'sdaffffffffffffffffffffffffffffffff', '2023-08-25 00:25:42'),
(2, 2, 2, 'aaaaaaaaaaaaaaaaaaaaaaa', '2023-08-25 00:25:42'),
(3, 1, 2, 'aaaaaaaaaaaaaaaaaaaaadfsffffffffaaa', '2023-08-25 00:25:42'),
(4, 1, 2, 'aaaaaaaaaaaaaaaaaaaaaadfsffffffffaaa', '2023-08-25 00:25:42'),
(5, 3, 1, 'aaaaaaaaaaaaaaaaaaaaadfsffffffffaaa', '2023-08-25 00:25:42'),
(6, 2, 1, 'd', '2023-08-25 02:37:37'),
(7, 1, 5, 'as', '2023-08-25 04:35:16'),
(8, 1, 5, 'dd', '2023-08-25 04:35:19'),
(9, 1, 5, 'ff', '2023-08-25 04:35:23'),
(10, 1, 3, 'cc', '2023-08-25 04:43:35');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `tag_id` int(11) UNSIGNED NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `content` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `featured` int(11) NOT NULL DEFAULT 0,
  `soft_deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `user_id`, `category_id`, `tag_id`, `featured_image`, `excerpt`, `content`, `views`, `featured`, `soft_deleted`, `created_at`, `updated_at`) VALUES
(5, 'aaaaaaaaaa', 'aaaaaaaaaa', 2, 8, 10, 'a', '<p>a</p>', '<p>a</p>', 0, 0, 0, '2023-08-22 09:10:30', '2023-08-22 09:10:30'),
(7, 'aas3dfff', 'aaa3f', 0, 0, 0, '', 'fad', 'asdf', 0, 0, 0, '2023-08-22 09:10:30', '2023-08-22 09:10:30'),
(9, 'aafdas3dfff', 'aaaaa3f', 0, 0, 0, '', 'fad', 'asdf', 0, 0, 0, '2023-08-22 09:10:30', '2023-08-22 09:10:30'),
(10, 'aafasdfdas3dfff', 'aaaasdfaa3f', 0, 0, 0, '', 'fad', 'asdf', 0, 0, 0, '2023-08-22 09:10:30', '2023-08-22 09:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(10, 'Yousef Zaqout', 'Yousef-Zaqout', '2023-08-24 23:17:16', '2023-08-24 23:17:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `banned` int(11) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 1,
  `ip_address` varchar(255) NOT NULL,
  `about_me` text DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT 'https://th.bing.com/th/id/OIP.fbmFIg35_BLxLPrC7_vQbgAAAA?pid=ImgDet&rs=1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `slug`, `email`, `password`, `is_admin`, `banned`, `active`, `ip_address`, `about_me`, `website_url`, `phone`, `street`, `city`, `state`, `postal_code`, `featured_image`, `created_at`, `updated_at`) VALUES
(1, 'Adidas', 'Yousef-Zaqout', 'zaqoutyouesef@gmail.com', '$2y$10$jl9biZ9RPbAIxmOTogqDje/gZndqOtRUb3ydIgY/lW7fTWprVMTcu', 0, 0, 1, '', 'aaaaaaaaaaasddddddddddddddddddd', 'http://localhost/iug/2.2/clean-blog/my-account.php', '0598504826', 'Palestine', 'a', 'd', 'd', 'https://th.bing.com/th/id/OIP.fbmFIg35_BLxLPrC7_vQbgAAAA?pid=ImgDet&rs=1', '2023-08-20 07:37:12', '2023-08-20 07:37:12'),
(3, 'Yousef Zaqout', NULL, 'zaqoutyousessf@gmail.com', '$2y$10$8diMXgSHDoaP18FGujpmk.aehQJB8ZU2q6BMiyBPaJt2g/4aRr8ai', 0, 0, 1, '::1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://th.bing.com/th/id/OIP.fbmFIg35_BLxLPrC7_vQbgAAAA?pid=ImgDet&rs=1', '2023-08-22 07:11:43', '2023-08-22 07:11:43'),
(5, 'zz', 'zz', 'zz@gmail.com', '$2y$10$ftnXF.xf7JFMu7pa/oXsI.i30dFMi0FBgwDO2HaOSJvoXs9YdYhYW', 1, 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://th.bing.com/th/id/OIP.fbmFIg35_BLxLPrC7_vQbgAAAA?pid=ImgDet&rs=1', '2023-08-25 00:07:43', '2023-08-25 00:07:43'),
(6, 'Yousef Basem', NULL, 'yosa.147@hotmail.com', '$2y$10$BEG6VQjhFvRoVkvuPbqqU.sloiS3DEwwC55ZbvVTHkHGG8UrIj93W', 0, 0, 1, '::1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://th.bing.com/th/id/OIP.fbmFIg35_BLxLPrC7_vQbgAAAA?pid=ImgDet&rs=1', '2023-08-25 07:17:11', '2023-08-25 07:17:11'),
(7, 'Yousef Zaqout', NULL, 'zaqoutyousef@gmail.com', '$2y$10$QeP1pgxj7iZ5ft.fPDBdhenzX5LlVmL20wQXe/jR/Oto8IdeEBKgW', 0, 0, 1, '::1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://th.bing.com/th/id/OIP.fbmFIg35_BLxLPrC7_vQbgAAAA?pid=ImgDet&rs=1', '2023-08-25 07:22:18', '2023-08-25 07:22:18');

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
-- Indexes for table `favourite_posts`
--
ALTER TABLE `favourite_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`slug`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`slug`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `UNIQUE` (`slug`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `favourite_posts`
--
ALTER TABLE `favourite_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
