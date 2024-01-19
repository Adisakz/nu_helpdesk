-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 19, 2024 at 02:01 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nu_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id_person` varchar(50) NOT NULL,
  `name_title` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `position` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `department` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profile_img` varchar(50) NOT NULL,
  `urole` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'บุคลากร' COMMENT '-admin\r\n-ช่าง\r\n-หัวหน้าหน่วย\r\n-ผู้อำนวยการ\r\n-คณบดี\r\n-พัสดุ',
  `about` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id_person`, `name_title`, `first_name`, `last_name`, `position`, `department`, `profile_img`, `urole`, `about`) VALUES
('1000000000001', 'นาย', 'admin', 'admin', 'admin', 'Computer', 'no-image.png', 'admin', ''),
('2222222222222', 'นาย', 'ทดสอบ', 'ช่าง', 'ช่างซ่อมบำรุง', '1', 'user_2222222222222.jpg', 'ช่าง', '-ประปา\r\n-ไฟฟ้า'),
('3333333333333', 'นาย', 'พัสดุ', 'พัสดุ', 'พนักงานพัสดุ', '2', 'no-image.png', 'พัสดุ', '-'),
('4444444444444', 'นาย', 'หัวหน้า ', 'พัสดุ', 'หัวหน้าพัสดุ', '2', 'no-image.png', 'หัวหน้าหน่วย', '-'),
('5555555555555', 'นาย', 'หัวหน้า ', 'กองคลัง', 'หัวหน้าแผนกกองคลัง', '11', 'no-image.png', 'หัวหน้าหน่วย', '-'),
('6666666666666', 'นาย', 'อำนวย', 'การ', 'ผู้อำนวยการกองบริหาร', '18', 'no-image.png', 'ผู้อำนวยการ', '-'),
('7777777777777', 'ทดสอบ', 'คณ', 'บดี', 'คณบดี', '18', 'no-image.png', 'คณบดี', '-');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id_department` int NOT NULL,
  `name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id_department`, `name`) VALUES
(1, 'หน่วยอาคารสถานที่ และยานพาหนะ'),
(2, 'หน่วยพัสดุ'),
(3, 'หน่วยศูนย์ความเป็นเลิศในการพัฒนาเด็กปฐมวัย'),
(4, 'หน่วยจัดการศึกษาปริญาตรี'),
(5, 'หน่วยเทคโนโลยีสารสนเทศ'),
(6, 'หน่วยปฏิบัติการพยาบาล'),
(7, 'หน่วยพัฒนานักศึกษา และศิษย์เก่าสัมพันธ์'),
(8, 'หน่วยห้องสมุด'),
(9, 'หน่วยจัดการงานทั่วไป และทรัพยากรบุคคล'),
(10, 'หน่วยหอพักนักศึกษา'),
(11, 'หน่วยยุทธศาสตร์ และพัฒนาคุณภาพ'),
(12, 'หน่วยการเงินและบัญชี'),
(13, 'หน่วยวิจัยและบริการวิชาการ'),
(14, 'หน่วยจัดการบัณฑิตศึกษา และวิเทศสัมพันธ์'),
(15, 'หน่วยจัดการศึกษาผู้ช่วยพยาบาล'),
(18, 'ผู้บริหาร');

-- --------------------------------------------------------

--
-- Table structure for table `durable_articles`
--

