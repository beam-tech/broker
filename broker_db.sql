-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 05 2016 г., 01:08
-- Версия сервера: 5.5.47
-- Версия PHP: 5.6.20-1+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `broker_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_money` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `bank`
--

INSERT INTO `bank` (`id`, `user_id`, `user_money`) VALUES
(1, 1, 300.00);

-- --------------------------------------------------------

--
-- Структура таблицы `bank_offer`
--

CREATE TABLE IF NOT EXISTS `bank_offer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contents` varchar(255) NOT NULL DEFAULT '',
  `offer_percent` int(3) NOT NULL DEFAULT '0',
  `offer` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `bank_user_offer`
--

CREATE TABLE IF NOT EXISTS `bank_user_offer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `offer_id` int(11) NOT NULL DEFAULT '0',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `status` varchar(40) NOT NULL DEFAULT '',
  `dividends` decimal(11,2) NOT NULL DEFAULT '0.00',
  `total_share_cnt` int(11) NOT NULL DEFAULT '0',
  `share_cnt` int(11) NOT NULL DEFAULT '0',
  `share_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `img` varchar(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `company`
--

INSERT INTO `company` (`id`, `name`, `status`, `dividends`, `total_share_cnt`, `share_cnt`, `share_price`, `img`) VALUES
(4, 'Google inc.', 'worked', 7.90, 12000, 11977, 97.86, 'google.jpeg'),
(6, 'Microsoft Corporation', 'worked', 5.50, 10000, 9996, 89.34, 'ms.jpeg'),
(11, 'The Coca-Cola Company', 'worked', 4.20, 10700, 10690, 83.87, 'coca_cola.jpeg'),
(12, 'Mail.Ru Group', 'worked', 1.20, 9000, 9000, 21.00, 'mail.jpeg'),
(13, 'IBM', 'worked', 6.70, 10000, 10000, 120.00, 'ibm.jpeg'),
(14, 'PepsiCo', 'worked', 2.70, 15000, 14976, 71.80, 'pepsi.jpeg');

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `msg` text,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `feedback`
--

INSERT INTO `feedback` (`id`, `msg`) VALUES
(1, 'it''s work!');

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL DEFAULT '',
  `effect` varchar(25) NOT NULL DEFAULT '',
  `cash` decimal(11,2) NOT NULL DEFAULT '0.00',
  `health` int(3) NOT NULL DEFAULT '0',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `name`, `effect`, `cash`, `health`, `price`) VALUES
(1, 'Arrow', 'negative', 200.05, 7, 1000.00),
(2, 'Potion#1', 'positive', 0.00, 5, 1000.00),
(3, 'Axe', 'negative', 300.00, 13, 1500.00),
(4, 'Potion#2', 'positive', 0.00, 10, 2100.00),
(5, 'Hammer', 'negative', 700.00, 18, 5000.00),
(6, 'Potion#3', 'positive', 0.00, 14, 4100.00);

-- --------------------------------------------------------

--
-- Структура таблицы `msgs`
--

CREATE TABLE IF NOT EXISTS `msgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL DEFAULT '',
  `msg` text,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `msgs`
--

INSERT INTO `msgs` (`id`, `name`, `msg`, `datetime`) VALUES
(1, 'rubberfox', 'hi!', '2016-04-05 00:04:06'),
(2, 'rubberfox', 'whatsapp?', '2016-04-05 00:39:40');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(11) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `salt` varchar(40) NOT NULL DEFAULT '',
  `role` varchar(11) NOT NULL DEFAULT '',
  `email` varchar(40) NOT NULL DEFAULT '',
  `health` int(3) NOT NULL DEFAULT '100',
  `cash` decimal(11,2) NOT NULL DEFAULT '100000.00',
  `status` varchar(40) NOT NULL DEFAULT 'living',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `salt`, `role`, `email`, `health`, `cash`, `status`, `datetime`) VALUES
(1, 'rubberfox', 'a33a141de01c98a6c9b41f11dfa02cf51a4ee9e8', 'zBjNThkODcw', 'user', 'root@root.com', 93, 1093359.95, 'living', '2016-04-05 00:40:15');

-- --------------------------------------------------------

--
-- Структура таблицы `user_company`
--

CREATE TABLE IF NOT EXISTS `user_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '0',
  `share_cnt` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `user_company`
--

INSERT INTO `user_company` (`id`, `user_id`, `company_id`, `share_cnt`) VALUES
(1, 1, 4, 23),
(2, 1, 6, 4),
(3, 1, 11, 10),
(4, 1, 14, 24);

-- --------------------------------------------------------

--
-- Структура таблицы `user_items`
--

CREATE TABLE IF NOT EXISTS `user_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `item_cnt` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bank`
--
ALTER TABLE `bank`
  ADD CONSTRAINT `bank_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_company`
--
ALTER TABLE `user_company`
  ADD CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_items`
--
ALTER TABLE `user_items`
  ADD CONSTRAINT `user_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
