-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) unsigned NOT NULL,
  `course_id` int(4) NOT NULL,
  `comment_content` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_ibfk_4` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `comments` (`id`, `user_id`, `course_id`, `comment_content`, `created_at`) VALUES
(3,	2,	8,	'eeeee',	'2018-02-24 14:38:28');

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) unsigned NOT NULL,
  `title` char(100) NOT NULL,
  `duration` int(4) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `attachment` text,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `courses_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `courses` (`id`, `user_id`, `title`, `duration`, `description`, `content`, `attachment`, `created_at`) VALUES
(8,	2,	'test',	2,	'SDASD',	'<p>&nbsp;</p>',	NULL,	'2018-02-24 11:09:32'),
(9,	5,	'Hello',	2,	'asdasd',	'<p>asdasdva</p>',	NULL,	'2018-02-24 12:22:21');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(5) NOT NULL,
  `name` char(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles` (`id`, `code`, `name`, `description`) VALUES
(1,	'adm',	'admin',	'Ini role untuk admin'),
(2,	'dsn',	'dosen',	'Ini role untuk dosen'),
(3,	'mhs',	'mahasiswa',	'Ini role untuk mahasiswa');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `email` char(50) NOT NULL,
  `password` char(100) NOT NULL,
  `name` char(50) NOT NULL,
  `address` text NOT NULL,
  `role_id` int(11) NOT NULL,
  `register_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `email`, `password`, `name`, `address`, `role_id`, `register_at`) VALUES
(1,	'muhamadismuaji@gmail.com',	'4fc8ab89e59242c081c2d8ba2e57b026',	'Muhamad Ismuaji Prajitno',	'Balongbendo Sidoarjo',	1,	'2018-02-23 09:23:28'),
(2,	'dosen@gmail.com',	'ce28eed1511f631af6b2a7bb0a85d636',	'Ir. Sugiono M.T.',	'Regency Kuda Dua',	2,	'2018-02-23 09:23:28'),
(3,	'mhs@gmail.com',	'5787be38ee03a9ae5360f54d9026465f',	'Bagong Suprayogi',	'Ini alamatnya bagong',	3,	'2018-02-23 09:23:28'),
(5,	'dosen2@gmail.com',	'ac41c4e0e6ef7ac51f0c8f3895f82ce5',	'Dosen 2',	'',	2,	'2018-02-24 00:44:36'),
(6,	'mhs2@gmail.com',	'41f1b79f6392e10a3c4bd10272576826',	'Mahasiswa 2',	'',	3,	'2018-02-24 00:46:40'),
(7,	'mhs3@gmail.com',	'27971e2ff09a704920d692798c092edc',	'Mahasiswa 3',	'',	3,	'2018-02-24 00:49:04'),
(8,	'bagong@admin.com',	'62ec80a7b96fbbe92406046c3ff96b6b',	'Bagong',	'',	3,	'2018-02-24 09:17:46');

-- 2018-02-24 07:38:49