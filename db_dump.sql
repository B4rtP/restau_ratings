CREATE DATABASE  IF NOT EXISTS `restau_ratings` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `restau_ratings`;
-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: restau_ratings
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keywords` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keywords`
--

LOCK TABLES `keywords` WRITE;
/*!40000 ALTER TABLE `keywords` DISABLE KEYS */;
INSERT INTO `keywords` VALUES (1,'great',1),(2,'terrible',0),(3,'bad',0),(4,'amazing',1),(5,'best',1),(6,'disgusting',0),(18,'worst',0),(19,'beautifull',1),(20,'horrible',0),(22,'fresh',1),(23,'healthy',1),(24,'tasty',1),(25,'yummy',1),(26,'artificial',0),(27,'burnt',0),(28,'messy',0),(29,'stink',0),(30,'good',1),(31,'dirt',0),(32,'dirty',0),(33,'top',1),(34,'tasteless',0),(35,'delicious',1),(36,'stinky',0),(37,'appetizing',1),(38,'flavourful',1);
/*!40000 ALTER TABLE `keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restaurants` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cuisine` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_name` (`url_name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (12,'Jerry & John\'s restaurant','greek','Round corner street 303/9','62f9185c83c74.jpg','Jerry_John_restaurant'),(13,'Chef\'s Choice','spanish','Pearcy avenue 86/9','62f91921b4c12.jpg','chefs_choice'),(14,'Food island','mixed','St. John street 91/3','62f91ab6e3446.jpg','Food_island');
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `restaurants_list`
--

DROP TABLE IF EXISTS `restaurants_list`;
/*!50001 DROP VIEW IF EXISTS `restaurants_list`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `restaurants_list` AS SELECT 
 1 AS `rr_id`,
 1 AS `rr_name`,
 1 AS `rr_cuisine`,
 1 AS `rr_address`,
 1 AS `rr_image`,
 1 AS `rr_url`,
 1 AS `rev_id`,
 1 AS `rev_header`,
 1 AS `rev_content`,
 1 AS `review_result`,
 1 AS `rev_newest`,
 1 AS `u_id`,
 1 AS `username`,
 1 AS `rev_total`,
 1 AS `rev_average`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_id` int unsigned NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `header` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `result` decimal(2,1) DEFAULT '0.0',
  `latest_alteration` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (31,12,22,'Great restaurant','delicious meals, beautifull decorations',1.0,'2022-08-14 16:01:41'),(32,13,22,'Personally not my choice','Great restaurant if you don\'t mind stink from the kitchen',0.5,'2022-08-14 16:06:50'),(33,14,22,'Terrible restaurant','disgusting meals, dirty dishes',0.0,'2022-08-14 16:07:31');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `reviews_list`
--

DROP TABLE IF EXISTS `reviews_list`;
/*!50001 DROP VIEW IF EXISTS `reviews_list`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `reviews_list` AS SELECT 
 1 AS `review_id`,
 1 AS `restaurant_id`,
 1 AS `user_id`,
 1 AS `header`,
 1 AS `content`,
 1 AS `result`,
 1 AS `latest_alteration`,
 1 AS `url_name`,
 1 AS `author`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privileges` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (22,'admin','admin@gmail.com','$2y$10$2tkGam2lfdpKeCcut3R9bePr3.CFG48TCVq2unQZrfpZt/JA/x4ey',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `restaurants_list`
--

/*!50001 DROP VIEW IF EXISTS `restaurants_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `restaurants_list` AS select `rr`.`id` AS `rr_id`,`rr`.`name` AS `rr_name`,`rr`.`cuisine` AS `rr_cuisine`,`rr`.`address` AS `rr_address`,`rr`.`image` AS `rr_image`,`rr`.`url_name` AS `rr_url`,`reviews`.`id` AS `rev_id`,`reviews`.`header` AS `rev_header`,`reviews`.`content` AS `rev_content`,`reviews`.`result` AS `review_result`,`reviews`.`latest_alteration` AS `rev_newest`,`users`.`id` AS `u_id`,`users`.`username` AS `username`,`last_reviews`.`rev_total` AS `rev_total`,`last_reviews`.`rev_average` AS `rev_average` from (((`restaurants` `rr` left join (select `reviews`.`restaurant_id` AS `rr_id`,max(`reviews`.`latest_alteration`) AS `rev_newest`,count(`reviews`.`id`) AS `rev_total`,avg(`reviews`.`result`) AS `rev_average` from `reviews` group by `reviews`.`restaurant_id`) `last_reviews` on((`last_reviews`.`rr_id` = `rr`.`id`))) left join `reviews` on(((`reviews`.`latest_alteration` = `last_reviews`.`rev_newest`) and (`reviews`.`restaurant_id` = `rr`.`id`)))) left join `users` on((`users`.`id` = `reviews`.`user_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `reviews_list`
--

/*!50001 DROP VIEW IF EXISTS `reviews_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `reviews_list` AS select `reviews`.`id` AS `review_id`,`reviews`.`restaurant_id` AS `restaurant_id`,`reviews`.`user_id` AS `user_id`,`reviews`.`header` AS `header`,`reviews`.`content` AS `content`,`reviews`.`result` AS `result`,`reviews`.`latest_alteration` AS `latest_alteration`,`restaurants`.`url_name` AS `url_name`,`users`.`username` AS `author` from ((`reviews` join `users` on((`reviews`.`user_id` = `users`.`id`))) join `restaurants` on((`restaurants`.`id` = `reviews`.`restaurant_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-14 20:10:34
