-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 01 2019 г., 19:32
-- Версия сервера: 5.7.28-0ubuntu0.18.04.4
-- Версия PHP: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ray_of_hope`
--
DROP DATABASE IF EXISTS `ray_of_hope`;
CREATE DATABASE IF NOT EXISTS `ray_of_hope` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ray_of_hope`;

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`ray_of_hope`@`127.0.0.1` PROCEDURE `authorization_civilian` (IN `in_login` VARCHAR(255), IN `in_password` VARCHAR(255))  NO SQL
BEGIN
SET @is_succes = (SELECT EXISTS(SELECT email.id FROM email JOIN user on email.id = user.email WHERE email.email = in_login AND password = in_password));
IF @is_succes = 0 THEN
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Неверно введен логин или пароль';
END IF;
END$$

CREATE DEFINER=`ray_of_hope`@`127.0.0.1` PROCEDURE `authorization_organization` (IN `in_login` VARCHAR(255), IN `in_password` VARCHAR(255), IN `login_is_INN` BINARY)  NO SQL
BEGIN
IF login_is_INN = 1 THEN
SET @is_succes = (SELECT EXISTS(SELECT organization.user_id FROM organization JOIN user on organization.user_id = user.id WHERE INN = in_login AND password = in_password));
IF @is_succes = 0 THEN
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Неверно введен логин или пароль';
END IF;
ELSE
SET @is_succes = (SELECT EXISTS(SELECT email.id FROM email JOIN user on email.id = user.email WHERE email.email = in_login AND password = in_password));
IF @is_succes = 0 THEN
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Неверно введен логин или пароль';
END IF;
END IF;
END$$

CREATE DEFINER=`ray_of_hope`@`127.0.0.1` PROCEDURE `create_event` (IN `in_author` VARCHAR(255), IN `in_publication_date` DATE, IN `in_description` VARCHAR(255), IN `in_applications` VARCHAR(255), IN `in_start_date` DATE, IN `in_end_date` DATE, IN `in_address` VARCHAR(255))  NO SQL
    DETERMINISTIC
BEGIN
SET @author = (SELECT user.id FROM user JOIN email on user.email=email.id WHERE email.email = in_author);
IF @author IS NULL THEN
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Данный пользователь не существует';
END IF;
SET @id_note = (SELECT count(*)+1 from note);
INSERT INTO note(id, author, publication_date, description, applications, type_note) VALUES (@id_note, @author, in_publication_date, in_description, in_applications, 1);
SET @id_event = (SELECT count(*)+1 from event);
INSERT INTO event(id, note, start_date, end_date, address) VALUES (@id_event, @id_note, in_start_date, in_end_date, in_address);
END$$

CREATE DEFINER=`ray_of_hope`@`127.0.0.1` PROCEDURE `create_need` (IN `in_author` VARCHAR(255), IN `in_publication_date` DATE, IN `in_description` VARCHAR(255), IN `in_applications` VARCHAR(255), IN `in_need_items` VARCHAR(255), IN `in_need_count` INT(11), IN `in_collected_count` INT(11))  NO SQL
BEGIN
SET @author = (SELECT user.id FROM user JOIN email on user.email=email.id WHERE email.email = in_author);
IF @author IS NULL THEN
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Данный пользователь не существует';
END IF;
SET @id_note = (SELECT count(*)+1 from note);
INSERT INTO note(id, author, publication_date, description, applications, type_note) VALUES (@id_note, @author, in_publication_date, in_description, in_applications, 2);
SET @id_event = (SELECT count(*)+1 from event);
INSERT INTO need(id, note, need_items, need_count, collected_count) VALUES (@id_event, @id_note, in_need_items, in_need_count, in_collected_count);
END$$

CREATE DEFINER=`ray_of_hope`@`127.0.0.1` PROCEDURE `create_note` (IN `in_author` VARCHAR(255), IN `in_publication_date` VARCHAR(255), IN `in_description` VARCHAR(255), IN `in_applications` VARCHAR(255))  NO SQL
BEGIN
SET @author = (SELECT user.id FROM user JOIN email on user.email=email.id WHERE email.email = in_author);
IF @author IS NULL THEN
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Данный пользователь не существует';
END IF;
SET @id_note = (SELECT count(*)+1 from note);
INSERT INTO note(id, author, publication_date, description, applications, type_note) VALUES (@id_note, @author, in_publication_date, in_description, in_applications, 3);
END$$

