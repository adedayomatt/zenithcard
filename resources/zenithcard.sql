-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2018 at 06:53 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zenithcard`
--

-- --------------------------------------------------------

--
-- Table structure for table `kyc_individual`
--

CREATE TABLE `kyc_individual` (
  `user_id` int(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` char(50) NOT NULL,
  `city` char(50) NOT NULL,
  `country` char(50) NOT NULL,
  `nationality` char(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `wallet_address` char(100) NOT NULL,
  `contribute_more_than_15ETH` tinytext NOT NULL,
  `id_type` char(50) NOT NULL,
  `id_number` char(50) NOT NULL,
  `id_issue_date` date NOT NULL,
  `id_expire_date` date NOT NULL,
  `id_photo_front` char(50) NOT NULL,
  `id_photo_back` char(50) NOT NULL,
  `ultility_bill_photo` char(50) NOT NULL,
  `selfie` char(50) NOT NULL,
  `transaction_contact_permission` char(5) NOT NULL,
  `occasional_contact_permission` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_legal`
--

CREATE TABLE `kyc_legal` (
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `business_address` varchar(255) NOT NULL,
  `registration_number` char(100) NOT NULL,
  `representative` varchar(255) NOT NULL,
  `certificate` varchar(255) NOT NULL,
  `user_id` int(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` char(50) NOT NULL,
  `city` char(50) NOT NULL,
  `country` char(50) NOT NULL,
  `nationality` char(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `wallet_address` char(100) NOT NULL,
  `contribute_more_than_15ETH` tinytext NOT NULL,
  `id_type` char(50) NOT NULL,
  `id_number` char(50) NOT NULL,
  `id_issue_date` date NOT NULL,
  `id_expire_date` date NOT NULL,
  `id_photo_front` char(50) NOT NULL,
  `id_photo_back` char(50) NOT NULL,
  `ultility_bill_photo` char(50) NOT NULL,
  `selfie` char(50) NOT NULL,
  `transaction_contact_permission` char(5) NOT NULL,
  `occasional_contact_permission` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kyc_legal`
--

INSERT INTO `kyc_legal` (`company_name`, `company_address`, `business_address`, `registration_number`, `representative`, `certificate`, `user_id`, `first_name`, `last_name`, `email`, `mobile_phone`, `address`, `postal_code`, `city`, `country`, `nationality`, `date_of_birth`, `wallet_address`, `contribute_more_than_15ETH`, `id_type`, `id_number`, `id_issue_date`, `id_expire_date`, `id_photo_front`, `id_photo_back`, `ultility_bill_photo`, `selfie`, `transaction_contact_permission`, `occasional_contact_permission`) VALUES
('My Company Ltd', 'Ijokodo, Ibadan', '', '', '', '', 1523360701, 'Adedayo', 'Olayiwola', 'adedayomatt@gmail.com', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', 'Adedayo-Olayiwola-1523360701-selfie.jpeg', '', 'Yes'),
('hmhjhj', '', 'tyrjvvbv', '', '', '', 1523645750, 'Barnabas', 'Ajayi', 'barnabasajayi@gmail.com', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `referal_code` varchar(50) NOT NULL,
  `refree` char(50) NOT NULL DEFAULT '',
  `date_registered` datetime NOT NULL,
  `timestamp` int(50) NOT NULL,
  `zent_token` int(100) NOT NULL DEFAULT '0',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `verification_code` char(50) NOT NULL DEFAULT '',
  `verified` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `password_hash`, `token`, `referal_code`, `refree`, `date_registered`, `timestamp`, `zent_token`, `avatar`, `verification_code`, `verified`) VALUES
(1523359741, 'Bob', 'Stone', 'bobstone@g.com', 'ade', '6fb0394b969258c4f33b92bbe8c601462bb5455b', 'b70166d2359e55ff3484f5d7020c70d86d890796', 'zen5acc975c7477d', '0', '2018-04-10 11:52:12', 1523357532, 0, 'Bob-1523359741.jpeg', '', 0),
(1523360701, 'Adedayo', 'Olayiwola', 'adedayomatt@gmail.com', 'rergtg', '64ee9e9346a2edadbfead8d24f5aaaa22f0edca4', '49c9d03f065454645038113fb65a6ecbcccb71c5', 'zen5acc90681c32b', '0', '2018-04-10 11:22:32', 1523355752, 0, 'Adedayo-1523360701.jpeg', '', 0),
(1523436486, 'Harry', 'Porter', 'harry@gmail.com', 'porter', 'd5f42b181174c20c6ca94150610955403428e2d9', 'ff6a1e249b9928baba669580d86e868289ceec8c', 'zen5acdbc9a08666', '0', '2018-04-11 08:43:22', 1523432602, 0, 'Harry-1523436486.jpeg', '', 0),
(1523639383, 'Sean', 'Cahill', 'cahillsean@yahoo.com', 'sean', 'd7e19930cc1f42c2d0781f4d9e6f1fe5891bf9cf', '8bc8cbf6f426404df123f9b4a81aabd4885f9702', 'zen5ad0df60a1e86', '', '2018-04-13 17:48:32', 1523638112, 0, '', '', 0),
(1523641656, 'Adedayo', 'Matthews', 'adedayomatthews@gmail.com', 'mato', '3d5c73dbafe57ce4c91415274cd60e3f31b3ebc4', 'ad0e71b5fd99c2a847e5780279a4521df0497e34', 'zen5ad0e5a251ce6', '', '2018-04-13 18:15:14', 1523639714, 0, '', '', 0),
(1523644147, 'Adedayo', 'Matthews', 'adedayomatthw@gmail.com', 'aaa', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2db11141d8c95888136375f24bbf2c4632ec9972', 'zen5ad0e869cb7d0', 'zen5ad0e4522db7c', '2018-04-13 18:27:05', 1523640425, 0, '', '', 0),
(1523645750, 'Barnabas', 'Ajayi', 'barnabasajayi@gmail.com', 'aj', '2048b22ac0881f917af3e938105055ab85498548', '2e77340e9f68ce8254f329815ff151f49eb09126', 'zen5ad0e4522db7c', '', '2018-04-13 18:09:38', 1523639378, 200, 'Barnabas-1523645750.jpeg', '', 0),
(1523645971, 'Adedayo', 'Matthews', 'adedayomatthws@gmail.com', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '978feac3fe4e184da465389ef66796f144817311', 'zen5ad0e70714116', '', '2018-04-13 18:21:11', 1523640071, 0, '', '', 0),
(1523647335, 'Adedayo', 'Matthews', 'adedayomatth@gmail.com', 'zzz', '40fa37ec00c761c7dbb6ebdee6d4a260b922f5f4', '72dd0778373c786ca847213388f1b5bd61989efd', 'zen5ad0ed4518dd7', 'zen5ad0e4522db7c', '2018-04-13 18:47:49', 1523641669, 0, '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kyc_individual`
--
ALTER TABLE `kyc_individual`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `kyc_legal`
--
ALTER TABLE `kyc_legal`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `refree` (`refree`),
  ADD KEY `referal_code` (`referal_code`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kyc_individual`
--
ALTER TABLE `kyc_individual`
  ADD CONSTRAINT `individual_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kyc_legal`
--
ALTER TABLE `kyc_legal`
  ADD CONSTRAINT `legal_entity_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
