SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `apment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `dep_name` varchar(50) NOT NULL COMMENT 'Department Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------
INSERT INTO `departments` (`id`, `dep_name`) VALUES
(1, 'Education'),
(2, 'Research and Development'),
(3, 'Information Technology'),
(4, 'Finance'),
(5, 'Human Resources');

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `doc_num` varchar(20) NOT NULL COMMENT 'Doc No.',
  `doc_title` varchar(255) NOT NULL COMMENT 'Title',
  `doc_frdate` date NOT NULL COMMENT 'Start Date',
  `doc_todate` date DEFAULT NULL COMMENT 'End Date',
  `doc_filename` varchar(100) DEFAULT NULL COMMENT 'Filename',
  `doc_exp_sts` char(1) NOT NULL COMMENT 'Y = Expired / N = Valid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------
INSERT INTO `documents` (`id`, `doc_num`, `doc_title`, `doc_frdate`, `doc_todate`, `doc_filename`, `doc_exp_sts`) VALUES
(1, '1001', 'Doc 1', '2019-01-02', '2019-06-30', '1001.pdf', 'Y'),
(2, '1002', 'Doc 2', '2019-01-07', '2019-05-07', '1002.pdf', 'Y'),
(3, '1003', 'Doc 3', '2019-01-16', '2019-04-16', '1003.pdf', 'Y'),
(4, '2101', 'Doc 4', '2019-02-12', '2019-07-12', '2101.pdf', 'Y'),
(5, '2102', 'Doc 5', '2019-02-26', '2019-05-30', '2102.pdf', 'Y'),
(6, '4001', 'Doc 6', '2019-04-05', '2019-09-15', '4001.pdf', 'Y'),
(7, '5001', 'Doc 7', '2019-05-06', '2019-08-06', '5001.pdf', 'Y'),
(8, '5002', 'Doc 8', '2019-05-12', '2019-10-20', '5002.pdf', 'Y'),
(9, '5003', 'Doc 9', '2019-05-22', '2019-11-01', '5003.pdf', 'Y'),
(10, '6100', 'Doc 10', '2019-06-21', '2019-09-21', '6100.pdf', 'Y'),
(11, '7101', 'Doc 11', '2019-07-03', '2019-07-31', '7101.pdf', 'Y'),
(12, '7102', 'Doc 12', '2019-07-04', '2019-09-14', '7102.pdf', 'Y'),
(13, '7103', 'Doc 13', '2019-07-17', '2019-08-17', '7103.pdf', 'Y'),
(14, '7104', 'Doc 14', '2019-07-28', '2019-10-31', '7104.pdf', 'Y'),
(15, '8001', 'Doc 15', '2019-08-03', '2019-12-03', '8001.pdf', 'Y'),
(16, '8002', 'Doc 16', '2019-08-08', '2019-08-29', '8002.pdf', 'Y'),
(17, '8003', 'Doc 17', '2019-08-10', '2019-12-15', '8003.pdf', 'Y'),
(18, '8004', 'Doc 18', '2019-08-26', '2019-11-30', '8004.pdf', 'Y'),
(19, '9100', 'Doc 19', '2019-09-01', '2019-11-21', '9100.pdf', 'Y'),
(26, '9200', 'Doc 20', '2020-03-01', '2020-03-31', '9200.pdf', 'Y'),
(27, '9201', 'Doc 21', '2022-08-09', '2022-08-24', '9201.pdf', 'Y');

--
-- Table structure for table `doc_persons`
--

CREATE TABLE `doc_persons` (
  `documents_id` int(11) NOT NULL,
  `persons_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------