CREATE DEFINER=`ray_of_hope`@`127.0.0.1` PROCEDURE `registration_civilian` (IN `in_name` VARCHAR(255), IN `in_subname` VARCHAR(255), IN `in_email` VARCHAR(255), IN `in_password` VARCHAR(255), IN `in_hash` VARCHAR(255))  NO SQL
BEGIN
	SET @check_email =(SELECT EXISTS(SELECT email.email FROM email 		WHERE email.email = in_email));
	IF @check_email = 1 THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Гражданин с таким email уже зарегистрирован';
      END IF;
    
	SET @id_email = (SELECT max(id)+1 FROM email);
	INSERT INTO email (id, email, hash) VALUES(@id_email, in_email, in_hash);
    
	SET @type_of_account = (SELECT id FROM type_account WHERE name = 'Гражданин');

	SET @id_user = (SELECT max(id)+1 FROM user);
	INSERT INTO user (id, type_of_account, email, password) VALUES (@id_user, @type_of_account, @id_email, in_password);
             

	INSERT INTO civilian (user, subname, name) VALUES (@id_user, in_name, in_subname);
END$$

CREATE DEFINER=`ray_of_hope`@`127.0.0.1` PROCEDURE `registration_organization` (IN `in_INN` VARCHAR(10), IN `in_name` VARCHAR(255), IN `in_email` VARCHAR(255), IN `in_hash` VARCHAR(255), IN `in_password` VARCHAR(255))  MODIFIES SQL DATA
BEGIN
	SET @check_email =(SELECT EXISTS(SELECT email.email FROM email 		WHERE email.email = in_email));
	IF @check_email = 1 THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Организация с таким email уже зарегистрирована';
      END IF;

	SET @check_inn = (SELECT EXISTS(SELECT organization.INN FROM 		organization WHERE organization.INN=in_INN));
	IF @check_inn = 1 THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Организация с таким INN уже зарегистрирована';
    END IF;
    
	SET @id_email = (SELECT max(id)+1 FROM email);
	INSERT INTO email (id, email, hash) VALUES(@id_email, in_email, in_hash);
    
	SET @type_of_account = (SELECT id FROM type_account WHERE name = 'Организация');

	SET @id_user = (SELECT max(id)+1 FROM user);
	INSERT INTO user (id, type_of_account, email, password) VALUES (@id_user, @type_of_account, @id_email, in_password);
             

	INSERT INTO organization (user_id, INN, name) VALUES (@id_user, in_INN, in_name);
END$$

--
-- Функции
--
CREATE DEFINER=`ray_of_hope`@`127.0.0.1` FUNCTION `checkINN` (`inINN` VARCHAR(10)) RETURNS INT(11) READS SQL DATA
BEGIN
DECLARE my_inn varchar(10) default NULL;
SELECT INN INTO my_inn FROM organization WHERE organization.INN=inINN;
IF my_inn is NULL THEN
RETURN true;
ELSE
RETURN false;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `Logs`
--

