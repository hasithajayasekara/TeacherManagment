-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2022 at 03:19 AM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teachersbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(25) NOT NULL,
  `attempt` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `password`, `user_type`, `attempt`) VALUES
('OS000001', '940072234V', 'zone', 0),
('OS000002', '947068827V', 'zone', 0),
('SS000001', '707061127V', 'teach', 0),
('SS000002', '728001470X', 'teach', 0),
('SS000003', '875093126V', 'teach', 1),
('SS000004', '795110968V', 'teach', 1),
('SS000005', '937382561V', 'teach', 1);

-- --------------------------------------------------------

--
-- Table structure for table `office_staff`
--

CREATE TABLE `office_staff` (
  `SID` varchar(10) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Date_of_birth` date NOT NULL,
  `Age` int(11) NOT NULL,
  `NIC_number` varchar(100) NOT NULL,
  `Religion` varchar(100) NOT NULL,
  `Nationality` varchar(100) NOT NULL,
  `Civil_status` varchar(100) NOT NULL,
  `Address` varchar(300) NOT NULL,
  `Telephone_number` int(11) NOT NULL,
  `First_appoinment_date` date NOT NULL,
  `Post` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `office_staff`
--

INSERT INTO `office_staff` (`SID`, `Name`, `Gender`, `Date_of_birth`, `Age`, `NIC_number`, `Religion`, `Nationality`, `Civil_status`, `Address`, `Telephone_number`, `First_appoinment_date`, `Post`) VALUES
('OS000002', 'M.Rajendran', 'Male', '1962-08-09', 57, '622201127V', 'Hinduism', 'srilankan tamil', 'Married', '7,peradeniya road,kandy', 778814177, '1988-01-02', 'Assistant Director');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `staffid` varchar(10) NOT NULL,
  `netsalary` double(10,2) NOT NULL,
  `year` year(4) NOT NULL,
  `month` varchar(25) NOT NULL,
  `epf` double(10,2) NOT NULL,
  `etf` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`staffid`, `netsalary`, `year`, `month`, `epf`, `etf`) VALUES
('OS000001', 35000.00, 2019, 'january', 1000.00, 3000.00),
('OS000002', 45000.00, 2019, 'January', 1000.00, 2000.00),
('SS000001', 45000.00, 2018, 'December', 2000.00, 3000.00),
('SS000002', 35000.00, 2018, 'December', 1000.00, 3000.00),
('SS000002', 35000.00, 2019, 'january', 1500.00, 3500.00),
('SS000003', 35000.00, 2018, 'December', 1000.00, 2000.00),
('SS000003', 35000.00, 2019, 'january', 1000.00, 2500.00),
('SS000004', 35000.00, 2019, 'January', 1000.00, 2000.00),
('SS000005', 35000.00, 2019, 'January', 1500.00, 2000.00);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `schoolid` varchar(10) NOT NULL,
  `censusid` varchar(12) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `tpnum` int(10) NOT NULL,
  `zoneid` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`schoolid`, `censusid`, `name`, `address`, `tpnum`, `zoneid`) VALUES
('SCH00001', '0921457', 'K/Girls\'High School', '184,Peradeniya road,Kandy', 812221988, 'Z00001'),
('SCH00002', '0921458', 'K/Goodsheperd Convent', '437,Peradeniya road,Kandy', 812226935, 'Z00001'),
('SCH00003', '0921459', 'K/Kingswood College', '334/6,Peradeniya road,Kandy', 818829988, 'Z00001'),
('SCH00004', '0921460', 'K/Dhadly senanayaka vidyalaya,Kandy', '183,Dholuwa road,Kandy', 812225335, 'Z00001'),
('SCH00005', '0921461', 'K/Viharamahadevi Balika', '345,Peradeniya Road,Kandy', 811111978, 'Z00001'),
('SCH00006', '0921462', 'K/Trinity College', '23,Senanayaka Street,Kandy', 816634988, 'Z00001'),
('SCH00007', '0921463', 'K/Silvesters College', '45,Mahiyava road,Kandy', 812254978, 'Z00001'),
('SCH00008', '0921464', 'K/Pushpadana vidyalaya', '34,Gampola road,Kandy', 814566766, 'Z00001'),
('SCH00009', '0921465', 'K/Kalaimahal vidyalayam', '245,Jaffna road,kandy', 812222306, 'Z00001');

-- --------------------------------------------------------

--
-- Table structure for table `school_staff`
--

CREATE TABLE `school_staff` (
  `SID` varchar(10) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Date_of_birth` date NOT NULL,
  `Age` int(11) NOT NULL,
  `NIC_number` varchar(100) NOT NULL,
  `Religion` varchar(100) NOT NULL,
  `Nationality` varchar(100) NOT NULL,
  `Civil_status` varchar(100) NOT NULL,
  `Address` varchar(300) NOT NULL,
  `Telephone_number` int(11) NOT NULL,
  `First_appoinment_date` date NOT NULL,
  `First_appoinment_school` varchar(300) NOT NULL,
  `Subject_teach` varchar(200) NOT NULL,
  `Post` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_staff`
--

INSERT INTO `school_staff` (`SID`, `Name`, `Gender`, `Date_of_birth`, `Age`, `NIC_number`, `Religion`, `Nationality`, `Civil_status`, `Address`, `Telephone_number`, `First_appoinment_date`, `First_appoinment_school`, `Subject_teach`, `Post`) VALUES
('SS000001', 'Malika Balasubramaniam', 'Female', '1970-02-14', 49, '707061127V', 'Hinduism', 'SriLankan Tamil', 'Married', '34,katugastoda,kandy', 771234567, '1997-05-06', 'SCH00001', 'Tamil', 'Teacher'),
('SS000002', 'L.Kohilarooban', 'Male', '1972-03-09', 47, '728001470X', 'Roman Catholic', 'Indian tamil', 'Single', '23,colombo road,Trincomalee', 777926717, '2014-04-10', 'K/Girls\'High School', 'Maths', 'Teacher'),
('SS000003', 'S.Maneesha', 'Female', '1987-05-02', 32, '875093126V', 'Buddhism', 'SriLankan', 'Married', '234A,Sunanda Road,Kandy', 777928917, '2013-06-07', 'SCH00005', 'Science', 'Principal'),
('SS000004', 'L.Saheeka', 'Female', '1979-09-07', 40, '795110968V', 'Muslim', 'SriLankan', 'Married', '88,Abdul Street,Kandy', 717926017, '2002-09-08', 'SCH00009', 'English', 'Teacher'),
('SS000005', 'S.Lakshitha', 'Male', '1993-11-23', 26, '937382561V', 'Roman Catholic', 'SriLankan', 'Married', '01/287,Church Road,Kandy', 711459920, '2015-05-17', 'SCH00006', 'History', 'Teacher'),
('SS000006', 'K.Lokesh', 'Male', '1987-08-17', 32, '874380411V', 'Buddhism', 'SriLankan', 'Single', '23,Temple Road,Kandy', 774949243, '2012-04-06', 'SCH00003', 'Music', 'Teacher'),
('SS000007', 'M.Rammani', 'Female', '1988-09-09', 31, '886478544V', 'Hindu', 'SriLankan Tamil', 'Single', '33,Kovil Road,Kandy', 779898563, '2015-01-01', 'SCH00009', 'English', 'Teacher'),
('SS000008', 'D.Shan', 'Male', '1992-03-09', 27, '923456899V', 'Muslim', 'SriLankan', 'Single', '189,Haleem Road,Kandy', 776767554, '2016-09-07', 'SCH00004', 'English', 'Teacher'),
('SS000009', 'A.Aththanayaka', 'Male', '1977-02-04', 42, '772345633V', 'Buddhism', 'SriLankan', 'Married', '02,Flower Road,Kandy', 77888443, '1992-04-04', 'SCH00007', 'Maths', 'Principal'),
('SS000010', 'H.Kohilawadani', 'Female', '1989-07-09', 30, '896380411V', 'Hindus', 'SriLankan Tamil', 'Single', '12,Temple Road,Kandy', 773333121, '2016-02-02', 'SCH00002', 'Dancing', 'Teacher'),
('SS000011', 'F.Aseefa', 'Female', '1988-07-22', 31, '887345655V', 'Muslims', 'SriLankan', 'Single', '11A,Kovil Road,Kandy', 789090543, '2015-03-01', 'SCH00001', 'Science', 'Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `seminar`
--

CREATE TABLE `seminar` (
  `seminarid` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seminar`
--

INSERT INTO `seminar` (`seminarid`, `date`, `details`) VALUES
('SEM00001', '2019-01-07', 'Science Seminar'),
('Z00002', '2019-01-16', 'Maths seminar');

-- --------------------------------------------------------

--
-- Table structure for table `seminarparticipant`
--

CREATE TABLE `seminarparticipant` (
  `seminarid` varchar(10) NOT NULL,
  `staffid` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seminarparticipant`
--

INSERT INTO `seminarparticipant` (`seminarid`, `staffid`) VALUES
('SEM00001', 'SS000001');

-- --------------------------------------------------------

--
-- Table structure for table `staffwork`
--

CREATE TABLE `staffwork` (
  `staffid` varchar(10) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `schoolid` varchar(10) NOT NULL,
  `post` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staffwork`
--

INSERT INTO `staffwork` (`staffid`, `startdate`, `enddate`, `schoolid`, `post`) VALUES
('SS000001', '2017-05-06', '0000-00-00', 'SCH00001', 'Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `staffid` varchar(10) NOT NULL,
  `transferdate` date NOT NULL,
  `schoolid` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`staffid`, `transferdate`, `schoolid`) VALUES
('SS000001', '2019-01-24', 'SCH00001');

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `zoneid` varchar(10) NOT NULL,
  `zonename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`zoneid`, `zonename`) VALUES
('', ''),
('Z00001', 'Kandy'),
('Z00002', 'Gampola'),
('Z00003', 'Wathegama'),
('Z00004', 'Matala');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`(10));

--
-- Indexes for table `office_staff`
--
ALTER TABLE `office_staff`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`staffid`,`year`,`month`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`schoolid`);

--
-- Indexes for table `school_staff`
--
ALTER TABLE `school_staff`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `seminar`
--
ALTER TABLE `seminar`
  ADD PRIMARY KEY (`seminarid`);

--
-- Indexes for table `seminarparticipant`
--
ALTER TABLE `seminarparticipant`
  ADD PRIMARY KEY (`seminarid`,`staffid`);

--
-- Indexes for table `staffwork`
--
ALTER TABLE `staffwork`
  ADD PRIMARY KEY (`staffid`,`startdate`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`staffid`,`transferdate`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`zoneid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
