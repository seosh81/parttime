-- MySQL dump 10.13  Distrib 5.5.27, for Linux (x86_64)
--
-- Host: localhost    Database: marutm
-- ------------------------------------------------------
-- Server version	5.5.27-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES euckr */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cafe`
--

DROP TABLE IF EXISTS `cafe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cafe` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `club_id` varchar(100) NOT NULL,
  `display_order` smallint(6) NOT NULL DEFAULT '0',
  `category_id` varchar(100) NOT NULL,
  `cre_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `FK_CAFE_CATEGORY` (`category_id`),
  KEY `seq` (`seq`),
  CONSTRAINT `FK_CAFE_CATEGORY` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=euckr;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cafe`
--

LOCK TABLES `cafe` WRITE;
/*!40000 ALTER TABLE `cafe` DISABLE KEYS */;
INSERT INTO `cafe` VALUES (60,'01789789','�̽�Ȧ��','13028092',0,'����','2013-03-20 15:07:37'),(28,'15668981','�ӻ�θ𿩶�','11291786',0,'����','2013-03-15 10:42:18'),(27,'1msanbu','���ĸ�','15240504',0,'����','2013-03-15 10:42:00'),(22,'6076','6076','10512281',0,'wedding','2013-03-15 09:51:58'),(59,'acnescar','�Ǻ���','11316466',0,'����','2013-03-20 15:07:05'),(58,'agasing','�ư���','14456158',0,'����','2013-03-20 15:06:51'),(37,'bbsang','����1����','20638689',0,'fassion id','2013-03-15 15:49:07'),(47,'bornnborn','�޲ٴ¿���','19466368',0,'1','2013-03-15 15:54:04'),(65,'breakjobnaver','����ǰ���','20395059',0,'���','2013-03-20 15:09:18'),(40,'cosmania','�Ŀ����','10050813',0,'1','2013-03-15 15:51:02'),(63,'dakchi','��ġ�����','21160703',0,'���','2013-03-20 15:08:47'),(35,'dieselmania','�����ŴϾ�','11262350',0,'fassion id','2013-03-15 15:48:13'),(46,'dmreplay','��Ƽ��','15103899',0,'1','2013-03-15 15:53:08'),(61,'dokchi','�����','16996348',0,'���','2013-03-20 15:08:25'),(21,'familywedding','familywedding','23007583',0,'wedding','2013-03-15 09:51:51'),(45,'feko','�����','10912875',0,'1','2013-03-15 15:52:45'),(32,'felizdia','felizdia','17229775',0,'wedding','2013-03-15 15:42:31'),(55,'flueworld','��������','19659631',0,'����','2013-03-20 15:06:02'),(48,'goekqwlzkvp','ȭ����','18909768',0,'1','2013-03-15 15:55:11'),(6,'honeymoondc','honeymoondc','10095818',3,'wedding','2013-03-15 09:47:15'),(34,'idolis','�����ҳ೪��','18866186',0,'fassion id','2013-03-15 15:47:55'),(26,'imsanbu','����Ȧ��','10094499',0,'����','2013-03-15 10:41:13'),(25,'jgs77','jgs77','15979211',0,'wedding','2013-03-15 09:52:27'),(29,'jinheemom','����','21442290',0,'����','2013-03-15 10:42:38'),(64,'jobtong','����Ǵ���','12166238',0,'���','2013-03-20 15:09:01'),(51,'joonggonara','�߰�����','10050146',0,'�߰�ī��','2013-03-18 19:31:06'),(49,'joonggonara2','�����ī��','13244380',0,'1','2013-03-15 15:56:39'),(24,'llchyll','llchyll','14811936',0,'wedding','2013-03-15 09:52:13'),(38,'lrccafe','�հ�','11010385',0,'fassion id','2013-03-15 15:49:43'),(30,'moymoy','������','13730034',0,'����','2013-03-15 10:42:58'),(16,'mp3down99','mp3down99','14718409',0,'wedding','2013-03-15 09:51:10'),(42,'mp3musicdownloadcafe','ȭ���','13761452',0,'1','2013-03-15 15:51:43'),(52,'musicstar2','�߰�ī��','10331120',0,'�߰�ī��','2013-03-18 19:31:35'),(41,'noncommercial','��Ƽũ','23335107',0,'1','2013-03-15 15:51:22'),(56,'ofbyfor','��Ƽ��','10402037',0,'����','2013-03-20 15:06:21'),(33,'planatic','�߻�ī��','18919114',0,'fassion id','2013-03-15 15:47:35'),(19,'poohstory','poohstory','15903231',0,'wedding','2013-03-15 09:51:34'),(15,'powerof','powerof','13194468',0,'wedding','2013-03-15 09:51:01'),(20,'prettyjinnam','prettyjinnam','15512566',0,'wedding','2013-03-15 09:51:43'),(4,'pulib123','ȣ��','22852656',0,'fassion id','2013-03-15 08:03:36'),(50,'remonterrace','�����׶�','10298136',0,'wedding','2013-03-18 10:12:03'),(43,'sdfstptkd','��Ƽ�Ŀ����','11741417',0,'1','2013-03-15 15:52:04'),(7,'skywcdma','skywcdma','14235971',0,'wedding','2013-03-15 09:47:28'),(18,'smilemp3down','smilemp3down','13038269',0,'wedding','2013-03-15 09:51:28'),(62,'specup','�����','15754634',0,'���','2013-03-20 15:08:35'),(9,'ssekzoa','ssekzoa','10879137',0,'wedding','2013-03-15 09:48:14'),(44,'ssmp3','��Ƽ��','12928595',0,'1','2013-03-15 15:52:23'),(39,'sweetdressroom','sweetdressroom','18629593',0,'fassion id','2013-03-15 15:50:18'),(57,'ulgul','������','13816039',0,'����','2013-03-20 15:06:45'),(14,'wangja','wangja','10710888',0,'wedding','2013-03-15 09:50:46'),(23,'wcamp','wcamp','15134926',0,'wedding','2013-03-15 09:52:07'),(17,'weddingsin','weddingsin','21731106',0,'wedding','2013-03-15 09:51:16'),(5,'weddingstory','weddingstory','10094602',2,'wedding','2013-03-15 09:46:17'),(36,'welcomesayonara','��䳪��','15331892',0,'fassion id','2013-03-15 15:48:38');
/*!40000 ALTER TABLE `cafe` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-04-23 14:36:22