CREATE TABLE `Logs` (
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

CREATE TABLE `city` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `civilian`
--

CREATE TABLE `civilian` (
  `user` int(10) UNSIGNED NOT NULL,
  `city` int(10) UNSIGNED DEFAULT NULL,
  `subname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `second name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Триггеры `civilian`
--
DELIMITER $$
CREATE TRIGGER `delete_civilian` AFTER DELETE ON `civilian` FOR EACH ROW BEGIN
SET @user = (SELECT email FROM (SELECT user.id, email.email FROM user JOIN email WHERE user.email =  email.id) as user_email WHERE user_email.id = OLD.user);
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), @user, 'Удаление записи из таблицы civilian');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_civilian` BEFORE INSERT ON `civilian` FOR EACH ROW BEGIN
SET @user = (SELECT email FROM (SELECT user.id, email.email FROM user JOIN email WHERE user.email =  email.id) as user_email WHERE user_email.id = NEW.user);
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), @user, 'Добавление записи в таблицу civilian');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_civilian` BEFORE UPDATE ON `civilian` FOR EACH ROW BEGIN
SET @user = (SELECT email FROM (SELECT user.id, email.email FROM user JOIN email WHERE user.email =  email.id) as user_email WHERE user_email.id = NEW.user);
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), @user, 'Изменение записи в таблице update_civilian');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE `comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `author` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Триггеры `comment`
--
DELIMITER $$
CREATE TRIGGER `delete_comment` AFTER DELETE ON `comment` FOR EACH ROW BEGIN
SET @user = (SELECT email FROM (SELECT user.id, email.email FROM user JOIN email WHERE user.email =  email.id) as user_email WHERE user_email.id = OLD.author);
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), @user, 'Удаление записи из таблицы comment');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_comment` BEFORE INSERT ON `comment` FOR EACH ROW BEGIN
SET @user = (SELECT email FROM (SELECT user.id, email.email FROM user JOIN email WHERE user.email =  email.id) as user_email WHERE user_email.id = NEW.author);
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), @user, 'Добавление записи в таблицу comment');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_comment` BEFORE UPDATE ON `comment` FOR EACH ROW BEGIN
SET @user = (SELECT email FROM (SELECT user.id, email.email FROM user JOIN email WHERE user.email =  email.id) as user_email WHERE user_email.id = NEW.author);
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), @user, 'Изменение записи в таблице comment');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `email`
--

CREATE TABLE `email` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Триггеры `email`
--
DELIMITER $$
CREATE TRIGGER `delete_email` BEFORE DELETE ON `email` FOR EACH ROW BEGIN
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), OLD.email, 'Удаление записи из таблицы email');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_email` BEFORE INSERT ON `email` FOR EACH ROW BEGIN
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), NEW.email, 'Добавление записи в таблицу email');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_email` BEFORE UPDATE ON `email` FOR EACH ROW BEGIN
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), NEW.email, 'Изменение записи в таблице email');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE `event` (
  `id` int(11) UNSIGNED NOT NULL,
  `note` int(11) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `address` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `favorite_organization`
--

CREATE TABLE `favorite_organization` (
  `organization` int(11) UNSIGNED NOT NULL,
  `civilian` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `markers`
--

CREATE TABLE `markers` (
  `note` int(11) UNSIGNED NOT NULL,
  `user` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `members`
--

CREATE TABLE `members` (
  `civilian` int(11) UNSIGNED NOT NULL,
  `event` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `need`
--

CREATE TABLE `need` (
  `id` int(10) UNSIGNED NOT NULL,
  `note` int(11) UNSIGNED NOT NULL,
  `need_items` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `need_count` int(11) NOT NULL,
  `collected_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `note`
--

CREATE TABLE `note` (
  `id` int(11) UNSIGNED NOT NULL,
  `author` int(11) UNSIGNED NOT NULL,
  `publication_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applications` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_note` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Триггеры `note`
--
DELIMITER $$
CREATE TRIGGER `delete_note` AFTER DELETE ON `note` FOR EACH ROW BEGIN
SET @author = (SELECT email.email FROM user JOIN email on user.email=email.id WHERE user.id = OLD.author);
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), @author, 'Удаление записи из таблицы note');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_note` BEFORE INSERT ON `note` FOR EACH ROW BEGIN
SET @author = (SELECT email.email FROM user JOIN email on user.email=email.id WHERE user.id = NEW.author);
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), @author, 'Добавление записи в таблицу note');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_note` BEFORE UPDATE ON `note` FOR EACH ROW BEGIN
SET @author = (SELECT email.email FROM user JOIN email on user.email=email.id WHERE user.id = NEW.author);
INSERT into Logs (date, user, comment)
VALUES (CURRENT_TIMESTAMP(), @author, 'Обновление записи в таблице note');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `organization`
--

CREATE TABLE `organization` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `INN` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number_phone` int(11) DEFAULT NULL,
  `city` int(10) UNSIGNED DEFAULT NULL,
  `type_of_activity` int(11) UNSIGNED DEFAULT NULL,
  `docs` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_information`
--

CREATE TABLE `payment_information` (
  `organization` int(10) UNSIGNED NOT NULL,
  `OGRN` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `R/SCH` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Cor_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `BIK` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `region`
--

CREATE TABLE `region` (
  `code` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `token`
--

CREATE TABLE `token` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valid_until` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `type_account`
--

