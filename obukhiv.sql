-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Гру 22 2024 р., 16:13
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `obukhiv`
--

-- --------------------------------------------------------

--
-- Структура таблиці `lines`
--

CREATE TABLE `lines` (
  `id` int(11) NOT NULL,
  `line_number` int(11) NOT NULL,
  `line_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `lines`
--

INSERT INTO `lines` (`id`, `line_number`, `line_description`) VALUES
(1, 1, 'Центральна'),
(2, 2, 'Промзона'),
(3, 3, 'Житлові Південь'),
(4, 4, 'Житлові Південно-Захід');

-- --------------------------------------------------------

--
-- Структура таблиці `line_current_readings`
--

CREATE TABLE `line_current_readings` (
  `id` int(11) NOT NULL,
  `line_id` int(11) NOT NULL,
  `scan_time` datetime NOT NULL,
  `current_strength` float DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `line_current_readings`
--

INSERT INTO `line_current_readings` (`id`, `line_id`, `scan_time`, `current_strength`, `status_id`, `remarks`) VALUES
(17, 1, '2024-12-20 12:00:00', 11, 1, 'Нормальна робота'),
(18, 2, '2024-12-20 12:00:00', 13, 1, 'Нормальна робота'),
(19, 3, '2024-12-20 12:00:00', 14, 1, 'Нормальна робота'),
(20, 4, '2024-12-20 12:00:00', 15, 1, 'Нормальна робота'),
(21, 1, '2024-12-20 13:00:00', 7, 4, 'Нестача'),
(22, 2, '2024-12-20 13:00:00', 6, 4, 'Нестача'),
(23, 3, '2024-12-20 13:00:00', 15, 1, 'Нормальна робота'),
(24, 4, '2024-12-20 13:00:00', 0, 3, 'Розрив'),
(25, 1, '2024-12-20 14:00:00', 22, 2, 'Перевантаження'),
(26, 2, '2024-12-20 14:00:00', 11, 1, 'Нормальна робота'),
(27, 3, '2024-12-20 14:00:00', 12, 1, 'Нормальна робота'),
(28, 4, '2024-12-20 14:00:00', 0, 3, 'Розрив'),
(29, 1, '2024-12-20 15:00:00', 6, 4, 'Нестача'),
(30, 2, '2024-12-20 15:00:00', 6, 4, 'Нестача'),
(31, 3, '2024-12-20 15:00:00', 7, 4, 'Нестача'),
(32, 4, '2024-12-20 15:00:00', 0, 3, 'Розрив'),
(37, 1, '2024-12-20 16:00:00', 2, 4, 'Нестача'),
(38, 2, '2024-12-20 16:00:00', 4, 4, 'Нестача'),
(39, 3, '2024-12-20 16:00:00', 8, 4, 'Нестача'),
(40, 4, '2024-12-20 16:00:00', 10, 1, 'Нормальна робота'),
(43, 1, '2024-12-20 17:00:00', 12, 1, 'Нормальна робота'),
(44, 2, '2024-12-20 17:00:00', 14, 1, 'Нормальна робота'),
(45, 3, '2024-12-20 17:00:00', 15, 1, 'Нормальна робота'),
(46, 4, '2024-12-20 17:00:00', 16, 2, 'Перевантаження'),
(47, 1, '2024-12-20 18:00:00', 22, 2, 'Перевантаження'),
(48, 2, '2024-12-20 18:00:00', 1, 4, 'Нестача'),
(49, 3, '2024-12-20 18:00:00', 0, 3, 'Розрив'),
(50, 4, '2024-12-20 18:00:00', 11, 1, 'Нормальна робота'),
(51, 1, '2024-12-20 19:00:00', 11, 1, 'Нормальна робота'),
(52, 2, '2024-12-20 19:00:00', 15.5, 2, 'Перевантаження'),
(53, 3, '2024-12-20 19:00:00', 15, 1, 'Нормальна робота'),
(54, 4, '2024-12-20 19:00:00', 11, 1, 'Нормальна робота');

-- --------------------------------------------------------

--
-- Структура таблиці `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `statuses`
--

INSERT INTO `statuses` (`id`, `status_name`) VALUES
(4, 'Нестача'),
(1, 'Нормальний'),
(2, 'Перевантаження'),
(3, 'Розрив');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `role`) VALUES
(1, '1111', '$2y$10$8p/xvsVsG9coQZSP43Hm6OKV1MGrfit0MkwK1Lr0qiLlPG/9U8LPi', 'user'),
(5, '3', '$2y$10$SmDhMJYlzK5HmX2kj78g5uWYidV9RbImmXnsopaUxY9AfursmnbCK', 'admin'),
(11, '2', '$2y$10$RLiulJNS8ZCmIm6yNI2QtuDqGY3jmjGRweiNg5p.OsYdw3xTwCI9W', 'user'),
(14, '4', '$2y$10$jlWRHFEU2qHhhMukZb9ChOEhAHhwNYFYHQa8ksA4afZRzwaVKjfNi', 'user');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `lines`
--
ALTER TABLE `lines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `line_number` (`line_number`);

--
-- Індекси таблиці `line_current_readings`
--
ALTER TABLE `line_current_readings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `line_id` (`line_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Індекси таблиці `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_name` (`status_name`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `lines`
--
ALTER TABLE `lines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `line_current_readings`
--
ALTER TABLE `line_current_readings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT для таблиці `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `line_current_readings`
--
ALTER TABLE `line_current_readings`
  ADD CONSTRAINT `line_current_readings_ibfk_1` FOREIGN KEY (`line_id`) REFERENCES `lines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `line_current_readings_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
