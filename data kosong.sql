-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.5-10.0.17-MariaDB


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema unbuy
--

CREATE DATABASE IF NOT EXISTS unbuy;
USE unbuy;

--
-- Definition of table `answer`
--

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `answer_name` text NOT NULL,
  `answer_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `question_id` varchar(10) NOT NULL DEFAULT '',
  KEY `question_answer` (`question_id`),
  CONSTRAINT `question_answer` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer`
--

/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;


--
-- Definition of table `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `banner_id` varchar(10) NOT NULL DEFAULT '',
  `banner_name` varchar(45) NOT NULL DEFAULT '',
  `banner_image` longtext NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;


--
-- Definition of table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `cat_id` varchar(10) NOT NULL DEFAULT '',
  `cat_name` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


--
-- Definition of table `category_item`
--

DROP TABLE IF EXISTS `category_item`;
CREATE TABLE `category_item` (
  `cat_id` varchar(10) NOT NULL DEFAULT '',
  `item_id` varchar(10) NOT NULL DEFAULT '',
  KEY `cat_item` (`cat_id`) USING BTREE,
  CONSTRAINT `cat_item_item` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_item`
--

/*!40000 ALTER TABLE `category_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_item` ENABLE KEYS */;


--
-- Definition of table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `chat_id` varchar(10) NOT NULL DEFAULT '',
  `chat_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `chat_text` text NOT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;


--
-- Definition of table `chat_user`
--

DROP TABLE IF EXISTS `chat_user`;
CREATE TABLE `chat_user` (
  `chat_id` varchar(10) NOT NULL DEFAULT '',
  `user_id` varchar(10) NOT NULL DEFAULT '',
  KEY `chat_user_chat` (`chat_id`),
  KEY `chat_user_user` (`user_id`),
  CONSTRAINT `chat_user_chat` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`chat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chat_user_user` FOREIGN KEY (`user_id`) REFERENCES `webuser` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_user`
--

/*!40000 ALTER TABLE `chat_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_user` ENABLE KEYS */;


--
-- Definition of table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `item_id` varchar(10) NOT NULL DEFAULT '',
  `item_name` varchar(45) NOT NULL DEFAULT '',
  `item_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `item_price` int(10) unsigned NOT NULL DEFAULT '0',
  `item_photo` longtext NOT NULL,
  `user_id` varchar(10) NOT NULL DEFAULT '',
  `item_stock` int(10) unsigned NOT NULL DEFAULT '0',
  `item_text` text NOT NULL,
  `cat_id` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`item_id`),
  KEY `item_user` (`user_id`),
  CONSTRAINT `item_user` FOREIGN KEY (`user_id`) REFERENCES `webuser` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

/*!40000 ALTER TABLE `item` DISABLE KEYS */;
/*!40000 ALTER TABLE `item` ENABLE KEYS */;


--
-- Definition of table `level`
--

DROP TABLE IF EXISTS `level`;
CREATE TABLE `level` (
  `level_id` varchar(1) NOT NULL DEFAULT '',
  `level_name` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

/*!40000 ALTER TABLE `level` DISABLE KEYS */;
INSERT INTO `level` (`level_id`,`level_name`) VALUES 
 ('-','blocked'),
 ('0','guest'),
 ('1','user'),
 ('2','admin');
/*!40000 ALTER TABLE `level` ENABLE KEYS */;


--
-- Definition of table `promo`
--

DROP TABLE IF EXISTS `promo`;
CREATE TABLE `promo` (
  `promo_id` varchar(10) NOT NULL DEFAULT '',
  `promo_name` varchar(45) NOT NULL DEFAULT '',
  `promo_image` longtext NOT NULL,
  PRIMARY KEY (`promo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promo`
--

/*!40000 ALTER TABLE `promo` DISABLE KEYS */;
/*!40000 ALTER TABLE `promo` ENABLE KEYS */;


--
-- Definition of table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `question_id` varchar(10) NOT NULL DEFAULT '',
  `question_name` text NOT NULL,
  `question_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `item_id` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`question_id`),
  KEY `question_item` (`item_id`),
  CONSTRAINT `question_item` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

/*!40000 ALTER TABLE `question` DISABLE KEYS */;
/*!40000 ALTER TABLE `question` ENABLE KEYS */;


--
-- Definition of table `rating`
--

DROP TABLE IF EXISTS `rating`;
CREATE TABLE `rating` (
  `rating_id` varchar(10) NOT NULL DEFAULT '',
  `rating_score` int(10) unsigned NOT NULL DEFAULT '0',
  `rating_text` text NOT NULL,
  `item_id` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`rating_id`),
  KEY `ratingitem` (`item_id`),
  CONSTRAINT `ratingitem` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `rating` ENABLE KEYS */;


--
-- Definition of table `transaction_item`
--

DROP TABLE IF EXISTS `transaction_item`;
CREATE TABLE `transaction_item` (
  `trans_id` varchar(10) NOT NULL DEFAULT '',
  `item_id` varchar(10) NOT NULL DEFAULT '',
  `item_order` float NOT NULL DEFAULT '0',
  `seller_id` varchar(45) NOT NULL,
  KEY `FK_transaction_item_key` (`trans_id`),
  KEY `FK_transaction_item_barang` (`item_id`),
  KEY `FK_transaction_item_penjual` (`seller_id`),
  CONSTRAINT `FK_transaction_item_barang` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_transaction_item_key` FOREIGN KEY (`trans_id`) REFERENCES `webtransaction` (`trans_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_transaction_item_penjual` FOREIGN KEY (`seller_id`) REFERENCES `webuser` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_item`
--

/*!40000 ALTER TABLE `transaction_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_item` ENABLE KEYS */;


--
-- Definition of table `webtransaction`
--

DROP TABLE IF EXISTS `webtransaction`;
CREATE TABLE `webtransaction` (
  `trans_id` varchar(10) NOT NULL DEFAULT '',
  `trans_receipt` longtext NOT NULL,
  `trans_status` varchar(30) NOT NULL,
  `buyer_id` varchar(10) NOT NULL DEFAULT '',
  `trans_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `trans_total` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`trans_id`),
  KEY `trans_user_buyer` (`buyer_id`),
  CONSTRAINT `trans_user_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `webuser` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webtransaction`
--

/*!40000 ALTER TABLE `webtransaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `webtransaction` ENABLE KEYS */;


--
-- Definition of table `webuser`
--

DROP TABLE IF EXISTS `webuser`;
CREATE TABLE `webuser` (
  `user_id` varchar(10) NOT NULL DEFAULT '',
  `user_name` varchar(45) NOT NULL DEFAULT '',
  `user_password` varchar(45) NOT NULL DEFAULT '',
  `user_email` varchar(45) NOT NULL DEFAULT '',
  `user_birth` date NOT NULL DEFAULT '0000-00-00',
  `user_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_photo` longtext NOT NULL,
  `user_telephone` varchar(15) NOT NULL DEFAULT '',
  `user_level` varchar(1) NOT NULL DEFAULT '',
  `user_address` text NOT NULL,
  `user_bank` varchar(45) NOT NULL DEFAULT '',
  `block` varchar(2) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UNIQUE` (`user_email`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webuser`
--

/*!40000 ALTER TABLE `webuser` DISABLE KEYS */;
/*!40000 ALTER TABLE `webuser` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
