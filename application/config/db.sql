-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2017 at 10:28 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `flexup`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminuser`
--

CREATE TABLE `adminuser` (
  `admin_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `clientenrollment`
--

CREATE TABLE `clientenrollment` (
  `enrollment_id` int(11) NOT NULL,
  `userClient_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clientenrollment`
--

INSERT INTO `clientenrollment` (`enrollment_id`, `userClient_id`, `project_id`) VALUES
(2, 9, 10),
(3, 9, 12),
(4, 7, 9),
(5, 7, 9),
(6, 7, 10),
(7, 11, 9),
(8, 11, 10),
(9, 11, 12),
(10, 7, 11),
(11, 7, 16),
(12, 7, 17);

-- --------------------------------------------------------

--
-- Table structure for table `clientsubmissions`
--

CREATE TABLE `clientsubmissions` (
  `submission_id` int(11) NOT NULL,
  `userClient_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `part_id` int(11) DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `submission_link` text NOT NULL,
  `submission_comment` text NOT NULL,
  `submitted` tinyint(1) NOT NULL DEFAULT '1',
  `completed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `clientuser`
--

CREATE TABLE `clientuser` (
  `userClient_id` int(11) NOT NULL,
  `userClient_firstName` varchar(255) NOT NULL,
  `userClient_lastName` varchar(255) NOT NULL,
  `userClient_email` varchar(255) NOT NULL,
  `userClient_authtype` varchar(50) NOT NULL DEFAULT 'email',
  `userClient_username` varchar(255) DEFAULT NULL,
  `userClient_password` varchar(255) NOT NULL,
  `userClient_interests` varchar(255) NOT NULL,
  `active` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `projectfields`
--

CREATE TABLE `projectfields` (
  `field_id` int(255) NOT NULL,
  `field_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_timeline` varchar(255) NOT NULL,
  `project_fields` varchar(255) NOT NULL,
  `project_location` varchar(255) NOT NULL,
  `project_description` mediumtext NOT NULL,
  `project_thumb` text NOT NULL,
  `created_by` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `project_parts`
--

CREATE TABLE `project_parts` (
  `part_id` int(11) NOT NULL,
  `part_name` varchar(255) DEFAULT NULL,
  `part_description` longtext NOT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `project_readinglist`
--

CREATE TABLE `project_readinglist` (
  `readingList_id` int(11) NOT NULL,
  `readingList_link` varchar(255) DEFAULT NULL,
  `readingList_name` varchar(255) DEFAULT NULL,
  `part_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `project_tasks`
--

CREATE TABLE `project_tasks` (
  `task_id` int(255) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `task_details` mediumtext,
  `part_id` int(225) DEFAULT NULL,
  `project_id` int(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminuser`
--
ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `clientenrollment`
--
ALTER TABLE `clientenrollment`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `userClient_id` (`userClient_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `clientsubmissions`
--
ALTER TABLE `clientsubmissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `userClient_id` (`userClient_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `part_id` (`part_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `clientuser`
--
ALTER TABLE `clientuser`
  ADD PRIMARY KEY (`userClient_id`);

--
-- Indexes for table `projectfields`
--
ALTER TABLE `projectfields`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `project_parts`
--
ALTER TABLE `project_parts`
  ADD PRIMARY KEY (`part_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_readinglist`
--
ALTER TABLE `project_readinglist`
  ADD PRIMARY KEY (`readingList_id`),
  ADD KEY `part_id` (`part_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_tasks`
--
ALTER TABLE `project_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `part_id` (`part_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminuser`
--
ALTER TABLE `adminuser`
  MODIFY `admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `clientenrollment`
--
ALTER TABLE `clientenrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `clientsubmissions`
--
ALTER TABLE `clientsubmissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `clientuser`
--
ALTER TABLE `clientuser`
  MODIFY `userClient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `projectfields`
--
ALTER TABLE `projectfields`
  MODIFY `field_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `project_parts`
--
ALTER TABLE `project_parts`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `project_readinglist`
--
ALTER TABLE `project_readinglist`
  MODIFY `readingList_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `project_tasks`
--
ALTER TABLE `project_tasks`
  MODIFY `task_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `clientenrollment`
--
ALTER TABLE `clientenrollment`
  ADD CONSTRAINT `clientenrollment_ibfk_1` FOREIGN KEY (`userClient_id`) REFERENCES `clientuser` (`userClient_id`),
  ADD CONSTRAINT `clientenrollment_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `clientsubmissions`
--
ALTER TABLE `clientsubmissions`
  ADD CONSTRAINT `clientsubmissions_ibfk_1` FOREIGN KEY (`userClient_id`) REFERENCES `clientuser` (`userClient_id`),
  ADD CONSTRAINT `clientsubmissions_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `clientsubmissions_ibfk_3` FOREIGN KEY (`part_id`) REFERENCES `project_parts` (`part_id`),
  ADD CONSTRAINT `clientsubmissions_ibfk_4` FOREIGN KEY (`task_id`) REFERENCES `project_tasks` (`task_id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `adminuser` (`admin_id`);

--
-- Constraints for table `project_parts`
--
ALTER TABLE `project_parts`
  ADD CONSTRAINT `project_parts_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `project_readinglist`
--
ALTER TABLE `project_readinglist`
  ADD CONSTRAINT `project_readinglist_ibfk_1` FOREIGN KEY (`part_id`) REFERENCES `project_parts` (`part_id`),
  ADD CONSTRAINT `project_readinglist_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `project_tasks`
--
ALTER TABLE `project_tasks`
  ADD CONSTRAINT `project_tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `project_tasks_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `project_parts` (`part_id`);