CREATE TABLE `type_account` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `type_note`
--

CREATE TABLE `type_note` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `type_of_activity`
--

CREATE TABLE `type_of_activity` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `type_of_account` int(11) UNSIGNED NOT NULL,
  `avatar` int(11) UNSIGNED DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` int(11) UNSIGNED NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region` (`region`);

--
-- Индексы таблицы `civilian`
--
ALTER TABLE `civilian`
  ADD KEY `city` (`city`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`author`);

--
-- Индексы таблицы `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address` (`address`),
  ADD KEY `note` (`note`);

--
-- Индексы таблицы `favorite_organization`
--
ALTER TABLE `favorite_organization`
  ADD KEY `organization` (`organization`),
  ADD KEY `user` (`civilian`);

--
-- Индексы таблицы `markers`
--
ALTER TABLE `markers`
  ADD KEY `note` (`note`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `members`
--
ALTER TABLE `members`
  ADD KEY `civilian` (`civilian`),
  ADD KEY `event` (`event`);

--
-- Индексы таблицы `need`
--
ALTER TABLE `need`
  ADD PRIMARY KEY (`id`),
  ADD KEY `note` (`note`);

--
-- Индексы таблицы `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_note` (`type_note`),
  ADD KEY `author` (`author`);

--
-- Индексы таблицы `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `INN` (`INN`),
  ADD KEY `address` (`address`),
  ADD KEY `organization_ibfk_3` (`city`),
  ADD KEY `type of activity` (`type_of_activity`);

--
-- Индексы таблицы `payment_information`
--
ALTER TABLE `payment_information`
  ADD PRIMARY KEY (`organization`);

--
-- Индексы таблицы `region`
--
ALTER TABLE `region`
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Индексы таблицы `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `type_account`
--
ALTER TABLE `type_account`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `type_note`
--
ALTER TABLE `type_note`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `type_of_activity`
--
ALTER TABLE `type_of_activity`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `type of account` (`type_of_account`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `city`
--
ALTER TABLE `city`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `email`
--
ALTER TABLE `email`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `need`
--
ALTER TABLE `need`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `token`
--
ALTER TABLE `token`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `type_account`
--
ALTER TABLE `type_account`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `type_note`
--
ALTER TABLE `type_note`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `type_of_activity`
--
ALTER TABLE `type_of_activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`region`) REFERENCES `region` (`code`);

--
-- Ограничения внешнего ключа таблицы `civilian`
--
ALTER TABLE `civilian`
  ADD CONSTRAINT `civilian_ibfk_1` FOREIGN KEY (`city`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `civilian_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`note`) REFERENCES `note` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `favorite_organization`
--
ALTER TABLE `favorite_organization`
  ADD CONSTRAINT `favorite_organization_ibfk_1` FOREIGN KEY (`organization`) REFERENCES `organization` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorite_organization_ibfk_2` FOREIGN KEY (`civilian`) REFERENCES `civilian` (`user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `markers`
--
ALTER TABLE `markers`
  ADD CONSTRAINT `markers_ibfk_1` FOREIGN KEY (`note`) REFERENCES `note` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `markers_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`civilian`) REFERENCES `civilian` (`user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `members_ibfk_2` FOREIGN KEY (`event`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `need`
--
ALTER TABLE `need`
  ADD CONSTRAINT `need_ibfk_1` FOREIGN KEY (`note`) REFERENCES `note` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`type_note`) REFERENCES `type_note` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `organization_ibfk_3` FOREIGN KEY (`city`) REFERENCES `city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `organization_ibfk_4` FOREIGN KEY (`type_of_activity`) REFERENCES `type_of_activity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `payment_information`
--
ALTER TABLE `payment_information`
  ADD CONSTRAINT `payment_information_ibfk_1` FOREIGN KEY (`organization`) REFERENCES `organization` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`email`) REFERENCES `email` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`type_of_account`) REFERENCES `type_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
