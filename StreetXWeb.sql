-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2018 at 09:54 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.27-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `StreetXWeb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin_login`
--

CREATE TABLE `Admin_login` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `sending_mail` varchar(100) NOT NULL,
  `sending_pass` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Admin_login`
--

INSERT INTO `Admin_login` (`id`, `name`, `email`, `username`, `password`, `sending_mail`, `sending_pass`, `status`, `created_on`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', '23d42f5f3f66498b2c8ff4c20b8c5ac826e47146', 'admin@gmail.com', 'asdfasdf', 1, '2018-01-19 15:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `curr_id` int(11) NOT NULL,
  `curr_address` varchar(255) NOT NULL,
  `curr_bal` double(25,10) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currency_list`
--

CREATE TABLE `currency_list` (
  `id` int(11) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `host` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `port` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `logo` varchar(255) NOT NULL,
  `sel_val` tinyint NOT NULL default '1',
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency_list`
--

INSERT INTO `currency_list` (`id`, `short_name`, `name`, `host`, `user`, `pass`, `port`, `status`, `logo`,`sel_val`) VALUES
(1, 'PBCZ', 'PowerCoinZ', 'localhost', 'test', 'test123', '18336', 1, 'ritzcoin-favicon.png',1),
(2, 'PBCZ', 'PowerCoinZ', 'localhost', 'test2', 'test1234', '18337', 1, 'ritzcoin-favicon.png',2);

-- --------------------------------------------------------

--
-- Table structure for table `fee_charges`
--

CREATE TABLE `fee_charges` (
  `id` int(11) NOT NULL,
  `min_amt` int(11) NOT NULL,
  `max_amt` int(11) NOT NULL,
  `charge` double(25,10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fee_charges`
--

INSERT INTO `fee_charges` (`id`, `min_amt`, `max_amt`, `charge`) VALUES
(1, 0, 100, 0.0100000000),
(2, 101, 1000, 0.0500000000),
(3, 1001, 100000, 0.1000000000);

-- --------------------------------------------------------

--
-- Table structure for table `login_detail`
--

CREATE TABLE `login_detail` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_detail`
--

INSERT INTO `login_detail` (`id`, `user_id`, `ip_address`, `created_date`) VALUES
(1, 1, '127.0.0.1', '2018-02-02 16:22:47'),
(2, 1, '127.0.0.1', '2018-02-02 16:30:08'),
(3, 1, '127.0.0.1', '2018-02-02 17:38:42'),
(4, 1, '127.0.0.1', '2018-02-02 17:58:32'),
(5, 1, '127.0.0.1', '2018-02-02 18:02:37'),
(6, 1, '127.0.0.1', '2018-02-02 18:02:58'),
(7, 1, '127.0.0.1', '2018-02-02 20:13:22'),
(8, 4, '127.0.0.1', '2018-02-03 11:00:03'),
(9, 4, '127.0.0.1', '2018-02-03 11:01:03'),
(10, 4, '127.0.0.1', '2018-02-06 15:39:21'),
(11, 4, '::1', '2018-02-06 16:44:20'),
(12, 4, '127.0.0.1', '2018-02-06 17:00:25'),
(13, 4, '::1', '2018-02-06 17:59:14'),
(14, 4, '::1', '2018-02-06 18:01:44'),
(15, 4, '::1', '2018-02-07 16:22:12'),
(16, 4, '127.0.0.1', '2018-02-07 17:56:51'),
(17, 4, '::1', '2018-02-08 00:53:32'),
(18, 4, '::1', '2018-02-08 10:53:01'),
(19, 4, '::1', '2018-02-08 11:25:25'),
(20, 4, '::1', '2018-02-08 14:59:39'),
(0, 4, '::1', '2018-03-16 18:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Curr_id` int(11) NOT NULL,
  `trans_address` varchar(100) NOT NULL,
  `amount` double(25,10) NOT NULL,
  `fee` double(25,10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `ip_address` varchar(10) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `tfa_status` tinyint(4) NOT NULL DEFAULT '0',
  `tfa_key` varchar(100) NOT NULL,
  `email_verify_status` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `kyc_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `otp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin_login`
--
ALTER TABLE `Admin_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_list`
--
ALTER TABLE `currency_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `currency_list`
--
ALTER TABLE `currency_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
