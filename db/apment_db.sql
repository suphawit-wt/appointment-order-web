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

--
-- Table structure for table `doc_persons`
--

CREATE TABLE `doc_persons` (
  `documents_id` int(11) NOT NULL,
  `persons_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `ps_name` varchar(50) NOT NULL COMMENT 'Fullname',
  `departments_id` int(11) NOT NULL COMMENT 'Department ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

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
