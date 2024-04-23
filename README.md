# TrendStream
# Project Setup Guide

## 1. Installation of XAMPP

To run this project, you need to install XAMPP. Follow the steps below:

- **Windows:**
  - Download XAMPP from (https://www.apachefriends.org/index.html).
  - Run the installer and follow the installation instructions.
  - Once installed, launch XAMPP Control Panel.

- **macOS:**
  - Download XAMPP from (https://www.apachefriends.org/index.html).
  - Open the downloaded .dmg file and drag the XAMPP folder to your Applications directory.
  - Launch XAMPP from the Applications folder.
- **Linux:**
  - Download XAMPP from [here](https://www.apachefriends.org/index.html).
  - Open your terminal and navigate to the directory where the downloaded file is located.
  - Give execute permissions to the downloaded installer using the command:
    ```
    chmod +x [xampp-installer-filename].run
    ```
  - Run the installer with the command:
    ```
    sudo ./[xampp-installer-filename].run
    ```
  - Follow the installation instructions provided by the installer.


## 2. Starting XAMPP

Follow these steps to start XAMPP:

1. Open XAMPP Control Panel.
2. Start the Apache and MySQL modules by clicking on the "Start" button next to them.
3. Once both modules are running, you can proceed with the next steps.

## 3. Database Setup

After starting XAMPP, navigate to http://localhost/phpmyadmin/ in your web browser.

1. Create a new database named `test`.
2. In the SQL tab of the newly created `test` database, execute the following MySQL commands:

```sql
-- Sample SQL commands to run in the `test` database
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 07:59 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `bcid` int(11) NOT NULL,
  `blog_title` varchar(500) NOT NULL,
  `blog_cover_photo` varchar(10000) NOT NULL,
  `blog_content` longtext NOT NULL,
  `blog_status` varchar(100) NOT NULL,
  `blog_post_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `lcode` varchar(100) NOT NULL,
  `blog_view` int(11) NOT NULL,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--


-- --------------------------------------------------------

--
-- Table structure for table `blog_categorys`
--

CREATE TABLE `blog_categorys` (
  `bcid` int(11) NOT NULL,
  `bcname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_categorys`
--



-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `blog_comment_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `parent_comment_id` int(11) NOT NULL DEFAULT 0,
  `comment` longtext NOT NULL,
  `status_up_del` varchar(100) NOT NULL DEFAULT 'inserted',
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `blog_comment_like_tb`
--

CREATE TABLE `blog_comment_like_tb` (
  `blog_comment_like_id` int(11) NOT NULL,
  `blog_comment_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_clike` varchar(100) NOT NULL,
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_comment_like_tb`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_likes`
--

CREATE TABLE `blog_likes` (
  `blog_like_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `status_like_dislike` varchar(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_likes`
--


-- --------------------------------------------------------

--
-- Table structure for table `blog_viewstb`
--

CREATE TABLE `blog_viewstb` (
  `blog_views_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `blog_viewstb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarktb`
--

CREATE TABLE `bookmarktb` (
  `bmid` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `word` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pos` int(250) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookmarktb`
--



-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `in_usid` int(11) NOT NULL,
  `out_usid` int(11) NOT NULL,
  `msg` mediumtext NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` mediumtext NOT NULL DEFAULT '\'seen,delete,update,singletick,doubletick\''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ctb`
--

CREATE TABLE `ctb` (
  `id` int(11) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ctb`
--

-- --------------------------------------------------------

--
-- Table structure for table `endorse`
--

CREATE TABLE `endorse` (
  `endorse_id` int(11) NOT NULL,
  `request_from_usid` int(11) NOT NULL,
  `request_to_blogger_usid` int(11) NOT NULL,
  `createtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `modify_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_of_subscribe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `lcode` varchar(500) NOT NULL,
  `lname` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `list_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `list_title` varchar(1000) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `list_status` varchar(20) NOT NULL DEFAULT 'private'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lists`
--


-- --------------------------------------------------------

--
-- Table structure for table `lists_content`
--

CREATE TABLE `lists_content` (
  `lcid` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `contant_status` varchar(20) NOT NULL DEFAULT 'private'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lists_content`
--



-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `loginid` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `last_act` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `notify_type` varchar(100) NOT NULL,
  `notify_type_id` int(11) NOT NULL,
  `status_of_seen` varchar(100) NOT NULL DEFAULT 'new',
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `usid`, `notify_type`, `notify_type_id`, `status_of_seen`, `time`) VALUES


-- --------------------------------------------------------

--
-- Table structure for table `readlists`
--

CREATE TABLE `readlists` (
  `readlist_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `readlist_title` varchar(1000) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_blogger_side_show_hide` int(11) DEFAULT NULL,
  `blogs_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `report_type` varchar(100) NOT NULL,
  `report_type_id` int(11) NOT NULL,
  `reason` varchar(10000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--



-- --------------------------------------------------------

--
-- Table structure for table `save_and_history_blogs`
--

CREATE TABLE `save_and_history_blogs` (
  `save_blog_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `type_history_save` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `save_and_history_blogs`
--


-- --------------------------------------------------------

--
-- Table structure for table `searches`
--

CREATE TABLE `searches` (
  `search_id` int(11) NOT NULL,
  `usid` int(11) NOT NULL,
  `serch_type` varchar(100) NOT NULL,
  `serach_type_id` int(11) NOT NULL,
  `searched_text` varchar(10000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usid` int(11) NOT NULL,
  `ufname` varchar(100) DEFAULT NULL,
  `ulname` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(500) NOT NULL,
  `mbno` int(11) DEFAULT NULL,
  `password` varchar(1000) NOT NULL,
  `photo` varchar(10000) DEFAULT NULL,
  `onlinestatus` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `joindate` timestamp NULL DEFAULT current_timestamp(),
  `location_js` varchar(1000) DEFAULT NULL,
  `user_type` varchar(100) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `bcid` (`bcid`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `blog_categorys`
--
ALTER TABLE `blog_categorys`
  ADD PRIMARY KEY (`bcid`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`blog_comment_id`),
  ADD KEY `blog_comments_ibfk_1` (`blog_id`),
  ADD KEY `blog_comments_ibfk_2` (`usid`);

--
-- Indexes for table `blog_comment_like_tb`
--
ALTER TABLE `blog_comment_like_tb`
  ADD PRIMARY KEY (`blog_comment_like_id`),
  ADD KEY `blog_comment_id` (`blog_comment_id`),
  ADD KEY `usid` (`usid`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD PRIMARY KEY (`blog_like_id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `blog_viewstb`
--
ALTER TABLE `blog_viewstb`
  ADD PRIMARY KEY (`blog_views_id`),
  ADD KEY `usid` (`usid`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `bookmarktb`
--
ALTER TABLE `bookmarktb`
  ADD PRIMARY KEY (`bmid`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `ctb`
--
ALTER TABLE `ctb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`lcode`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`list_id`),
  ADD KEY `lists_ibfk_1` (`usid`);

--
-- Indexes for table `lists_content`
--
ALTER TABLE `lists_content`
  ADD PRIMARY KEY (`lcid`),
  ADD KEY `lists_content_ibfk_1` (`blog_id`),
  ADD KEY `lists_content_ibfk_2` (`list_id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`loginid`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `readlists`
--
ALTER TABLE `readlists`
  ADD PRIMARY KEY (`readlist_id`),
  ADD KEY `usid` (`usid`),
  ADD KEY `blogs_id` (`blogs_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `save_and_history_blogs`
--
ALTER TABLE `save_and_history_blogs`
  ADD PRIMARY KEY (`save_blog_id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `searches`
--
ALTER TABLE `searches`
  ADD PRIMARY KEY (`search_id`),
  ADD KEY `usid` (`usid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `blog_categorys`
--
ALTER TABLE `blog_categorys`
  MODIFY `bcid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `blog_comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;

--
-- AUTO_INCREMENT for table `blog_comment_like_tb`
--
ALTER TABLE `blog_comment_like_tb`
  MODIFY `blog_comment_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `blog_likes`
--
ALTER TABLE `blog_likes`
  MODIFY `blog_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `blog_viewstb`
--
ALTER TABLE `blog_viewstb`
  MODIFY `blog_views_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `bookmarktb`
--
ALTER TABLE `bookmarktb`
  MODIFY `bmid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ctb`
--
ALTER TABLE `ctb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `lists_content`
--
ALTER TABLE `lists_content`
  MODIFY `lcid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2058;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `loginid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=749;

--
-- AUTO_INCREMENT for table `readlists`
--
ALTER TABLE `readlists`
  MODIFY `readlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `save_and_history_blogs`
--
ALTER TABLE `save_and_history_blogs`
  MODIFY `save_blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=876;

--
-- AUTO_INCREMENT for table `searches`
--
ALTER TABLE `searches`
  MODIFY `search_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`bcid`) REFERENCES `blog_categorys` (`bcid`),
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  ADD CONSTRAINT `blog_comments_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `blog_comment_like_tb`
--
ALTER TABLE `blog_comment_like_tb`
  ADD CONSTRAINT `blog_comment_like_tb_ibfk_1` FOREIGN KEY (`blog_comment_id`) REFERENCES `blog_comments` (`blog_comment_id`),
  ADD CONSTRAINT `blog_comment_like_tb_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`),
  ADD CONSTRAINT `blog_comment_like_tb_ibfk_3` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`);

--
-- Constraints for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD CONSTRAINT `blog_likes_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  ADD CONSTRAINT `blog_likes_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `blog_viewstb`
--
ALTER TABLE `blog_viewstb`
  ADD CONSTRAINT `blog_viewstb_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`),
  ADD CONSTRAINT `blog_viewstb_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`);

--
-- Constraints for table `bookmarktb`
--
ALTER TABLE `bookmarktb`
  ADD CONSTRAINT `bookmarktb_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  ADD CONSTRAINT `bookmarktb_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lists_content`
--
ALTER TABLE `lists_content`
  ADD CONSTRAINT `lists_content_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lists_content_ibfk_2` FOREIGN KEY (`list_id`) REFERENCES `lists` (`list_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `readlists`
--
ALTER TABLE `readlists`
  ADD CONSTRAINT `readlists_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`),
  ADD CONSTRAINT `readlists_ibfk_2` FOREIGN KEY (`blogs_id`) REFERENCES `blogs` (`blog_id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `save_and_history_blogs`
--
ALTER TABLE `save_and_history_blogs`
  ADD CONSTRAINT `save_and_history_blogs_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  ADD CONSTRAINT `save_and_history_blogs_ibfk_2` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);

--
-- Constraints for table `searches`
--
ALTER TABLE `searches`
  ADD CONSTRAINT `searches_ibfk_1` FOREIGN KEY (`usid`) REFERENCES `users` (`usid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


## 4. **Project Directory Setup**

Navigate to `C:\xampp\htdocs` (Windows) or `/Applications/XAMPP/htdocs` (macOS).

1. Create a folder named `mycode`.
2. Inside `mycode`, create another folder named `template`.
3. Inside `template`, create another folder named `star1`.
4. Place your project files, such as `pages` folder, etc., inside the `star1` folder.

Now, you're all set to run the project. Open your web browser and navigate to `http://localhost/mycode/template/star1` to view your project.