CREATE TABLE `durable_articles` (
  `id_durable` int NOT NULL,
  `name` varchar(75) COLLATE utf8mb4_general_ci NOT NULL,
  `type_durable` varchar(75) COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(75) COLLATE utf8mb4_general_ci NOT NULL,
  `asset_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `brand` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `building` varchar(75) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `room_number` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_asset` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no-image.png',
  `price` int DEFAULT NULL,
  `year` year DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `durable_articles`
--

INSERT INTO `durable_articles` (`id_durable`, `name`, `type_durable`, `department`, `asset_id`, `brand`, `model`, `building`, `room_number`, `image_asset`, `price`, `year`) VALUES
(27, 'เครื่องปรับอากาศ-ห้องดนตรีไทย 1', 'เครื่องปรับอากาศ', '4', '5406040000002', 'SAIJODENKI', '9000 BTU', '1', '1101', 'no-image.png', 0, NULL),
(28, 'เครื่องปรับอากาศ-กิจการนักศึกษา', 'เครื่องปรับอากาศ', '4', '5406040000004', 'ไซโจเด็นจิ', '', '1', '1108', 'no-image.png', 0, NULL),
(32, 'เครื่องปรับอากาศ-ห้องเรียน ป.โท 1', 'เครื่องปรับอากาศ', '4', 'N1-26-143-39', 'AMENA', '36000 BTU', '1', '1201', 'no-image.png', 0, NULL),
(33, 'เครื่องปรับอากาศ-ห้องเรียน ป.โท 2', 'เครื่องปรับอากาศ', '4', 'N1-26-144-39', 'AMENA', '36000 BTU', '1', '1201', 'no-image.png', 0, NULL),
(34, 'เครื่องปรับอากาศ-ห้องปฎิบัติการคอมพิวเตอร์', 'เครื่องปรับอากาศ', '5', '5306120000016', 'York', '36000 BTU', '2', '', 'RESIZED_IMG-65a9d6fd6e66a4.57061657.jpg', 0, NULL),
(35, 'เครื่องกรองน้ำ-ห้องปฏิบัติการคอมพิวเตอร์', 'เครื่องกรองน้ำดื่ม', '5', '06PR608/000016', '', '', '6 ชั้น 2', 'ห้องปฏิบัติการคอมพิวเตอร์', 'RESIZED_IMG-65a9d7287c8cc2.56570813.jpg', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `list_parcel_req`
--

CREATE TABLE `list_parcel_req` (
  `id` int NOT NULL,
  `report_req_id` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_parcel` text COLLATE utf8mb4_general_ci NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parcel_data`
--

CREATE TABLE `parcel_data` (
  `id_parcel` int NOT NULL,
  `id_qr` text COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(75) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name_parcel` varchar(75) COLLATE utf8mb4_general_ci NOT NULL,
  `model` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brand` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `qty` int DEFAULT '0',
  `unit_num` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parcel_data`
--

INSERT INTO `parcel_data` (`id_parcel`, `id_qr`, `type`, `name_parcel`, `model`, `brand`, `qty`, `unit_num`) VALUES
(1, 'CLFKCXIACB4848588', '1', 'ลวดเย็บกระดาษ เบอร์ 8-1 เอ็ม', '', '', 0, '1'),
(2, 'NHQPJIPSDQ2282024', '1', 'ลวดเย็บกระดาษ ขนาด 10 มม.', 'ขนาด 10 มม.', '', 0, '1'),
(3, 'SQYEYSHHLV8285196', '1', 'คลิบเสียบกระดาษ', '', '', 0, '1'),
(4, 'GJWBKIYCZP3295756', '1', 'คลิบหนีบสีดำ เบอร์ 108', 'เบอร์ 108', '', 0, '1'),
(5, 'QLMBDWEANR9840147', '1', 'คลิบหนีบสีดำ เบอร์ 109', 'เบอร์ 109', '', 0, '1'),
(6, 'SEBGNBDMSQ4003843', '1', 'คลิบหนีบสีดำ เบอร์ 110', 'เบอร์ 110', '', 1, '1'),
(7, 'PWRODPOPXP3552664', '1', 'คลิบหนีบสีดำ เบอร์ 111', 'เบอร์ 111', '', 0, '1'),
(8, 'ZTJNGBTYHQ4731963', '1', 'คลิบหนีบสีดำ เบอร์ 112', 'เบอร์ 112', '', 0, '1'),
(9, 'WERRISQEQT3673965', '1', 'ยางลบชนิดก้อน', '', '', 0, '2'),
(10, 'DMKIBOJNCB6228666', '1', 'ถ่านอัลคาไลน์ 1.5V AAA', '1.5V AAA', '', 0, '2'),
(11, 'JFJCGDPXAN4857695', '1', 'ถ่านอัลคาไลน์ 1.5V AA', '1.5V AA', '', 0, '2'),
(12, 'LDSVICFRHR2131334', '1', 'ถ่านไฟฉาย AA ก้อนเขียว', '', '', 0, '2'),
(13, 'UDLMNMFEOC9041189', '1', 'ถ่านไฟฉาย ขนาดจิ๋ว AAA ก้อนเขียว (บรรจุเป็นก้อน)', '', '', 0, '2'),
(14, 'WFWCJLZFWF3199691', '1', 'น้ำยาลบคำผิด (ชนิดขวด)', '', '', 0, '3'),
(15, 'JRFOXZBUYK5963505', '1', 'ใบมีดคัตเตอร์ขนาดเล็ก', '', '', 0, '5'),
(16, 'SDGNADCXQA4630215', '1', 'ใบมีดคัตเตอร์ขนาดใหญ่', '', '', 0, '5'),
(17, 'HNXMJLCLMP4519904', '1', 'ปากกาลูกลื่น (สีดำ)', 'สีดำ', '', 0, '6'),
(18, 'YUXJYXOWJT8500876', '1', 'ปากกาลูกลื่น (สีแดง)', '', '', 0, '6'),
(19, 'AWAALPGYHV3711202', '1', 'ปากกาลูกลื่น (สีน้ำเงิน)', 'สีน้ำเงิน', '', -6, '6'),
(20, 'SMERJJGEIZ1917527', '1', 'ปากกาเขียนกระดานขาว (สีดำ)', 'สีดำ', '', 0, '6'),
(21, 'LGCLVKMCHA9633324', '1', 'ปากกาเขียนกระดานขาว (สีแดง)', '', '', 0, '6'),
(22, 'NCBOYFBRCZ4181192', '1', 'ปากกาเขียนกระดานขาว (สีน้ำเงิน)', '', '', 0, '6'),
(23, 'CJBERWJOPP2053453', '1', 'ดินสอดำ 2B', '', '', 0, '7'),
(24, 'ZFWKZOUIWK9783128', '1', 'แผ่น CD - R', '', '', 0, '8'),
(25, 'RMORSOOTBV9984273', '1', 'แผ่น DVD - R', '', '', 0, '8'),
(26, 'RMKBVBFCAH8377736', '1', 'แฟ้มสอดพลาสติก ขนาด A4 1 ช่อง', '', '', 0, '9'),
(27, 'CBMJNSFYTV1528336', '1', 'เทปใส ขนาด3/4 นิ้ว', '', '', 50, '10'),
(28, 'OEGEIAKSKY4570728', '1', 'เทปโฟมกาวสองหน้า (ขนาดเล็ก)', '', '', 0, '10'),
(29, 'BMVNEXFFGV9641048', '1', 'เทปติดสันหนังสือ ขนาด 1 นิ้ว', '', '', 0, '10'),
(30, 'AONBJBVUQK6900735', '1', 'เทปติดสันหนังสือ ขนาด 1 1/2 นิ้ว', '', '', 0, '10'),
(31, 'NHXNMBPECU6470469', '1', 'เทปติดสันหนังสือ ขนาด 2 นิ้ว', '', '', 10, '10'),
(32, 'WSTQTEMGCD2843524', '1', 'กาวยูฮู (UHU)', '', '', 0, '4'),
(33, 'YPLIMMAEJT1613697', '1', 'ไส้แฟ้มเอนกประสงค์ ขนาด A4 (ไส้แฟ้ม 11 รู)', '', '', 0, '9'),
(34, 'HESVSLGBBB3456069', '1', 'ไม้บรรทัดพลาสติก ขนาด 12\"', '', '', 0, '11'),
(35, 'WDWOSOHAFK9023976', '1', 'คัตเตอร์ขนาดเล็ก', '', '', 0, '11'),
(36, 'BOAELDNSIU8734646', '1', 'คัตเตอร์ขนาดใหญ่', '', '', 0, '11'),
(37, 'SLTNFHHRQC5982960', '1', 'ที่เย็บกระดาษ เบอร์ 8 พร้อมที่ถอนแซะ', '', '', 0, '11'),
(38, 'GUGCOKCNMP4403908', '1', 'ที่เย็นกระดาษ เบอร์ 10', '', '', 0, '11');

-- --------------------------------------------------------

--
-- Table structure for table `repair_report_pd05`
--

CREATE TABLE `repair_report_pd05` (
  `id_repair` int NOT NULL,
  `type_repair` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ประเภทการแจ้งซ่อม',
  `type` varchar(75) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ประเภทการแจ้ง',
  `department_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `asset_name` varchar(75) COLLATE utf8mb4_general_ci NOT NULL,
  `asset_id` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `asset_detail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `building` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `room_number` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `neet` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ความต้องการซ่อม',
  `tech_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_person_report` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `report_signature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `report_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_report_in` timestamp NOT NULL,
  `status` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `cancel_comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_cancel` timestamp NULL DEFAULT NULL,
  `cancel_id` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reasons` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `last_amount` int DEFAULT NULL,
  `recomment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inspector_name1` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inspector_name2` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `inspector_name3` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `repair_type` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ประเภทการซ่อมของช่าง',
  `send_to` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `signature_tech` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_tech_confirm` timestamp NULL DEFAULT NULL,
  `id_head` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_update_head` timestamp NULL DEFAULT NULL,
  `signature_head` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `signature_head_klung` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_head_klung` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cancel_comment_head_klung` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_head_klung_update` timestamp NULL DEFAULT NULL,
  `signature_director` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_director` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cancel_comment_director` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_director_update` timestamp NULL DEFAULT NULL,
  `signature_dean` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_dean` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cancel_comment_dean` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_dean_update` timestamp NULL DEFAULT NULL,
  `close` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_req_parcel`
--

CREATE TABLE `report_req_parcel` (
  `id` int NOT NULL,
  `date_in` timestamp NOT NULL,
  `dapartment_id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `signature_req` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_req` text COLLATE utf8mb4_general_ci NOT NULL,
  `signature_parcel` text COLLATE utf8mb4_general_ci,
  `id_parcel` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `signature_parcel_head` text COLLATE utf8mb4_general_ci,
  `id_parcel_head` text COLLATE utf8mb4_general_ci,
  `signature_success` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `name_sueccess` text COLLATE utf8mb4_general_ci,
  `comment_cancel` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `close` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_parcel`
--

CREATE TABLE `type_parcel` (
  `id` int NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type_parcel`
--

INSERT INTO `type_parcel` (`id`, `name`) VALUES
(1, 'สำนักงาน'),
(3, 'งานไฟฟ้า'),
(5, 'งานบ้าน');

-- --------------------------------------------------------

--
-- Table structure for table `type_repair`
--

CREATE TABLE `type_repair` (
  `id_type_repair` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type_repair`
--

INSERT INTO `type_repair` (`id_type_repair`, `name`) VALUES
(1, 'เครื่องปรับอากาศ'),
(2, 'เครื่องกรองน้ำดื่ม'),
(3, 'รถยนต์');

-- --------------------------------------------------------

--
-- Table structure for table `unit_parcel`
--

CREATE TABLE `unit_parcel` (
  `id` int NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_parcel`
--

INSERT INTO `unit_parcel` (`id`, `name`) VALUES
(1, 'กล่อง'),
(2, 'ก้อน'),
(3, 'ขวด'),
(4, 'หลอด'),
(5, 'ซอง'),
(6, 'ด้าม'),
(7, 'แท่ง'),
(8, 'แผ่น'),
(9, 'ห่อ'),
(10, 'ม้วน'),
(11, 'อัน');

-- --------------------------------------------------------

--
-- Table structure for table `urole`
--

CREATE TABLE `urole` (
  `id_urole` int NOT NULL,
  `name` varchar(15) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `urole`
--

INSERT INTO `urole` (`id_urole`, `name`) VALUES
(1, 'admin'),
(2, 'ช่าง'),
(4, 'หัวหน้าหน่วย'),
(5, 'ผู้อำนวยการ'),
(6, 'คณบดี'),
(9, 'พัสดุ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id_person`),
  ADD KEY `foreign key urole` (`urole`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id_department`);

--
-- Indexes for table `durable_articles`
--
ALTER TABLE `durable_articles`
  ADD PRIMARY KEY (`id_durable`);

--
-- Indexes for table `list_parcel_req`
--
ALTER TABLE `list_parcel_req`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcel_data`
--
ALTER TABLE `parcel_data`
  ADD PRIMARY KEY (`id_parcel`);

--
-- Indexes for table `repair_report_pd05`
--
ALTER TABLE `repair_report_pd05`
  ADD PRIMARY KEY (`id_repair`);

--
-- Indexes for table `report_req_parcel`
--
ALTER TABLE `report_req_parcel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_parcel`
--
ALTER TABLE `type_parcel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_repair`
--
ALTER TABLE `type_repair`
  ADD PRIMARY KEY (`id_type_repair`);

--
-- Indexes for table `unit_parcel`
--
ALTER TABLE `unit_parcel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `urole`
--
ALTER TABLE `urole`
  ADD PRIMARY KEY (`id_urole`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id_department` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `durable_articles`
--
ALTER TABLE `durable_articles`
  MODIFY `id_durable` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `list_parcel_req`
--
ALTER TABLE `list_parcel_req`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `parcel_data`
--
ALTER TABLE `parcel_data`
  MODIFY `id_parcel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `repair_report_pd05`
--
ALTER TABLE `repair_report_pd05`
  MODIFY `id_repair` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `report_req_parcel`
--
ALTER TABLE `report_req_parcel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `type_parcel`
--
ALTER TABLE `type_parcel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `type_repair`
--
ALTER TABLE `type_repair`
  MODIFY `id_type_repair` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unit_parcel`
--
ALTER TABLE `unit_parcel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `urole`
--
ALTER TABLE `urole`
  MODIFY `id_urole` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
