-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2021 at 08:37 PM
-- Server version: 8.0.25
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `x83005sz`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`x83005sz`@`localhost` PROCEDURE `under40` ()  BEGIN
			SELECT 
            	qName, name, score 
            FROM 
            	quizzes 
                	natural join 
               			(attempts 
                         	NATURAL JOIN 
                         		students) 
          	WHERE 
            	score < 40;
     	END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `qID` int NOT NULL,
  `qNo` int NOT NULL,
  `ansNo` int NOT NULL,
  `answer` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`qID`, `qNo`, `ansNo`, `answer`, `correct`) VALUES
(26, 1, 1, '1', 0),
(26, 1, 2, '2', 0),
(26, 1, 3, '3', 1),
(26, 1, 4, '4', 0),
(26, 2, 1, '13', 0),
(26, 2, 2, '632', 0),
(26, 2, 3, '24', 1),
(26, 2, 4, '19', 0),
(26, 3, 1, '(x+2)(x+3)', 1),
(26, 3, 2, '(x+1)(x+5)', 0),
(26, 3, 3, '(x+1)(x+6)', 0),
(26, 3, 4, '(x+2)(x+5)', 0),
(27, 1, 1, 'Sam', 1),
(27, 1, 2, 'Charles', 0),
(27, 1, 3, 'William', 0),
(27, 1, 4, 'John', 0),
(27, 2, 1, 'Charles', 1),
(27, 2, 2, 'Sam', 0),
(27, 2, 3, 'Sam', 0),
(27, 2, 4, 'Sam', 0);

-- --------------------------------------------------------

--
-- Table structure for table `attempts`
--

CREATE TABLE `attempts` (
  `qID` int NOT NULL,
  `sID` int NOT NULL,
  `attemptNo` int NOT NULL,
  `attemptDate` date NOT NULL,
  `score` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attempts`
--

INSERT INTO `attempts` (`qID`, `sID`, `attemptNo`, `attemptDate`, `score`) VALUES
(26, 5, 1, '2021-12-02', 66),
(27, 5, 1, '2021-12-02', 100);

-- --------------------------------------------------------

--
-- Table structure for table `deleteAudit`
--

CREATE TABLE `deleteAudit` (
  `sID` int NOT NULL,
  `qID` int NOT NULL,
  `delDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `qID` int NOT NULL,
  `qNo` int NOT NULL,
  `question` varchar(511) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`qID`, `qNo`, `question`) VALUES
(26, 1, '7-4='),
(26, 2, '4*6='),
(26, 3, 'x^2 + 5x + 6 ='),
(27, 1, 'What is my name?'),
(27, 2, 'What is not my name?');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `qID` int NOT NULL,
  `qName` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'My Quiz',
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT '0',
  `duration` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`qID`, `qName`, `author`, `availability`, `duration`) VALUES
(26, 'Advanced Maths Quiz', 'Prof. Teacher', 1, '60 Minutes'),
(27, 'Difficult Quiz', 'Prof. Teacher', 1, '180 Years');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pw` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `username`, `name`, `pw`) VALUES
(1, 'stest', 'stest', '$2y$10$iYQ4RIgBewjf8KGN0Q99eeq/H/uQn8YH4nFFTCF8VJa/YA5tdFJiu'),
(2, 'teacher', 'Prof. Teacher', '$2y$10$TGCKSwmD26CKrq0yPzVc/.E2S2qhBs0eNAsh1ir6VfF9VUSVz7hFO');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `sID` int NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pw` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`sID`, `username`, `name`, `pw`) VALUES
(4, 'test', 'test', '$2y$10$bboJbC1UKDU7SWLDG3.yPunVp6dXQ5E6yW7j3ynXhjboCG1rZa09u'),
(5, 'samuelzureick', 'Samuel Zureick', '$2y$10$Ef62MJowRl6.54M4oKT/3uc3akg5YjFn99.x..fSa6x54dKhwDkoq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`qID`,`qNo`,`ansNo`),
  ADD KEY `qnoFK` (`qNo`,`qID`);

--
-- Indexes for table `attempts`
--
ALTER TABLE `attempts`
  ADD PRIMARY KEY (`qID`,`sID`,`attemptNo`),
  ADD KEY `qIDSID` (`sID`);

--
-- Indexes for table `deleteAudit`
--
ALTER TABLE `deleteAudit`
  ADD PRIMARY KEY (`sID`,`qID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`qID`,`qNo`),
  ADD KEY `qNo` (`qNo`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`qID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`sID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `qID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `attempts`
--
ALTER TABLE `attempts`
  MODIFY `qID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `qID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `qID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `sID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `qnoFK` FOREIGN KEY (`qNo`,`qID`) REFERENCES `questions` (`qNo`, `qID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attempts`
--
ALTER TABLE `attempts`
  ADD CONSTRAINT `qiDDel` FOREIGN KEY (`qID`) REFERENCES `quizzes` (`qID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `qIDSID` FOREIGN KEY (`sID`) REFERENCES `students` (`sID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `qIDFK` FOREIGN KEY (`qID`) REFERENCES `quizzes` (`qID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
