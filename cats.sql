-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 20 2023 г., 13:21
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cats`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cats`
--

CREATE TABLE `cats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `breed` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `photo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cats`
--

INSERT INTO `cats` (`id`, `name`, `birthdate`, `breed`, `color`, `photo`) VALUES
(20, 'барсик', '2023-04-19', 'британский', 'черный', 'img/644111c2673f0.jpg'),
(21, 'Рыжик', '2022-09-09', 'дворовый', 'белый', 'img/64411211a9266.jpg'),
(22, 'Мурка', '2022-02-01', 'британский', 'серый', 'img/64411235d3d6e.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cats`
--
ALTER TABLE `cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
