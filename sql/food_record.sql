-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-12-04 20:09:33
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `healthylife`
--

-- --------------------------------------------------------

--
-- 資料表結構 `food_record`
--

CREATE TABLE `food_record` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `calories` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time_period` varchar(255) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `food_record`
--

INSERT INTO `food_record` (`id`, `name`, `calories`, `date`, `time_period`, `users_id`) VALUES
(1, '喝水', 0, '2023-12-05', '點心時刻', 1),
(2, '無糖可樂', 0, '2023-12-05', '點心時刻', 1),
(3, '喝茶', 0, '2023-12-05', '點心時刻', 1),
(4, '喝可樂0的', 0, '2023-12-05', '點心時刻', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `food_record`
--
ALTER TABLE `food_record`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `food_record`
--
ALTER TABLE `food_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
