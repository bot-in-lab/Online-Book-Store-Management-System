-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 08:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_book_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ad_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ph_no` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ad_id`, `full_name`, `email`, `ph_no`, `password`) VALUES
(1, 'A B', 'ab@gmail.com', '121313', '$2y$10$FWfAQfm2VubZmwSiITXyVeyy4a/oAFIXFYkkWT2WODHnJLIsQpesy');

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE `award` (
  `b_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `best_rent` tinyint(1) DEFAULT 0,
  `popular` tinyint(1) DEFAULT 0,
  `award_winning` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `award`
--

INSERT INTO `award` (`b_id`, `description`, `best_rent`, `popular`, `award_winning`) VALUES
(42, 'Popular for easy method.', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `b_id` int(11) NOT NULL,
  `b_title` varchar(200) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`b_id`, `b_title`, `author`, `description`, `cover`, `file`, `cat_id`) VALUES
(36, 'Montana Sunset', 'L. R. Wards', 'Running from her mother and stepfather, Meagan was attempting to stay invisible but, when she began working as a groom on a cattle ranch, Adam Wightman caught her eye.', '../../uploads/cover/montana-sunset.jpg', '../../uploads/file/montana-sunset.pdf', 12),
(37, 'Total Recall', 'Arnold Schwarzenegger', '\'Total Recall\' is the unbelievably true story of Arnold Schwarzenegger\'s life. Born in the small city of Thal, Austria, in 1947, he moved to LA at the age of 21. Within 10 years, he was a millionaire business man. After 20 years, he was the world\'s biggest movie star. In 2003, he became Governor of California.', '../../uploads/cover/total recall.jpg', '../../uploads/file/total recall.pdf', 4),
(38, 'Getting Past Your Past', 'Francine Shapiro', 'A totally accessible user’s guide from the creator of a scientifically proven form of psychotherapy for healing ailments ranging from PTSD to minor anxiety and depression.', '../../uploads/cover/Getting Past Your Past.jpg', '../../uploads/file/Getting Past Your Past.pdf', 18),
(39, 'A Gentleman in Moscow', 'Amor Towles', '“A Gentleman in Moscow” is a captivating novel by Amor Towles that takes readers on a journey through the life of Count Alexander Ilyich Rostov. This enchanting story, set in post-revolutionary Russia, explores themes of resilience, change, and the human spirit. Since its release, the book has garnered widespread acclaim for its rich narrative and profound insights.', '../../uploads/cover/A Gentleman in Moscow.jpg', '../../uploads/file/A Gentleman in Moscow.pdf', 17),
(42, 'Python For Everybody', 'Charles Severance', 'The goal of this book is to provide an Informatics-oriented introduction to programming. The primary difference between a computer science approach and the Informatics approach taken in this book is a greater focus on using Python to solve data analysis problems common in the world of Informatics.', '../../uploads/cover/pythonForEverybody.jpg', '../../uploads/file/pythonForEverybody.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`) VALUES
(4, 'Biography'),
(18, 'Non Friction'),
(17, 'Novel'),
(1, 'Programming'),
(12, 'Romantic'),
(3, 'Science Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `f_name` varchar(50) DEFAULT NULL,
  `l_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ph_no` varchar(20) DEFAULT NULL,
  `full_address` text DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `f_name`, `l_name`, `email`, `ph_no`, `full_address`, `password`) VALUES
(29, 'a', 'A', 'aa@gmail.com', '54859485', 'xy', '$2y$10$OTh9kGtTt7sHDtVe5qXae.AdRa9370WtlmTKeENmadSDLa0B/gg06'),
(30, 'b', 'b', 'bb@gmail.com', '12134142', 'xyz', '$2y$10$aTpeV2MWai/LkUsa0kYkAux3Z9DAEHvRBOWkBTI3emA9GWlJg3Fgy'),
(31, 'ss', 'ss', 'ssss@gmail.com', '313131', 'awdfawfa', '$2y$10$jOcZ5IJMWu4NqKQ4fqT6EOFLyYol2EKHEIUcyt97DfPb1GS7tCzGS');

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `c_id` int(11) NOT NULL,
  `b_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rent`
--

INSERT INTO `rent` (`c_id`, `b_id`, `start_date`, `return_date`) VALUES
(31, 36, '2024-10-28', '2024-11-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ad_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `award`
--
ALTER TABLE `award`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`c_id`,`b_id`),
  ADD KEY `b_id` (`b_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `award`
--
ALTER TABLE `award`
  ADD CONSTRAINT `award_ibfk_1` FOREIGN KEY (`b_id`) REFERENCES `book` (`b_id`);

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`);

--
-- Constraints for table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `rent_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rent_ibfk_2` FOREIGN KEY (`b_id`) REFERENCES `book` (`b_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
