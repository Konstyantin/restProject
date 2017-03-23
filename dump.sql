-- --------------------------------------------------------
-- Хост:                         dcodeit.net
-- Версия сервера:               10.1.21-MariaDB - MariaDB Server
-- Операционная система:         Linux
-- HeidiSQL Версия:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных kostya.nagula
CREATE DATABASE IF NOT EXISTS `kostya.nagula` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `kostya.nagula`;

-- Дамп структуры для таблица kostya.nagula.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(45) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы kostya.nagula.post: ~72 rows (приблизительно)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`id`, `title`, `content`, `author`, `created_at`) VALUES
	(30, 'test', 'new content for update post', 'author', 1489760686),
	(31, 'new title for update  post', 'new content for update post', 'author', 1489761133),
	(33, 'update title', 'update content', 'author', 1490019426),
	(34, 'test title', 'new content for update post', 'author', 1490020443),
	(35, 'test title', 'new content for update post', 'author', 1490020571),
	(36, 'test title', 'new content for update post', 'author', 1490020611),
	(37, 'test title', 'new content for update post', 'author', 1490020692),
	(38, 'test title', 'new content for update post', 'author', 1490021636),
	(39, 'test titlassadasde', 'new content for update posasdasdasdt', '1', 1490027518),
	(40, 'content title', 'post contant', '1', 1490028210),
	(41, 'content title', 'post contant', '1', 1490028265),
	(42, 'content title', 'post contant', '1', 1490028326),
	(43, 'content title', 'post contant', '1', 1490028347),
	(44, 'content title', 'post contant', '1', 1490028460),
	(45, 'new title for update  post', 'new content for update post', '1', 1490028754),
	(46, 'new title for update  post', 'new content for update post', '1', 1490028994),
	(47, 'new title for update  post', 'new content for update post', '1', 1490081170),
	(49, 'update title', 'update content', '1', 1490081628),
	(50, 'update title', 'update content', '1', 1490087612),
	(51, 'curl title update', 'curl content update', '1', 1490089739),
	(52, 'update title', 'update content', '1', 1490090641),
	(53, 'curl title update', 'curl content update', '1', 1490090662),
	(55, 'curl test title', 'curl test content', '1', 1490098424),
	(60, 'curl testasdasd title', 'curl testasdsa content', '1', 1490099862),
	(61, 'curl testasdasd title', 'curl testasdsa content', '1', 1490099868),
	(62, 'curl testasdasd title', 'curl testasdsa content', '1', 1490099967),
	(63, 'curl testasdasd title', 'curl testasdsa content', '1', 1490099968),
	(64, 'curl testasdasd title', 'curl testasdsa content', '1', 1490100014),
	(65, 'curl update title', 'curl update content', '1', 1490100015),
	(67, 'curl update title', 'curl update content', '1', 1490110745),
	(68, 'curl update title', 'curl update content', '1', 1490111083),
	(69, 'update title', 'update content', '1', 1490172533),
	(70, 'update title', 'update content', '1', 1490172556),
	(71, 'update title', 'update content', '1', 1490172578),
	(72, 'update title', 'update content', '1', 1490172816),
	(73, 'update title', 'update content', '1', 1490173272),
	(74, 'curl title', 'curl content', '1', 1490173403),
	(75, 'curl update title', 'curl update content', '1', 1490173421),
	(76, 'curl update title', 'curl update content', '1', 1490175284),
	(77, 'curl title', 'curl content', '1', 1490175376),
	(78, 'curl update title', 'curl update content', '1', 1490176564),
	(79, 'curl update title', 'curl update content', '1', 1490176570),
	(80, 'curl update title', 'curl update content', '1', 1490180875),
	(81, 'curl update title', 'curl update content', '1', 1490180875),
	(82, 'curl update title', 'curl update content', '1', 1490180889),
	(83, 'curl update title', 'curl update content', '1', 1490180889),
	(84, 'curl update title', 'curl update content', '1', 1490180896),
	(85, 'curl update title', 'curl update content', '1', 1490180896),
	(86, 'curl update title', 'curl update content', '1', 1490180901),
	(87, 'curl update title', 'curl update content', '1', 1490180901),
	(88, 'curl update title', 'curl update content', '1', 1490180909),
	(89, 'curl update title', 'curl update content', '1', 1490180909),
	(90, 'curl update title', 'curl update content', '1', 1490180986),
	(91, 'curl update title', 'curl update content', '1', 1490180986),
	(92, 'curl update title', 'curl update content', '1', 1490180993),
	(93, 'curl update title', 'curl update content', '1', 1490180993),
	(95, 'update title', 'update content', '1', 1490181081),
	(96, 'curl update title', 'curl update content', '1', 1490181139),
	(97, 'curl update title', 'curl update content', '1', 1490181618),
	(98, 'curl update title', 'curl update content', '1', 1490181631),
	(100, 'update title', 'update content', '1', 1490266976),
	(102, 'update title test update', 'update content', '1', 1490268726),
	(104, 'curl update title', 'curl update content', '1', 1490270957),
	(105, 'curl update title', 'curl update content', '1', 1490270975),
	(106, 'update title test updaasdte', 'update contadsent', '1', 1490271460),
	(108, 'curl update title', 'curl update content', '1', 1490271533),
	(109, 'curl update title', 'curl update content', '1', 1490271546),
	(110, 'curl update title', 'curl update content', '1', 1490271553),
	(111, 'curl update title', 'curl update content', '1', 1490271558),
	(112, 'curl update title', 'curl update content', '1', 1490271599),
	(113, 'curl update title', 'curl update content', '1', 1490271605),
	(114, 'curl update title', 'curl update content', '1', 1490271612);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Дамп структуры для таблица kostya.nagula.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `token` varchar(45) NOT NULL,
  `token_expire` int(11) NOT NULL DEFAULT '3600',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Индекс 2` (`username`),
  KEY `user__token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы kostya.nagula.user: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`, `name`, `token`, `token_expire`) VALUES
	(1, 'kostya', '123456789q', 'kostya', 'eyJpZCI6MSwidGltZSI6MTQ5MDI3MDg5Mn0=', 3600);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
