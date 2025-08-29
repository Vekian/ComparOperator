-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Sep 08, 2023 at 12:27 PM
-- Server version: 10.6.12-MariaDB-1:10.6.12+maria~ubu2004-log
-- PHP Version: 8.1.14
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voyage`
--
CREATE DATABASE IF NOT EXISTS `voyage` DEFAULT CHARACTER
SET
  utf8mb4 COLLATE utf8mb4_general_ci;

USE `voyage`;

-- --------------------------------------------------------
--
-- Table structure for table `author`
--
CREATE TABLE
  `author` (
    `id` int (11) NOT NULL,
    `name` varchar(255) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

--
-- Dumping data for table `author`
--
INSERT INTO
  `author` (`id`, `name`)
VALUES
  (1, 'Michel'),
  (2, 'René'),
  (3, 'Paul');

-- --------------------------------------------------------
--
-- Table structure for table `certificate`
--
CREATE TABLE
  `certificate` (
    `tour_operator_id` int (11) NOT NULL,
    `expires_at` datetime NOT NULL,
    `signatory` varchar(255) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

--
-- Dumping data for table `certificate`
--
INSERT INTO
  `certificate` (`tour_operator_id`, `expires_at`, `signatory`)
VALUES
  (1, '2022-02-09 14:50:07', 'Jean Bertrand'),
  (2, '2023-01-02 14:50:07', 'Bernard Michel');

-- --------------------------------------------------------
--
-- Table structure for table `destination`
--
CREATE TABLE
  `destination` (
    `id` int (11) NOT NULL,
    `location` varchar(255) NOT NULL,
    `price` int (11) NOT NULL,
    `tour_operator_id` int (11) NOT NULL,
    `picture` varchar(255) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

--
-- Dumping data for table `destination`
--
INSERT INTO
  `destination` (
    `id`,
    `location`,
    `price`,
    `tour_operator_id`,
    `picture`
  )
VALUES
  (1, 'Rome', 1650, 2, 'public/images/rome.webp'),
  (
    2,
    'Londres',
    1100,
    2,
    'public/images/londres.jpg'
  ),
  (3, 'Monaco', 1390, 1, 'public/images/monaco.jpg'),
  (4, 'Tunis', 2390, 3, 'public/images/tunis.jpg');

-- --------------------------------------------------------
--
-- Table structure for table `review`
--
CREATE TABLE
  `review` (
    `id` int (11) NOT NULL,
    `message` varchar(255) NOT NULL,
    `tour_operator_id` int (11) NOT NULL,
    `author_id` int (11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

--
-- Dumping data for table `review`
--
INSERT INTO
  `review` (`id`, `message`, `tour_operator_id`, `author_id`)
VALUES
  (1, 'Super voyage, prestation au top !!', 2, 1),
  (
    2,
    'Tout est inclus dans le prix, c\'est cool, je recommande',
    3,
    3
  ),
  (3, 'Un peu cher, mais ça vaut le coup', 2, 3),
  (4, 'arnaque!!!! a fuire!!!', 2, 2);

-- --------------------------------------------------------
--
-- Table structure for table `score`
--
CREATE TABLE
  `score` (
    `id` int (11) NOT NULL,
    `value` int (11) NOT NULL,
    `tour_operator_id` int (11) NOT NULL,
    `author_id` int (11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

--
-- Dumping data for table `score`
--
INSERT INTO
  `score` (`id`, `value`, `tour_operator_id`, `author_id`)
VALUES
  (1, 5, 2, 1),
  (2, 4, 3, 3),
  (3, 1, 2, 2);

-- --------------------------------------------------------
--
-- Table structure for table `tour_operator`
--
CREATE TABLE
  `tour_operator` (
    `id` int (11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `link` varchar(255) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

--
-- Dumping data for table `tour_operator`
--
INSERT INTO
  `tour_operator` (`id`, `name`, `link`)
VALUES
  (
    1,
    'Salaun Holidays',
    'https://www.salaun-holidays.com/'
  ),
  (2, 'Fram', 'https://www.fram.fr/'),
  (3, 'Heliades', 'https://www.heliades.fr/');

--
-- Indexes for dumped tables
--
--
-- Indexes for table `author`
--
ALTER TABLE `author` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate` ADD PRIMARY KEY (`tour_operator_id`);

--
-- Indexes for table `destination`
--
ALTER TABLE `destination` ADD PRIMARY KEY (`id`),
ADD KEY `destination_tour_operator` (`tour_operator_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review` ADD PRIMARY KEY (`id`),
ADD KEY `review_tour_operator` (`tour_operator_id`),
ADD KEY `review_author` (`author_id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score` ADD PRIMARY KEY (`id`),
ADD KEY `score_tour_operator` (`tour_operator_id`),
ADD KEY `score_author` (`author_id`);

--
-- Indexes for table `tour_operator`
--
ALTER TABLE `tour_operator` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `tour_operator`
--
ALTER TABLE `tour_operator` MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `certificate`
--
ALTER TABLE `certificate` ADD CONSTRAINT `certificate_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);

--
-- Constraints for table `destination`
--
ALTER TABLE `destination` ADD CONSTRAINT `destination_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review` ADD CONSTRAINT `review_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
ADD CONSTRAINT `review_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);

--
-- Constraints for table `score`
--
ALTER TABLE `score` ADD CONSTRAINT `score_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
ADD CONSTRAINT `score_tour_operator` FOREIGN KEY (`tour_operator_id`) REFERENCES `tour_operator` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;