/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.5.58 : Database - vamed
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `exchangerates` */

DROP TABLE IF EXISTS `exchangerates`;

CREATE TABLE `exchangerates` (
  `ratesid` int(11) NOT NULL AUTO_INCREMENT,
  `euros` decimal(10,3) DEFAULT '0.000',
  `dollars` decimal(10,3) DEFAULT '0.000',
  `pounds` decimal(10,3) DEFAULT '0.000',
  PRIMARY KEY (`ratesid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `exchangerates` */

insert  into `exchangerates`(`ratesid`,`euros`,`dollars`,`pounds`) values (1,'5.860','5.680','6.820');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
