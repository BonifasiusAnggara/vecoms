-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2018 at 06:22 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vecoms`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_man`
--

CREATE TABLE IF NOT EXISTS `user_man` (
  `id_user` int(5) NOT NULL,
  `kodeUser` varchar(10) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `jk` varchar(50) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `no_hp` varchar(150) NOT NULL,
  `tgl_lahir` varchar(50) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `akses` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_man`
--

INSERT INTO `user_man` (`id_user`, `kodeUser`, `last_name`, `first_name`, `jk`, `alamat`, `no_hp`, `tgl_lahir`, `username`, `password`, `email`, `photo`, `akses`) VALUES
(11, 'US-0908164', 'Brogrammer', 'EngiNerd', 'L', 'medan', '0999', '1997-02-01', 'superadmin', '889a3a791b3875cfae413574b53da4bb8a90d53e', 'frengki.anggara@enseval.com', 'il_340x270.1186456977_cx1g.jpg', 3),
(15, 'US-1617174', 'Enseval', 'Security', 'L', 'Jl. Raya Cibolang', '0856723541', '2017/05/17', 'security', 'd93fa474c3964d2147884f78460d4480971befea', '', 'man-8.png', 4),
(16, 'US-1623171', 'Transportasi', 'Admin', 'L', 'Enseval', '0856123456', '2017/05/23', 'ski.exp', '680fe424d79176a14fb75658396d020f3e483dba', 'muhammad.sanjaya@enseval.com', '', 2),
(17, 'US-5423175', 'Ledger', 'General', 'P', 'Enseval', '08567712061', '1989-01-30', 'ski.gl', 'dc14c654990a86e8cda87a5612c12f7275fef286', 'nuni.luviani@enseval.com', '435915-chelsea-islan.jpg', 2),
(18, 'US-2123179', 'KND', 'Admin', 'P', 'Enseval', '085672345611', '2017/05/23', 'ski.knd', 'be44993b348178fc143015f92f0d99f2a942e371', 'mia.mawarsari@enseval.com', 'img1.jpg', 2),
(19, 'US-3523179', 'CHD', 'Admin', 'P', 'Enseval', '0856767859', '2017/05/23', 'ski.chd', '23c3a2ffaabfaaafcedbc2c9408ba24f6cd47310', 'septia.maulani@enseval.com', 'SS.jpg', 2),
(20, 'US-2323176', 'Pharma', 'Admin', 'P', 'Enseval', '0858678590', '2017/05/23', 'ski.phm', 'c737f2d3be4215934f7785237702d9c95575c3eb', 'neng.ismi@enseval.com', '435915-chelsea-islan.jpg', 2),
(21, 'US-0823177', 'DBM', 'Sekretaris', 'P', 'Enseval', '0858678950', '2017/05/23', 'ski.sec', 'fdbee5b10756150296609a035e96d58b10f5ab88', 'mayasari@enseval.com', 'img1.jpg', 2),
(23, 'US-5323179', 'Koordinator', 'Transportasi', 'L', 'Enseval', '3564563465436', '2017/05/23', 'trp.cor', 'fa1f7c539770d655a052f7b3df6053c77173cec2', 'jajah.zahruddin@enseval.com', '20170930_073503.jpg', 3),
(24, 'US-3427170', 'Sukabumi', 'DBM', 'L', 'Enseval', '0812607893', '2017/05/27', 'dbm_ski', '185594d4978ff6cda3a0cfab9f8055addad276a8', 'didi.wulyanto@enseval.com', 't3.jpg', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_man`
--
ALTER TABLE `user_man`
  ADD PRIMARY KEY (`id_user`), ADD UNIQUE KEY `kodeUser` (`kodeUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_man`
--
ALTER TABLE `user_man`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
