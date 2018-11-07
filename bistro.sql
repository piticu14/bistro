-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.30-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for bistro
CREATE DATABASE IF NOT EXISTS `bistro` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `bistro`;

-- Dumping structure for table bistro.order
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isDelivered` tinyint(1) NOT NULL DEFAULT '0',
  `delivered_at` timestamp NULL DEFAULT NULL,
  `total` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_order_user{01}` (`user_id`),
  CONSTRAINT `FK_order_user{01}` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bistro.order: ~0 rows (approximately)
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;

-- Dumping structure for table bistro.order_item
CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL,
  `price_id` int(11) unsigned NOT NULL,
  `quantity` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_order_item_order{01}` (`order_id`),
  KEY `FK_order_item_price` (`price_id`),
  CONSTRAINT `FK_order_item_order{01}` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  CONSTRAINT `FK_order_item_price` FOREIGN KEY (`price_id`) REFERENCES `price` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bistro.order_item: ~0 rows (approximately)
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;

-- Dumping structure for table bistro.price
CREATE TABLE IF NOT EXISTS `price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `size_id` int(11) unsigned DEFAULT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `price` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_price_product{01}` (`product_id`),
  KEY `FK_price_size{01}` (`size_id`),
  CONSTRAINT `FK_price_product{01}` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_price_size{01}` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bistro.price: ~12 rows (approximately)
/*!40000 ALTER TABLE `price` DISABLE KEYS */;
INSERT INTO `price` (`id`, `size_id`, `product_id`, `price`) VALUES
	(1, 1, 1, 119),
	(2, 2, 1, 199),
	(3, 1, 2, 129),
	(4, 2, 2, 219),
	(5, 1, 3, 139),
	(6, 2, 3, 229),
	(7, 1, 4, 139),
	(8, 2, 4, 229),
	(9, NULL, 5, 149),
	(10, NULL, 6, 159),
	(11, NULL, 7, 169),
	(12, NULL, 8, 199);
/*!40000 ALTER TABLE `price` ENABLE KEYS */;

-- Dumping structure for table bistro.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredients` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bistro.product: ~8 rows (approximately)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `name`, `ingredients`, `type`, `image`) VALUES
	(1, 'Margherita', ' Italská ochucená rajčatová omáčka s bylinkami, sýr mozzarella, bazalka ', 'pizza', 'big-1.jpg'),
	(2, 'Žampionová/ Funghi ', ' Rajčatová om., mozzarella, čerstvé plátky žampionů ', 'pizza', 'big-4.jpg'),
	(3, 'Zeleninová/ Verdure ', 'Rajčatová om., mozzarella, brokolice, černé olivy, kukuřice, paprika, rajčata', 'pizza', 'big-5.jpg'),
	(4, 'S grilovaným lilkem/ Con melanzane grigliate', 'Rajčatová om., mozzarella, rajčata, grilované lilky, čerstvá bazalka', 'pizza', 'big-69.jpg'),
	(5, 'CHEESBURGER', 'Čerstvě mleté hovězí maso, grilovaná slanina, dvojitá porce sýru čedar, grilovaná cibulka, majonéza, ledový salát a nakládané okurky v maxi bulce brioche s porcí steakových hranolek', 'burger', 'burger.png'),
	(6, '"CLASIC" BURGER ', 'Čerstvě mleté grilované hovězí maso, sýr čedar, rajčata, křupavý salát a šťavnatá cibule, speciální pikantní tomatová salsa a majonéza v maxi bulce brioche s porcí hranolek', 'burger', 'burger.png'),
	(7, '"PORTO" BURGER', 'Čerstvě mleté grilované hovězí maso, sýr čedar, rajčata, křupavý salát a plátek opečené slaninky s naším výborným hořčicovým dresinkem a lahodnou majonézou v maxi bulce brioche s porcí hranolek', 'burger', 'burger.png'),
	(8, '"ROYAL CHICKEN STEAK" BURGER', 'Grilovaná kuřecí prsíčka se sýrem čedar a plátkem slaniny na čerstvém ledovém salátu s rajčetem, Sweet chilli omáčkou a lahodnou majonézou v maxi bulce brioche s porcí hranolek', 'burger', 'burger.png');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Dumping structure for table bistro.size
CREATE TABLE IF NOT EXISTS `size` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bistro.size: ~2 rows (approximately)
/*!40000 ALTER TABLE `size` DISABLE KEYS */;
INSERT INTO `size` (`id`, `name`, `value`) VALUES
	(1, 'normální', 32),
	(2, 'velká', 45);
/*!40000 ALTER TABLE `size` ENABLE KEYS */;

-- Dumping structure for table bistro.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `psc` int(5) unsigned DEFAULT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int(9) unsigned DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bistro.user: ~0 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `address`, `psc`, `city`, `phone`, `isActive`, `created_at`) VALUES
	(8, 'Piticu', '$argon2i$v=19$m=1024,t=2,p=2$Q1lIMmlwclU5cDE3ZWgxZQ$I0qnWW66z7q4thcUgp66ZDjXFC8ZMhl424LXM6pEOGI', 'piticu14@gmail.com', 'Piticu', 'Piticu', 'Kpt. Nalpeky 11', 77900, 'Olomouc', 608733989, 0, '2018-11-05 00:44:41');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
