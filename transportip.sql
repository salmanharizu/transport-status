-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2022 at 06:15 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transportip`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `at_code` varchar(2) NOT NULL,
  `at_id` int(6) UNSIGNED ZEROFILL DEFAULT NULL,
  `staff_id` varchar(6) NOT NULL,
  `book_id` varchar(10) NOT NULL,
  `at_date` date NOT NULL DEFAULT current_timestamp(),
  `at_time` datetime NOT NULL DEFAULT current_timestamp(),
  `at_desc_old` varchar(255) NOT NULL,
  `at_desc_new` varchar(255) NOT NULL,
  `at_status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`at_code`, `at_id`, `staff_id`, `book_id`, `at_date`, `at_time`, `at_desc_old`, `at_desc_new`, `at_status`) VALUES
('AB', 000001, 'KEV001', '000006', '2021-09-15', '2021-09-15 17:34:46', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV001 : Requested By: KEV001', 1),
('AB', 000002, 'KEV001', '000008', '2021-09-19', '2021-09-19 00:08:44', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV001 : Requested By: KEV003', 1),
('AB', 000003, 'KEV001', '000009', '2021-09-19', '2021-09-19 00:11:58', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV001 : Requested By: KEV001', 1),
('AB', 000004, 'KEV011', '000010', '2021-09-20', '2021-09-20 15:13:19', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV024', 1),
('AB', 000005, 'KEV011', '000011', '2021-09-20', '2021-09-20 15:37:47', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV024', 1),
('AB', 000006, 'KEV016', '000014', '2021-09-24', '2021-09-24 10:19:51', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV016 : Requested By: KEV014', 1),
('AB', 000007, 'KEV016', '000016', '2021-09-24', '2021-09-24 10:34:57', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV016 : Requested By: KEV015', 1),
('AB', 000008, 'KEV016', '000016', '2021-09-24', '2021-09-24 10:35:00', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV016 : Requested By: KEV015', 1),
('AB', 000009, 'KEV011', '000018', '2021-09-30', '2021-09-30 09:05:04', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV012', 1),
('AB', 000010, 'KEV011', '000018', '2021-09-30', '2021-09-30 09:05:07', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV012', 1),
('AB', 000011, 'KEV011', '000020', '2021-10-08', '2021-10-08 18:11:54', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: IP013', 1),
('AB', 000012, 'KEV011', '000021', '2021-10-08', '2021-10-08 18:36:58', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV024', 1),
('AB', 000013, 'KEV011', '000023', '2021-10-08', '2021-10-08 18:37:05', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV011', 1),
('AB', 000014, 'KEV011', '000025', '2021-11-04', '2021-11-04 15:31:34', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV011', 1),
('AB', 000015, 'KEV011', '000026', '2021-11-04', '2021-11-04 15:31:45', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: IP013', 1),
('AB', 000016, 'KEV011', '000030', '2021-11-04', '2021-11-04 16:23:31', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV012', 1),
('AB', 000017, 'KEV011', '000034', '2021-12-23', '2021-12-23 15:31:10', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV012', 1),
('AB', 000018, 'KEV011', '000033', '2021-12-23', '2021-12-23 15:31:22', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV012', 1),
('AB', 000019, 'KEV011', '000035', '2021-12-23', '2021-12-23 15:31:37', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV011 : Requested By: KEV011', 1),
('AB', 000020, 'KEV001', '000037', '2022-02-07', '2022-02-07 14:37:27', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV001 : Requested By: KEV001', 1),
('AB', 000021, 'KEV001', '000042', '2022-02-17', '2022-02-17 12:03:27', 'Change status In Process(0) To Approved(1)', 'Approved By: KEV001 : Requested By: KEV001', 1),
('CB', 000001, 'KEV001', '111999', '2021-09-15', '2021-09-15 17:34:15', 'WWW7777 : bookdesc : 15-10-2021 : 17-10-2021 : 02:00 pm : 04:00 pm', 'Reason To Cancel: cancel due to record manually key in thru terminal ', 1),
('CB', 000001, 'KEV024', '000010', '2021-09-20', '2021-09-20 15:28:38', 'VBJ 2174 : Beli barang : 20-09-2021 : 20-09-2021 : 03:11 pm : 04:11 pm', 'Reason To Cancel:  Personal matter', 1),
('CB', 000001, 'KEV012', '000013', '2021-09-20', '2021-09-20 17:12:13', 'VBJ 2174 : Testing : 21-09-2021 : 30-10-2021 : 10:10 pm : 10:10 pm', 'Reason To Cancel:  testing', 1),
('CB', 000001, 'KEV014', '000014', '2021-09-24', '2021-09-24 10:29:18', 'RAE 1517 : beli makanan : 24-09-2021 : 24-09-2021 : 12:00 pm : 01:00 pm', 'Reason To Cancel:  Makanan beli guna foodpanda', 1),
('CB', 000001, 'KEV011', '000028', '2021-11-04', '2021-11-04 16:22:47', 'RAE 1517 : beli makanan : 05-11-2021 : 05-11-2021 : 10:01 am : 11:01 am', 'Reason To Cancel:  tak jadi beli', 1),
('CP', 000006, 'KEV002', 'KEV002', '2021-09-18', '2021-09-18 17:19:06', 'Old Password : 994f1353bc3b684c749cc96cc864f7e4', 'New Password : 65111f1c00aa37f1111a88b136aaa3c5', 1),
('CP', 000007, 'KEV011', 'KEV011', '2021-09-24', '2021-09-24 09:07:29', 'Old Password : c62d45d5a73417159ef39c386098dbfb', 'New Password : 6b9d6ba55e4f27b1eb5ab5ca05d160a4', 1),
('CP', 000008, 'IP013', 'IP013', '2021-10-08', '2021-10-08 18:07:04', 'Old Password : a6cd9a805e4da61cd6425cc464b0cc71', 'New Password : 677474622de5871fd6339afb050dbf10', 1),
('CP', 000009, 'KEV024', 'KEV024', '2021-10-08', '2021-10-08 18:07:10', 'Old Password : 468bb1b7beb6e7eaefc596bd0493a235', 'New Password : e2f52944dc73154785fc8c9042e27ff2', 1),
('CS', 000003, 'KEV003', '000009', '2021-09-19', '2021-09-19 00:59:42', 'Old Service Date : 2021-12-11 ; Old Service Mileage : 155000', 'New Service Date : 2022-06-11 ; New Service Mileage : 160000', 1),
('EB', 000001, 'KEV001', '000006', '2021-09-15', '2021-09-15 17:31:47', 'test kat server', 'test kat server utk edit', 1),
('EB', 000002, 'KEV003', '000008', '2021-09-19', '2021-09-19 00:08:19', 'MPKJ-uruskan lesen perniagaan.', 'MPKJ-uruskan lesen perniagaan - ipfokus', 1),
('EB', 000003, 'KEV024', '000011', '2021-09-20', '2021-09-20 15:36:03', '21-09-2021 : 21-09-2021 : 10:30 am : 12:30 pm : RAE 1517 : TPM-CTC : No-Car Not To Service', '21-09-2021 : 21-09-2021 : 10:30 am : 12:30 pm : VEE 2989 : TPM-CTC : No-Car Not To Service', 1),
('NB', 000006, 'KEV001', '000006', '2021-09-15', '2021-09-15 17:30:21', 'Booking status is In Process(0)', '16-09-2021 : 16-09-2021 : 08:30 am : 05:30 pm : VBJ 2174 : test kat server', 1),
('NB', 000007, 'KEV001', '000007', '2021-09-17', '2021-09-17 14:22:28', 'Booking status is In Process(0)', '17-09-2021 : 17-09-2021 : 02:30 pm : 04:30 pm : BMW1111 : testing kat server lagi at noon', 1),
('NB', 000008, 'KEV003', '000008', '2021-09-19', '2021-09-19 00:07:07', 'Booking status is In Process(0)', '19-09-2021 : 19-09-2021 : 09:00 am : 12:00 pm : RAE 1517 : MPKJ-uruskan lesen perniagaan.', 1),
('NB', 000009, 'KEV001', '000009', '2021-09-19', '2021-09-19 00:11:40', 'Booking status is In Process(0)', '20-09-2021 : 20-09-2021 : 09:00 am : 03:00 pm : VBJ 2174 : Servis Myvi - Selaman Business Park', 1),
('NB', 000010, 'KEV024', '000010', '2021-09-20', '2021-09-20 15:12:23', 'Booking status is In Process(0)', '20-09-2021 : 20-09-2021 : 03:11 pm : 04:11 pm : VBJ 2174 : Beli barang', 1),
('NB', 000011, 'KEV024', '000011', '2021-09-20', '2021-09-20 15:32:03', 'Booking status is In Process(0)', '21-09-2021 : 21-09-2021 : 10:30 am : 12:30 pm : RAE 1517 : TPM-CTC', 1),
('NB', 000013, 'KEV012', '000013', '2021-09-20', '2021-09-20 17:11:06', 'Booking status is In Process(0)', '21-09-2021 : 30-10-2021 : 10:10 pm : 10:10 pm : VBJ 2174 : Testing', 1),
('NB', 000014, 'KEV014', '000014', '2021-09-24', '2021-09-24 09:58:16', 'Booking status is In Process(0)', '24-09-2021 : 24-09-2021 : 12:00 pm : 01:00 pm : RAE 1517 : beli makanan', 1),
('NB', 000016, 'KEV015', '000016', '2021-09-24', '2021-09-24 10:32:24', 'Booking status is In Process(0)', '27-09-2021 : 29-09-2021 : 10:32 am : 10:32 am : RAE 1517 : OUTSTATION MELAKA', 1),
('NB', 000017, 'KEV001', '000017', '2021-09-24', '2021-09-24 17:23:52', 'Booking status is In Process(0)', '24-09-2021 : 24-09-2021 : 01:00 pm : 02:00 pm : RAE 1517 : testing111111111111', 1),
('NB', 000018, 'KEV012', '000018', '2021-09-28', '2021-09-28 14:32:37', 'Booking status is In Process(0)', '30-09-2021 : 30-09-2021 : 08:00 am : 05:00 pm : VBJ 2174 : Outstation - UiTM Jasin - Testing', 1),
('NB', 000019, 'KEV012', '000019', '2021-09-29', '2021-09-29 09:02:56', 'Booking status is In Process(0)', '29-09-2021 : 29-09-2021 : 09:30 am : 05:00 pm : VBJ 2174 : LHDNM PPM Bangi - Amal - testing', 1),
('NB', 000020, 'IP013', '000020', '2021-10-08', '2021-10-08 18:09:07', 'Booking status is In Process(0)', '09-10-2021 : 09-10-2021 : 09:05 am : 10:30 am : RAE 1517 : test', 1),
('NB', 000021, 'KEV024', '000021', '2021-10-08', '2021-10-08 18:12:57', 'Booking status is In Process(0)', '10-10-2021 : 10-10-2021 : 09:00 am : 10:00 am : RAE 1517 : Test test', 1),
('NB', 000023, 'KEV011', '000023', '2021-10-08', '2021-10-08 18:34:09', 'Booking status is In Process(0)', '10-10-2021 : 11-10-2021 : 06:33 pm : 06:33 pm : VBJ 2174 : test 2.0', 1),
('NB', 000024, 'IP013', '000024', '2021-10-08', '2021-10-08 18:44:05', 'Booking status is In Process(0)', '12-10-2021 : 12-10-2021 : 10:40 pm : 10:55 pm : VBJ 2174 : Testing', 1),
('NB', 000025, 'KEV011', '000025', '2021-11-04', '2021-11-04 09:56:16', 'Booking status is In Process(0)', '05-11-2021 : 05-11-2021 : 09:00 am : 10:00 am : RAE 1517 : yuni test', 1),
('NB', 000026, 'IP013', '000026', '2021-11-04', '2021-11-04 09:59:12', 'Booking status is In Process(0)', '08-11-2021 : 09-11-2021 : 10:59 am : 11:00 pm : RAE 1517 : testing', 1),
('NB', 000027, 'IP013', '000027', '2021-11-04', '2021-11-04 10:00:00', 'Booking status is In Process(0)', '10-11-2021 : 11-11-2021 : 11:59 am : 12:59 am : VEE 2989 : testing', 1),
('NB', 000028, 'KEV011', '000028', '2021-11-04', '2021-11-04 10:02:08', 'Booking status is In Process(0)', '05-11-2021 : 05-11-2021 : 10:01 am : 11:01 am : RAE 1517 : beli makanan', 1),
('NB', 000029, 'KEV011', '000029', '2021-11-04', '2021-11-04 13:29:33', 'Booking status is In Process(0)', '07-11-2021 : 07-11-2021 : 01:30 pm : 02:30 pm : RAE 1517 : yuni test', 1),
('NB', 000030, 'KEV012', '000030', '2021-11-04', '2021-11-04 16:17:29', 'Booking status is In Process(0)', '12-11-2021 : 13-11-2021 : 10:00 pm : 11:00 am : RAE 1517 : test', 1),
('NB', 000031, 'KEV012', '000031', '2021-12-15', '2021-12-15 15:54:41', 'Booking status is In Process(0)', '15-12-2021 : 17-12-2021 : 04:00 pm : 05:00 pm : VEE 2989 : Syed Arif - SMS Tuanku Syed Putra, Perlis', 1),
('NB', 000032, 'KEV011', '000032', '2021-12-17', '2021-12-17 13:04:16', 'Booking status is In Process(0)', '17-12-2021 : 17-12-2021 : 02:03 pm : 03:02 pm : VBJ 2174 : testing 1.0', 1),
('NB', 000033, 'KEV012', '000033', '2021-12-20', '2021-12-20 16:50:35', 'Booking status is In Process(0)', '24-12-2021 : 31-12-2021 : 04:30 pm : 05:00 pm : VBJ 2174 : Zulfiqar - Trainocate', 1),
('NB', 000034, 'KEV012', '000034', '2021-12-20', '2021-12-20 16:51:46', 'Booking status is In Process(0)', '03-01-2022 : 07-01-2022 : 08:00 am : 05:00 pm : RAE 1517 : Aminnurhakim - UiTM Shah Alam', 1),
('NB', 000035, 'KEV011', '000035', '2021-12-23', '2021-12-23 14:24:42', 'Booking status is In Process(0)', '24-12-2021 : 24-12-2021 : 12:30 pm : 02:30 pm : VBJ 2174 : beli makanan', 1),
('NB', 000036, 'KEV011', '000036', '2021-12-23', '2021-12-23 15:34:07', 'Booking status is In Process(0)', '01-01-2022 : 03-01-2022 : 01:30 am : 02:30 am : RAE 1517 : yuni test', 1),
('NB', 000037, 'KEV001', '000037', '2022-02-07', '2022-02-07 14:19:34', 'Booking status is In Process(0)', '08-02-2022 : 08-02-2022 : 02:18 pm : 05:18 pm : VBJ 2174 : Pergi Maybank seksyen9 bangi', 1),
('NB', 000038, 'KEV001', '000038', '2022-02-09', '2022-02-09 10:07:28', 'Booking status is In Process(0)', '09-02-2022 : 11-02-2022 : 05:00 pm : 05:00 pm : RAE 1517 : test', 1),
('NB', 000039, 'KEV001', '000039', '2022-02-09', '2022-02-09 10:07:59', 'Booking status is In Process(0)', '12-02-2022 : 13-02-2022 : 05:00 pm : 05:00 pm : VBJ 2174 : test', 1),
('NB', 000040, 'KEV001', '000040', '2022-02-09', '2022-02-09 10:09:01', 'Booking status is In Process(0)', '22-02-2022 : 24-02-2022 : 05:00 pm : 05:00 pm : RAE 1517 : test', 1),
('NB', 000041, 'KEV001', '000041', '2022-02-09', '2022-02-09 10:10:00', 'Booking status is In Process(0)', '26-02-2022 : 28-02-2022 : 05:00 pm : 05:00 pm : RAE 1517 : test', 1),
('NB', 000042, 'KEV001', '000042', '2022-02-17', '2022-02-17 12:02:57', 'Booking status is In Process(0)', '18-02-2022 : 18-02-2022 : 05:00 pm : 06:00 pm : VBJ 2174 : pergi hospital', 1),
('NR', 000006, 'KEV001', 'TEST01', '2021-09-18', '2021-09-18 11:00:00', 'New User Register:NewUser:Name:Email:Pwd', 'test01:Test01:test01@gmail.com:0e698a8ffc1a0af622c7b4db3cb750cc', 1),
('NR', 000007, 'KEV001', 'KEV002', '2021-09-18', '2021-09-18 16:59:36', 'New User Register:NewUser:Name:Email:Pwd', 'KEV002:Aida Mininda:aida@gmail.com:994f1353bc3b684c749cc96cc864f7e4', 1),
('NR', 000008, 'KEV001', 'KEV012', '2021-09-20', '2021-09-20 15:03:07', 'New User Register:NewUser:Name:Email:Pwd', 'kev012:AIMI NADIRAH BINTI AZIZ:aimi@ipfokus.com:30d7ca224403a08b81244212b4efbf73', 1),
('NR', 000009, 'KEV001', 'KEV011', '2021-09-20', '2021-09-20 15:04:06', 'New User Register:NewUser:Name:Email:Pwd', 'kev011:YUNI ZAHARA BINTI YUNAIDI:yuni@ipfokus.com:c62d45d5a73417159ef39c386098dbfb', 1),
('NR', 000010, 'KEV001', 'KEV024', '2021-09-20', '2021-09-20 15:05:27', 'New User Register:NewUser:Name:Email:Pwd', 'KEV024:NUR AIN BINTI HAZMI:ainhazmi.kev@gmail.com:468bb1b7beb6e7eaefc596bd0493a235', 1),
('NR', 000011, 'KEV011', 'KEV012', '2021-09-24', '2021-09-24 09:37:02', 'New User Register:NewUser:Name:Email:Pwd', 'kev012:YUNI CLONE ID AIN:ainhazmi.kev@gmail.com:6b9d6ba55e4f27b1eb5ab5ca05d160a4', 1),
('NR', 000012, 'KEV011', 'KEV012', '2021-09-24', '2021-09-24 09:40:03', 'New User Register:NewUser:Name:Email:Pwd', 'kev012:YUNI CLONE ID AIN:misssera0307@gmail.com:30d7ca224403a08b81244212b4efbf73', 1),
('NR', 000013, 'KEV011', 'KEV014', '2021-09-24', '2021-09-24 09:45:06', 'New User Register:NewUser:Name:Email:Pwd', 'kev014:YUNI TESTING 1.0:misssera0307@gmail.com:6b9d6ba55e4f27b1eb5ab5ca05d160a4', 1),
('NR', 000014, 'KEV011', 'KEV015', '2021-09-24', '2021-09-24 09:45:53', 'New User Register:NewUser:Name:Email:Pwd', 'KEV015:YUNI TESTING 2.0:misssera0307@gmail.com:6b9d6ba55e4f27b1eb5ab5ca05d160a4', 1),
('NR', 000015, 'KEV011', 'KEV016', '2021-09-24', '2021-09-24 09:51:40', 'New User Register:NewUser:Name:Email:Pwd', 'kev016:YUNI TESTING 3.0:misssera0307@gmail.com:6b9d6ba55e4f27b1eb5ab5ca05d160a4', 1),
('NR', 000016, 'KEV016', 'KEV017', '2021-09-24', '2021-09-24 10:23:06', 'New User Register:NewUser:Name:Email:Pwd', 'kev017:AIN TEST 1.0 (C3):ainhazmi.kev@gmail.com:06b499268241b9709414d62fa8c06944', 1),
('NR', 000017, 'KEV011', 'KEV014', '2021-09-24', '2021-09-24 15:50:47', 'New User Register:NewUser:Name:Email:Pwd', 'kev014:YUNI TEST 1.0:misssera0307@gmail.com:6b9d6ba55e4f27b1eb5ab5ca05d160a4', 1),
('NR', 000018, 'KEV011', 'KEV015', '2021-09-24', '2021-09-24 15:51:26', 'New User Register:NewUser:Name:Email:Pwd', 'KEV015:YUNI TESTING 2.0:misssera0307@gmail.com:fb8ca3776ea61b0d2d3b011677d1978b', 1),
('NR', 000019, 'KEV011', 'IP013', '2021-10-08', '2021-10-08 18:03:11', 'New User Register:NewUser:Name:Email:Pwd', 'ip013:Dilla:nurfadhillah@ipfokus.com:a6cd9a805e4da61cd6425cc464b0cc71', 1),
('NR', 000020, 'KEV011', 'IP012', '2021-10-08', '2021-10-08 18:15:42', 'New User Register:NewUser:Name:Email:Pwd', 'ip012:AIN TEST 1.0 (C3):ainhazmi.kev@gmail.com:a2a88235a1691653af974e5009031d28', 1),
('NR', 000021, 'KEV011', 'IP014', '2021-10-08', '2021-10-08 18:17:11', 'New User Register:NewUser:Name:Email:Pwd', 'ip014:AIN TEST 1.0 (C3):ainhazmi.kev@gmail.com:bf06d69212eb183731e109fecd1c89e7', 1),
('PK', 000001, 'KEV003', '000006', '2021-09-15', '2021-09-15 17:37:23', 'Change Status Approved(1) To Pass Key(3)', 'Pass VBJ 2174 Key To: KEV001 ; Process Done By: KEV003', 1),
('PK', 000002, 'KEV003', '000008', '2021-09-19', '2021-09-19 00:09:10', 'Change Status Approved(1) To Pass Key(3)', 'Pass RAE 1517 Key To: KEV003 ; Process Done By: KEV003', 1),
('PK', 000003, 'KEV003', '000009', '2021-09-19', '2021-09-19 00:13:15', 'Change Status Approved(1) To Pass Key(3)', 'Pass VBJ 2174 Key To: KEV001 ; Process Done By: KEV003', 1),
('PK', 000004, 'KEV012', '000011', '2021-09-20', '2021-09-20 15:40:50', 'Change Status Approved(1) To Pass Key(3)', 'Pass VEE 2989 Key To: KEV024 ; Process Done By: KEV012', 1),
('PK', 000005, 'KEV014', '000016', '2021-09-24', '2021-09-24 16:01:33', 'Change Status Approved(1) To Pass Key(3)', 'Pass RAE 1517 Key To: KEV015 ; Process Done By: KEV014', 1),
('PK', 000006, 'KEV012', '000018', '2021-09-30', '2021-09-30 09:05:53', 'Change Status Approved(1) To Pass Key(3)', 'Pass VBJ 2174 Key To: KEV012 ; Process Done By: KEV012', 1),
('PK', 000007, 'KEV012', '000020', '2021-10-08', '2021-10-08 18:26:42', 'Change Status Approved(1) To Pass Key(3)', 'Pass RAE 1517 Key To: IP013 ; Process Done By: KEV012', 1),
('PK', 000008, 'KEV012', '000023', '2021-10-08', '2021-10-08 18:39:21', 'Change Status Approved(1) To Pass Key(3)', 'Pass VBJ 2174 Key To: KEV011 ; Process Done By: KEV012', 1),
('PK', 000009, 'KEV012', '000021', '2021-10-08', '2021-10-08 18:39:29', 'Change Status Approved(1) To Pass Key(3)', 'Pass RAE 1517 Key To: KEV024 ; Process Done By: KEV012', 1),
('PK', 000010, 'KEV012', '000026', '2021-11-04', '2021-11-04 15:32:36', 'Change Status Approved(1) To Pass Key(3)', 'Pass RAE 1517 Key To: IP013 ; Process Done By: KEV012', 1),
('PK', 000011, 'KEV012', '000025', '2021-11-04', '2021-11-04 15:32:44', 'Change Status Approved(1) To Pass Key(3)', 'Pass RAE 1517 Key To: KEV011 ; Process Done By: KEV012', 1),
('RK', 000001, 'KEV003', '000006', '2021-09-15', '2021-09-15 17:38:19', 'Change Status Pass Key(3) To Return Key(4)', 'Received VBJ 2174 Key By: KEV003 ; Returned Key By: KEV001', 1),
('RK', 000002, 'KEV003', '000008', '2021-09-19', '2021-09-19 00:09:49', 'Change Status Pass Key(3) To Return Key(4)', 'Received RAE 1517 Key By: KEV003 ; Returned Key By: KEV003', 1),
('RK', 000003, 'KEV003', '000009', '2021-09-19', '2021-09-19 00:59:42', 'Change Status Pass Key(3) To Return Key(4)', 'Received VBJ 2174 Key By: KEV003 ; Returned Key By: KEV001', 1),
('RK', 000004, 'KEV012', '000011', '2021-09-20', '2021-09-20 15:46:03', 'Change Status Pass Key(3) To Return Key(4)', 'Received VEE 2989 Key By: KEV012 ; Returned Key By: KEV024', 1),
('RK', 000005, 'KEV012', '000018', '2021-10-07', '2021-10-07 15:43:01', 'Change Status Pass Key(3) To Return Key(4)', 'Received VBJ 2174 Key By: KEV012 ; Returned Key By: KEV012', 1),
('RK', 000006, 'KEV012', '000016', '2021-10-07', '2021-10-07 15:43:50', 'Change Status Pass Key(3) To Return Key(4)', 'Received RAE 1517 Key By: KEV012 ; Returned Key By: KEV015', 1),
('RK', 000007, 'KEV012', '000020', '2021-10-08', '2021-10-08 18:30:33', 'Change Status Pass Key(3) To Return Key(4)', 'Received RAE 1517 Key By: KEV012 ; Returned Key By: IP013', 1),
('RK', 000008, 'KEV012', '000021', '2021-11-04', '2021-11-04 15:33:33', 'Change Status Pass Key(3) To Return Key(4)', 'Received RAE 1517 Key By: KEV012 ; Returned Key By: KEV024', 1),
('TM', 000001, 'KEV003', '000006', '2021-09-15', '2021-09-15 17:38:19', 'Old Mileage : 200000', 'New Mileage : 200100', 1),
('TM', 000002, 'KEV003', '000008', '2021-09-19', '2021-09-19 00:09:49', 'Old Mileage : 600732', 'New Mileage : 600800', 1),
('TM', 000003, 'KEV003', '000009', '2021-09-19', '2021-09-19 00:59:42', 'Old Mileage : 200100', 'New Mileage : 200200', 1),
('TM', 000004, 'KEV012', '000011', '2021-09-20', '2021-09-20 15:46:03', 'Old Mileage : 700200', 'New Mileage : 700300', 1),
('TM', 000005, 'KEV012', '000018', '2021-10-07', '2021-10-07 15:43:01', 'Old Mileage : 60000', 'New Mileage : 77969', 1),
('TM', 000006, 'KEV012', '000016', '2021-10-07', '2021-10-07 15:43:50', 'Old Mileage : 30000', 'New Mileage : 40000', 1),
('TM', 000007, 'KEV012', '000020', '2021-10-08', '2021-10-08 18:30:33', 'Old Mileage : 40000', 'New Mileage : 43200', 1),
('TM', 000008, 'KEV012', '000021', '2021-11-04', '2021-11-04 15:33:33', 'Old Mileage : 43200', 'New Mileage : 43211', 1);

-- --------------------------------------------------------

--
-- Table structure for table `booking_master`
--

CREATE TABLE `booking_master` (
  `book_id` varchar(6) NOT NULL,
  `staff_id` varchar(6) NOT NULL,
  `book_start_date` datetime NOT NULL,
  `book_end_date` datetime NOT NULL,
  `book_start_time` time NOT NULL,
  `book_end_time` time NOT NULL,
  `book_carno` varchar(20) NOT NULL,
  `book_desc` varchar(255) NOT NULL,
  `odometer_start` int(11) NOT NULL,
  `odometer_end` int(11) NOT NULL,
  `book_status` int(1) NOT NULL DEFAULT 0,
  `trans_date` datetime NOT NULL DEFAULT current_timestamp(),
  `car_to_service` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_master`
--

INSERT INTO `booking_master` (`book_id`, `staff_id`, `book_start_date`, `book_end_date`, `book_start_time`, `book_end_time`, `book_carno`, `book_desc`, `odometer_start`, `odometer_end`, `book_status`, `trans_date`, `car_to_service`) VALUES
('000006', 'KEV001', '2021-09-16 08:30:00', '2021-09-16 17:30:00', '08:30:00', '17:30:00', 'VBJ 2174', 'test kat server utk edit', 200000, 200100, 4, '2021-09-15 17:38:19', 0),
('000007', 'KEV001', '2021-09-17 14:30:00', '2021-09-17 16:30:00', '14:30:00', '16:30:00', 'BMW1111', 'testing kat server lagi at noon', 1000, 1000, 0, '2021-09-17 14:22:28', 0),
('000008', 'KEV003', '2021-09-19 09:00:00', '2021-09-19 12:00:00', '09:00:00', '12:00:00', 'RAE 1517', 'MPKJ-uruskan lesen perniagaan - ipfokus', 600732, 600800, 4, '2021-09-19 00:09:49', 0),
('000009', 'KEV001', '2021-09-20 09:00:00', '2021-09-20 15:00:00', '09:00:00', '15:00:00', 'VBJ 2174', 'Servis Myvi - Selaman Business Park', 200100, 200200, 4, '2021-09-19 00:59:42', 1),
('000010', 'KEV024', '2021-09-20 15:11:00', '2021-09-20 16:11:00', '15:11:00', '16:11:00', 'VBJ 2174', 'Beli barang -  Personal matter', 200200, 200200, 2, '2021-09-20 15:28:38', 0),
('000011', 'KEV024', '2021-09-21 10:30:00', '2021-09-21 12:30:00', '10:30:00', '12:30:00', 'VEE 2989', 'TPM-CTC', 700200, 700300, 4, '2021-09-20 15:46:03', 0),
('000013', 'KEV012', '2021-09-21 22:10:00', '2021-10-30 22:10:00', '22:10:00', '22:10:00', 'VBJ 2174', 'Testing -  testing', 200200, 200200, 2, '2021-09-20 17:12:13', 0),
('000014', 'KEV014', '2021-09-24 12:00:00', '2021-09-24 13:00:00', '12:00:00', '13:00:00', 'RAE 1517', 'beli makanan -  Makanan beli guna foodpanda', 30000, 30000, 2, '2021-09-24 10:29:18', 0),
('000017', 'KEV001', '2021-09-24 13:00:00', '2021-09-24 14:00:00', '13:00:00', '14:00:00', 'RAE 1517', 'testing111111111111', 30000, 30000, 0, '2021-09-24 17:23:52', 0),
('000018', 'KEV012', '2021-09-30 08:00:00', '2021-09-30 17:00:00', '08:00:00', '17:00:00', 'VBJ 2174', 'Outstation - UiTM Jasin - Testing', 77694, 77969, 4, '2021-10-07 15:43:01', 0),
('000019', 'KEV012', '2021-09-29 09:30:00', '2021-09-29 17:00:00', '09:30:00', '17:00:00', 'VBJ 2174', 'LHDNM PPM Bangi - Amal - testing', 60000, 60000, 0, '2021-09-29 09:02:56', 0),
('000020', 'IP013', '2021-10-09 09:05:00', '2021-10-09 10:30:00', '09:05:00', '10:30:00', 'RAE 1517', 'test', 41300, 43200, 4, '2021-10-08 18:30:33', 0),
('000021', 'KEV024', '2021-10-10 09:00:00', '2021-10-10 10:00:00', '09:00:00', '10:00:00', 'RAE 1517', 'Test test', 43200, 43211, 4, '2021-11-04 15:33:33', 0),
('000023', 'KEV011', '2021-10-10 18:33:00', '2021-10-11 18:33:00', '18:33:00', '18:33:00', 'VBJ 2174', 'test 2.0', 77969, 77969, 3, '2021-10-08 18:39:21', 0),
('000024', 'IP013', '2021-10-12 22:40:00', '2021-10-12 22:55:00', '22:40:00', '22:55:00', 'VBJ 2174', 'Testing', 77969, 77969, 0, '2021-10-08 18:44:05', 0),
('000025', 'KEV011', '2021-11-05 09:00:00', '2021-11-05 10:00:00', '09:00:00', '10:00:00', 'RAE 1517', 'yuni test', 43200, 43200, 3, '2021-11-04 15:32:44', 0),
('000026', 'IP013', '2021-11-08 10:59:00', '2021-11-09 23:00:00', '10:59:00', '23:00:00', 'RAE 1517', 'testing', 43200, 43200, 3, '2021-11-04 15:32:36', 0),
('000027', 'IP013', '2021-11-10 11:59:00', '2021-11-11 00:59:00', '11:59:00', '00:59:00', 'VEE 2989', 'testing', 173000, 173000, 0, '2021-11-04 10:00:00', 0),
('000028', 'KEV011', '2021-11-05 10:01:00', '2021-11-05 11:01:00', '10:01:00', '11:01:00', 'RAE 1517', 'beli makanan -  tak jadi beli', 43200, 43200, 2, '2021-11-04 16:22:47', 0),
('000029', 'KEV011', '2021-11-07 13:30:00', '2021-11-07 14:30:00', '13:30:00', '14:30:00', 'RAE 1517', 'yuni test', 43200, 43200, 0, '2021-11-04 13:29:33', 0),
('000030', 'KEV012', '2021-11-12 22:00:00', '2021-11-13 11:00:00', '22:00:00', '11:00:00', 'RAE 1517', 'test', 43211, 43211, 1, '2021-11-04 16:23:31', 0),
('000031', 'KEV012', '2021-12-15 16:00:00', '2021-12-17 17:00:00', '16:00:00', '17:00:00', 'VEE 2989', 'Syed Arif - SMS Tuanku Syed Putra, Perlis', 173000, 173000, 0, '2021-12-15 15:54:41', 0),
('000032', 'KEV011', '2021-12-17 14:03:00', '2021-12-17 15:02:00', '14:03:00', '15:02:00', 'VBJ 2174', 'testing 1.0', 77969, 77969, 0, '2021-12-17 13:04:16', 0),
('000033', 'KEV012', '2021-12-24 16:30:00', '2021-12-31 17:00:00', '16:30:00', '17:00:00', 'VBJ 2174', 'Zulfiqar - Trainocate', 77969, 77969, 1, '2021-12-23 15:31:22', 0),
('000034', 'KEV012', '2022-01-03 08:00:00', '2022-01-07 17:00:00', '08:00:00', '17:00:00', 'RAE 1517', 'Aminnurhakim - UiTM Shah Alam', 43211, 43211, 1, '2021-12-23 15:31:10', 0),
('000035', 'KEV011', '2021-12-24 12:30:00', '2021-12-24 14:30:00', '12:30:00', '14:30:00', 'VBJ 2174', 'beli makanan', 77969, 77969, 1, '2021-12-23 15:31:37', 0),
('000036', 'KEV011', '2022-01-01 01:30:00', '2022-01-03 02:30:00', '01:30:00', '02:30:00', 'RAE 1517', 'yuni test', 43211, 43211, 0, '2021-12-23 15:34:07', 0),
('000037', 'KEV001', '2022-02-08 14:18:00', '2022-02-08 17:18:00', '14:18:00', '17:18:00', 'VBJ 2174', 'Pergi Maybank seksyen9 bangi', 77969, 77969, 1, '2022-02-07 14:37:27', 0),
('000038', 'KEV001', '2022-02-09 17:00:00', '2022-02-11 17:00:00', '17:00:00', '17:00:00', 'RAE 1517', 'test', 43211, 43211, 0, '2022-02-09 10:07:28', 0),
('000039', 'KEV001', '2022-02-12 17:00:00', '2022-02-13 17:00:00', '17:00:00', '17:00:00', 'VBJ 2174', 'test', 77969, 77969, 0, '2022-02-09 10:07:59', 0),
('000040', 'KEV001', '2022-02-22 17:00:00', '2022-02-24 17:00:00', '17:00:00', '17:00:00', 'RAE 1517', 'test', 43211, 43211, 0, '2022-02-09 10:09:01', 0),
('000041', 'KEV001', '2022-02-26 17:00:00', '2022-02-28 17:00:00', '17:00:00', '17:00:00', 'RAE 1517', 'test', 43211, 43211, 0, '2022-02-09 10:10:00', 1),
('000042', 'KEV001', '2022-02-18 17:00:00', '2022-02-18 18:00:00', '17:00:00', '18:00:00', 'VBJ 2174', 'pergi hospital', 77969, 77969, 1, '2022-02-17 12:03:27', 0),
('111999', 'KEV001', '2021-10-15 00:00:00', '2021-10-17 00:00:00', '14:00:00', '16:00:00', 'WWW7777', 'bookdesc - cancel due to record manually key in thru terminal ', 100, 100, 2, '2021-09-15 17:34:15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `car_master`
--

CREATE TABLE `car_master` (
  `car_no` varchar(10) NOT NULL,
  `car_name` varchar(10) DEFAULT NULL,
  `car_total_mileage` int(11) DEFAULT NULL,
  `car_next_date_service` date DEFAULT NULL,
  `car_next_mileage_service` int(11) NOT NULL,
  `car_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_master`
--

INSERT INTO `car_master` (`car_no`, `car_name`, `car_total_mileage`, `car_next_date_service`, `car_next_mileage_service`, `car_status`) VALUES
('BMW1111', 'BMW3', 1000, '2021-09-06', 100000, 2),
('RAE 1517', 'BEZZA', 43211, '2022-02-04', 48210, 1),
('VBJ 2174', 'MYVI', 77969, '2022-09-09', 78740, 1),
('VEE 2989', 'NAVARA MNB', 173000, '2022-02-02', 178294, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reference_master`
--

CREATE TABLE `reference_master` (
  `ref_type` varchar(15) NOT NULL,
  `ref_seq_no` int(6) UNSIGNED ZEROFILL NOT NULL,
  `ref_code` varchar(5) NOT NULL,
  `ref_desc` varchar(255) NOT NULL,
  `ref_status` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reference_master`
--

INSERT INTO `reference_master` (`ref_type`, `ref_seq_no`, `ref_code`, `ref_desc`, `ref_status`) VALUES
('AUDIT TRAIL', 000022, 'AB', 'Approved Booking', '1'),
('AUDIT TRAIL', 000001, 'CB', 'Cancel Booking', '1'),
('AUDIT TRAIL', 000010, 'CP', 'Change Password', '1'),
('AUDIT TRAIL', 000009, 'CS', 'Car Service', '1'),
('AUDIT TRAIL', 000004, 'EB', 'Edit Booking', '1'),
('AUDIT TRAIL', 000043, 'NB', 'New Booking', '1'),
('AUDIT TRAIL', 000022, 'NR', 'New Registered Staff', '1'),
('AUDIT TRAIL', 000012, 'PK', 'Pass Car Key', '1'),
('AUDIT TRAIL', 000009, 'RK', 'Return Car Key', '1'),
('AUDIT TRAIL', 000009, 'TM', 'Total Mileage', '1'),
('BOOKING MASTER', 000043, 'BK', 'Booking ID Created', '1'),
('BOOKING STATUS', 000001, '0', 'In Process', '1'),
('BOOKING STATUS', 000001, '1', 'Approved', '1'),
('BOOKING STATUS', 000001, '2', 'Cancelled', '1'),
('BOOKING STATUS', 000001, '3', 'Pass Key', '1'),
('BOOKING STATUS', 000001, '4', 'Return Key', '1'),
('STAFF CATEGORY', 000001, '1', 'User', '1'),
('STAFF CATEGORY', 000001, '2', 'Admin-To Approve', '1'),
('STAFF CATEGORY', 000001, '3', 'Admin-Pass And Return Key', '1'),
('STAFF STATUS', 000001, '1', 'Permanent Staff ', '1'),
('STAFF STATUS', 000001, '2', 'Contract Staff', '1'),
('STAFF STATUS', 000001, '3', 'Pekerja Sambilan Harian (PSH)', '1'),
('STAFF STATUS', 000001, '4', 'Intern', '1'),
('STAFF STATUS', 000001, '5', 'Terminate Staff', '1');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` varchar(6) NOT NULL,
  `staff_pwd` varchar(255) NOT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `staff_shortname` varchar(10) DEFAULT NULL,
  `staff_email` varchar(255) DEFAULT NULL,
  `staff_status` int(1) DEFAULT NULL,
  `staff_category` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_pwd`, `staff_name`, `staff_shortname`, `staff_email`, `staff_status`, `staff_category`) VALUES
('IP013', '677474622de5871fd6339afb050dbf10', 'Dilla', 'Dilla', 'nurfadhillah@ipfokus.com', 1, 1),
('KEV001', '6239a8e4b9995538816b5f304d002b3c', 'Mahfida Mahzan', 'Mahfida', 'mahfida.mahzan@gmail.com', 1, 2),
('KEV002', '6239a8e4b9995538816b5f304d002b3c', 'Aida Mininda', 'Aida Minin', 'aida@gmail.com', 1, 1),
('KEV003', '5f9fab5778b2356dc2c1f9a19d0980ed', 'KEV003', 'KEV003', 'kev003@gmail.com', 1, 3),
('KEV011', '6b9d6ba55e4f27b1eb5ab5ca05d160a4', 'YUNI ZAHARA BINTI YUNAIDI', 'YUNI ZAHAR', 'yuni.zhry@gmail.com', 1, 2),
('KEV012', '30d7ca224403a08b81244212b4efbf73', 'AIMI NADIRAH BINTI AZIZ', 'AIMI NADIR', 'aimi@ipfokus.com', 1, 3),
('KEV014', '6b9d6ba55e4f27b1eb5ab5ca05d160a4', 'YUNI TEST 1.0', 'YUNI TEST ', 'misssera0307@gmail.com', 1, 3),
('KEV024', 'e2f52944dc73154785fc8c9042e27ff2', 'NUR AIN BINTI HAZMI', 'NUR AIN BI', 'ainhazmi.kev@gmail.com', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD UNIQUE KEY `unique_atcode_attime` (`at_code`,`at_time`);

--
-- Indexes for table `booking_master`
--
ALTER TABLE `booking_master`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `book_id` (`book_id`);

--
-- Indexes for table `car_master`
--
ALTER TABLE `car_master`
  ADD PRIMARY KEY (`car_no`),
  ADD UNIQUE KEY `car_no` (`car_no`);

--
-- Indexes for table `reference_master`
--
ALTER TABLE `reference_master`
  ADD UNIQUE KEY `unique_reftype_refcode` (`ref_type`,`ref_code`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `staff_email` (`staff_email`);
ALTER TABLE `staff` ADD FULLTEXT KEY `staff_pwd` (`staff_pwd`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