INSERT INTO `doc_persons` (`documents_id`, `persons_id`) VALUES
(3, 1),
(7, 1),
(8, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(17, 1),
(26, 1),
(27, 1),
(2, 2),
(3, 2),
(13, 2),
(14, 2),
(16, 2),
(18, 2),
(1, 3),
(3, 3),
(4, 3),
(18, 3),
(26, 3),
(1, 4),
(4, 4),
(8, 4),
(12, 4),
(18, 4),
(1, 5),
(3, 5),
(10, 5),
(13, 5),
(15, 5),
(17, 5),
(18, 5),
(2, 6),
(4, 6),
(5, 6),
(7, 6),
(11, 6),
(14, 6),
(15, 6),
(1, 7),
(2, 7),
(6, 7),
(9, 7),
(11, 7),
(12, 7),
(13, 7),
(16, 7),
(17, 7),
(18, 7),
(19, 7),
(4, 8),
(5, 8),
(7, 8),
(8, 8),
(10, 8),
(11, 8),
(13, 8),
(16, 8),
(17, 8),
(19, 8),
(26, 8),
(4, 9),
(5, 9),
(7, 9),
(9, 9),
(12, 9),
(15, 9),
(16, 9),
(26, 9),
(6, 10),
(8, 10),
(9, 10),
(10, 10),
(14, 10),
(16, 10),
(17, 10),
(3, 11),
(4, 11),
(6, 11),
(7, 11),
(13, 11),
(14, 11),
(16, 11),
(19, 11),
(4, 12),
(5, 12),
(7, 12),
(8, 12),
(10, 12),
(11, 12),
(14, 12),
(15, 12),
(17, 12),
(3, 13),
(9, 13),
(12, 13),
(13, 13),
(16, 13),
(26, 13),
(2, 14),
(8, 14),
(12, 14),
(13, 14),
(16, 14),
(17, 14),
(2, 15),
(5, 15),
(6, 15),
(8, 15),
(1, 16),
(12, 16),
(13, 16),
(3, 17),
(6, 17),
(8, 17),
(14, 17),
(18, 17),
(2, 18),
(3, 18),
(4, 18),
(5, 18),
(6, 18),
(7, 18),
(9, 18),
(10, 18),
(16, 18),
(17, 18),
(5, 19),
(9, 19),
(11, 19),
(13, 19),
(15, 19),
(16, 19),
(19, 19),
(6, 20),
(15, 20),
(16, 20),
(18, 20),
(19, 20);

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `ps_name` varchar(50) NOT NULL COMMENT 'Fullname',
  `departments_id` int(11) NOT NULL COMMENT 'Department ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------
INSERT INTO `persons` (`id`, `ps_name`, `departments_id`) VALUES
(1, 'John Smith', 1),
(2, 'Jane Smith', 3),
(3, 'Peter Parker', 5),
(4, 'Mary Jane', 2),
(5, 'Gwen Stacy', 4),
(6, 'Tony Stark', 1),
(7, 'Nick Fury', 3),
(8, 'James Bond', 5),
(9, 'Ethan Hunt', 2),
(10, 'Steve Roger', 4),
(11, 'Carol Danvers', 1),
(12, 'Ryan Raynolds', 3),
(13, 'Jonathan Wick', 5),
(14, 'Stephen Grant', 2),
(15, 'Samuel Jackson', 3),
(16, 'Percy Jackson', 4),
(17, 'Harry Potter', 2),
(18, 'Albus Dumbledore', 3),
(19, 'Rick Smith', 4),
(20, 'Morty Smith', 2);

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `username` varchar(20) NOT NULL COMMENT 'Username',
  `passwd` varchar(50) NOT NULL COMMENT 'Password',
  `user_group` char(1) NOT NULL COMMENT 'S = Staff / P = Person',
  `persons_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
INSERT INTO `users` (`id`, `username`, `passwd`, `user_group`, `persons_id`) VALUES
(1, 'C0007', '82cfa559d9370ca284c5ddc8ebada5f3', 'P', 1),
(2, 'C0009', 'b6d08f551887db1e314ffcbb2289e83c', 'P', 9),
(3, 'C0010', '2219465d107844f8bb85ea4304fa029e', 'P', 12),
(4, 'C0012', '7cf24fdd95c61cc39edae5d59d1ca5b6', 'S', 3),
(5, 'C0013', 'e2784ac21fcc920d2597847ee2d20f2a', 'P', 5),
(6, 'C0014', '7389833311890ac6b2258d35035c935b', 'P', 15),
(7, 'C0015', 'b1b2a6c3e9f16df82e123304f6efae86', 'S', 8),
(8, 'C0016', '1e2df4ae3ddd5e0ea4e2e173868d908c', 'P', 11),
(9, 'C0017', '07e4e72c06f52261cedf2d98b9aaf630', 'P', 14),
(10, 'C0018', '23bf7640344efafa6d3945fe60905cfe', 'P', 17),
(11, 'C0019', '174e120e0dfb1216fed6f0e3ce18c3eb', 'P', 18),
(12, 'C0020', '967fca102df3fb835f0e54aa6df3921a', 'P', 20),
(13, 'C0143', '0aa440fc9c8ba72b0db7c82c15d5d3ba', 'P', 2),
(14, 'C0242', '2261c586a6b42fdd6601aa86a759e2fa', 'P', 7),
(15, 'C0248', 'd190e17b5e44e3f7ed9780669a5d3fec', 'P', 10),
(16, 'C0266', '6f3a4eeee7e1d5ecab254a9e224c0047', 'S', 13),
(17, 'C0284', '3d8ad6a6651e6356ec0eea6662f4e398', 'P', 16),
(18, 'C0326', 'f8e6c03efbf6c296e8b1966e1abfc1d1', 'P', 6),
(19, 'C0333', 'aa01378fb768f260415bff9addd94bae', 'P', 19),
(20, 'C0755', 'd35d1dd9eab778c56598ea98c1975f15', 'P', 4);
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doc_num_UNIQUE` (`doc_num`);

--
-- Indexes for table `doc_persons`
--
ALTER TABLE `doc_persons`
  ADD PRIMARY KEY (`documents_id`,`persons_id`),
  ADD KEY `fk_documents_has_persons_persons1_idx` (`persons_id`),
  ADD KEY `fk_documents_has_persons_documents_idx` (`documents_id`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_persons_departments1_idx` (`departments_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD KEY `fk_users_persons1_idx` (`persons_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doc_persons`
--
ALTER TABLE `doc_persons`
  ADD CONSTRAINT `fk_documents_has_persons_documents` FOREIGN KEY (`documents_id`) REFERENCES `documents` (`id`),
  ADD CONSTRAINT `fk_documents_has_persons_persons1` FOREIGN KEY (`persons_id`) REFERENCES `persons` (`id`);

--
-- Constraints for table `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `fk_persons_departments1` FOREIGN KEY (`departments_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_persons1` FOREIGN KEY (`persons_id`) REFERENCES `persons` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
