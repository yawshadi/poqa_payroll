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
/*Table structure for table `cron_employee` */

DROP TABLE IF EXISTS `cron_employee`;

CREATE TABLE `cron_employee` (
  `cem_id` int(11) DEFAULT NULL,
  `basic_id` int(11) DEFAULT NULL,
  `probationend` date DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `probationstatus` int(11) DEFAULT NULL,
  `dateofbirthstatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `cron_payslip` */

DROP TABLE IF EXISTS `cron_payslip`;

CREATE TABLE `cron_payslip` (
  `crid` int(11) NOT NULL AUTO_INCREMENT,
  `basicid` int(11) DEFAULT NULL,
  `paystart` date DEFAULT NULL,
  `payend` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`crid`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
