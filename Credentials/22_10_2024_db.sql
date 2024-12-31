-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: didakoo_game
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

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
-- Table structure for table `game_modes`
--

DROP TABLE IF EXISTS `game_modes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game_modes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `level` int NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_modes`
--

LOCK TABLES `game_modes` WRITE;
/*!40000 ALTER TABLE `game_modes` DISABLE KEYS */;
INSERT INTO `game_modes` VALUES (1,0,0,'2023-12-14 16:14:34','2024-10-15 19:41:57'),(2,1,1,'2023-12-14 16:14:34','2024-10-15 19:41:57'),(3,2,0,'2023-12-14 16:14:34','2023-12-21 18:47:15'),(4,3,0,'2023-12-14 16:14:34','2023-12-14 16:14:34'),(5,4,0,'2023-12-14 16:14:34','2024-04-21 11:14:42'),(6,0,0,'2023-12-14 16:15:03','2024-10-15 19:41:57'),(7,1,1,'2023-12-14 16:15:03','2024-10-15 19:41:57'),(8,2,0,'2023-12-14 16:15:03','2023-12-21 18:47:15'),(9,3,0,'2023-12-14 16:15:03','2023-12-14 16:15:03'),(10,4,0,'2023-12-14 16:15:03','2024-04-21 11:14:42'),(11,0,0,'2023-12-15 18:50:28','2024-10-15 19:41:57'),(12,1,1,'2023-12-15 18:50:28','2024-10-15 19:41:57'),(13,2,0,'2023-12-15 18:50:28','2023-12-21 18:47:15'),(14,3,0,'2023-12-15 18:50:28','2023-12-15 18:50:28'),(15,4,0,'2023-12-15 18:50:28','2024-04-21 11:14:42'),(16,0,0,'2023-12-29 09:56:59','2024-10-15 19:41:57'),(17,1,1,'2023-12-29 09:56:59','2024-10-15 19:41:57'),(18,2,0,'2023-12-29 09:56:59','2023-12-29 09:56:59'),(19,3,0,'2023-12-29 09:56:59','2023-12-29 09:56:59'),(20,4,0,'2023-12-29 09:56:59','2024-04-21 11:14:42');
/*!40000 ALTER TABLE `game_modes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `games` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `opponent_id` bigint unsigned DEFAULT NULL,
  `creator_id` bigint unsigned DEFAULT NULL,
  `state` json DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=353 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guest_games`
--

DROP TABLE IF EXISTS `guest_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guest_games` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opponent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1254 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guest_games`
--

LOCK TABLES `guest_games` WRITE;
/*!40000 ALTER TABLE `guest_games` DISABLE KEYS */;
/*!40000 ALTER TABLE `guest_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0000_00_00_000000_create_websockets_statistics_entries_table',1),(2,'0000_00_00_000000_rename_statistics_counters',1),(3,'2014_10_12_000000_create_users_table',1),(4,'2014_10_12_100000_create_password_resets_table',1),(6,'2022_11_03_062516_create_userethwallets_table',1),(8,'2023_01_30_120332_create_players_table',1),(9,'2023_02_20_062804_edit_players_table',1),(10,'2023_02_20_063638_add_players_column_balance_table',1),(11,'2023_04_11_154105_create_games_table',1),(12,'2023_05_01_114534_change_games_columns_name_table',1),(13,'2023_06_21_110933_update_games_table_add_state_column',1),(14,'2023_10_09_164718_create_guest_games_table',1),(16,'2023_11_30_111558_update_players_table_add_last_activity_column',1),(17,'2023_12_13_111521_create_game_modes_table',2),(18,'2024_10_03_141900_change_sunflower_to_jangle_in_players',3),(19,'2024_10_15_113258_add_nft_columns_to_players_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `players` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wallet_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `power` int NOT NULL DEFAULT '0',
  `color_id` int NOT NULL DEFAULT '0',
  `room_openn_flag` tinyint(1) NOT NULL DEFAULT '0',
  `money` int NOT NULL DEFAULT '0',
  `wins` int NOT NULL DEFAULT '0',
  `nft_1_sunflower_1` int NOT NULL DEFAULT '0',
  `nft_2_jungle_1` int NOT NULL DEFAULT '0',
  `nft_3_battery` int NOT NULL DEFAULT '0',
  `nft_4_color1` tinyint(1) NOT NULL DEFAULT '0',
  `nft_5_color2` tinyint(1) NOT NULL DEFAULT '0',
  `nft_6_color3` tinyint(1) NOT NULL DEFAULT '0',
  `nft_7_color4` tinyint(1) NOT NULL DEFAULT '0',
  `nft_8_bot` tinyint(1) NOT NULL DEFAULT '0',
  `nft_21_raygun` tinyint(1) NOT NULL DEFAULT '0',
  `nft_9_cat` tinyint(1) NOT NULL DEFAULT '0',
  `nft_10_monkey` tinyint(1) NOT NULL DEFAULT '0',
  `nft_11_punks` tinyint(1) NOT NULL DEFAULT '0',
  `nft_12_monster` tinyint(1) NOT NULL DEFAULT '0',
  `nft_13_doodle` tinyint(1) NOT NULL DEFAULT '0',
  `nft_14_sandbox` tinyint(1) NOT NULL DEFAULT '0',
  `nft_15_totem` tinyint(1) NOT NULL DEFAULT '0',
  `nft_16_nike` tinyint(1) NOT NULL DEFAULT '0',
  `nft_17_adidas` tinyint(1) NOT NULL DEFAULT '0',
  `nft_18_pepsi` tinyint(1) NOT NULL DEFAULT '0',
  `nft_19_lacoste` tinyint(1) NOT NULL DEFAULT '0',
  `nft_20_land` tinyint(1) NOT NULL DEFAULT '0',
  `nft_22_leo_1` tinyint(1) NOT NULL DEFAULT '0',
  `nft_23_leo_2` tinyint(1) NOT NULL DEFAULT '0',
  `nft_24_leo_3` tinyint(1) NOT NULL DEFAULT '0',
  `nft_25_wb` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT NULL,
  `nft_2_jungle_1_base` tinyint(1) NOT NULL DEFAULT '0',
  `nft_2_jungle_1_polygon` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `players_wallet_address_unique` (`wallet_address`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `players`
--

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players` DISABLE KEYS */;
INSERT INTO `players` VALUES (3,'0x0694052A8b0143df0616e7BFcC6c6FD8dBeC39a9','player_2023127125232','0x00',11,3,0,0,2,0,1,0,0,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2023-12-07 11:52:33','2024-07-31 23:57:05','2024-07-31 23:57:05',0,0),(4,'0x70AB2EDe06952a3B63faA48a8F819dD5986Ee82b','player_2023127125326','0x03517d56a57b11',5,2,0,0,0,0,1,0,0,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2023-12-07 11:53:26','2024-04-21 22:30:20','2024-04-21 22:30:20',0,0),(5,'0xea548060C0720c9cB1deb84fC959952c38C69373','player_2023127161426','0xd373e6cbdda0',55,1,0,0,16,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2023-12-07 12:14:26','2024-10-21 15:41:25','2024-10-21 15:41:15',0,0),(6,'0x8eDAFdC404139251c94ADfdCDaD7E71973e69E71','player_2023127162044','0x00',0,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2023-12-07 12:20:44','2023-12-14 18:01:28','2023-12-14 18:01:28',0,0),(7,'0x05337437b08AA4B57F88Cac5adC56F5E62BD0134','player_2023127133141','0x0',20121,4,0,0,13,8,0,4,0,0,0,1,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'2023-12-07 12:31:41','2024-10-15 21:47:57','2024-10-15 21:47:57',0,0),(9,'0x42Db6137BB24623487238f048fCA7D376C18e74E','player_20231212164149','0x4cd94d330338',5088,3,0,0,13,3,3,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,0,'2023-12-12 12:41:49','2024-08-05 11:18:20','2024-08-05 11:18:07',0,0),(10,'0x94180de019f25e466C9794Db4e533FcB7370F0eB','player_2023122219581','0x00',25,2,0,0,7,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2023-12-22 15:58:02','2024-09-06 09:33:19','2024-08-24 11:26:10',0,0),(12,'0xB55450a11152dD516b59575bfAfb4ca1d1b1AF6C','player_20241191153','0x029389bdbac798ad',318,1,0,0,7,0,59,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-01-19 00:01:53','2024-02-18 11:24:30','2024-02-18 11:24:27',0,0),(13,'0x5A7fCbcbF9BAecD080fFf04F3d010f59DAe0Ba2e','player_202434174912','0x00',1,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-03-04 12:49:13','2024-03-04 12:55:24','2024-03-04 12:55:24',0,0),(15,'0x2e79c7A7F7db4aD9c2E7268844a81E0a704C9508','player_2024429264','0x00',0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-04-02 16:26:08','2024-04-02 16:26:43','2024-04-02 16:26:43',0,0),(16,'0x4B8693655a3F66502305ae19Cb8b2eD75B38762F','player_202442205917','0x5ad604ae2508b8cb',0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-04-02 18:00:10','2024-04-02 18:00:29','2024-04-02 18:00:29',0,0),(17,'0x302B2523914005eF0341a9CC5CdB8385771F1118','player_20244216299','0x4ab81852b780',0,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-04-02 23:29:08','2024-04-02 23:29:33','2024-04-02 23:29:33',0,0),(18,'0x5ADc8bB78d216Bd5b52295a0EcDD03E554A648e4','player_202446161941','0x09fc245d64c8',0,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-04-06 12:19:42','2024-09-04 15:52:10',NULL,0,0),(19,'0x2E8913917c1B9e42EFAba1B361E11065b2F96378','player_202442017570','0x00',0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-04-20 13:57:01','2024-04-22 14:02:56','2024-04-22 14:02:56',0,0),(20,'0x6E87aE8927Bc65815E8A3D4B7f8634d0e3bb1DD7','player_202452812246','0x00',3,3,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-05-28 10:24:06','2024-05-30 15:45:23','2024-05-30 15:45:19',0,0),(21,'0x933F080D3d3b79029586d4fbC452323C5EFD2980','player_2024811167','0x00',1,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-07-31 23:16:08','2024-07-31 23:23:43','2024-07-31 23:23:43',0,0),(22,'0x1155f1a3Fa5038241C5a48782d3F68DC073ae5aA','player_2024811257','0x00',46,1,0,0,14,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-07-31 23:25:07','2024-08-07 10:51:31','2024-08-07 10:49:55',0,0),(23,'0xb8D845ee7D77E0e0976952A59D2c3451b18D2a94','player_202483135137','0x00',0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-08-03 09:51:38','2024-08-03 11:21:27','2024-08-03 11:21:27',0,0),(24,'0x7D3A1028Ca0b1E676928277135ae7b4F0D4C8100','player_2024810193125','0x00',0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-08-10 19:31:25','2024-08-10 19:31:39','2024-08-10 19:31:28',0,0),(25,'0x62B48c390fB658966FF844Afd4d63289027490aE','player_2024817184451','0x00',6,2,0,0,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-08-17 16:44:52','2024-08-17 16:47:51','2024-08-17 16:47:51',0,0),(26,'0xB0578676e24076C133787d1A5e55d50905E874c2','player_2024926205354','0x00',0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,'2024-09-26 18:53:55','2024-09-26 18:57:16','2024-09-26 18:57:16',0,0),(27,'0x2dc60e68f8a6b50dfd7d5758f7264a50957b27cb','player_2024107123115','0x3c2cbcaec10b000',0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-07 10:31:16','2024-10-17 12:32:57','2024-10-17 12:32:57',0,0),(28,'0x3dd6bec9a69e5a02bc398b5662b4e5740ae4f138','player_2024107124049','0x21b3c2436897',13,1,0,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-07 10:40:49','2024-10-17 12:41:01','2024-10-17 12:41:01',0,1),(29,'0xb2e2eb4eb487b0fd52d14ed6452f90eca5c4ef4f','player_2024107161243','0xdb3003d81530',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-07 12:12:44','2024-10-08 09:25:04','2024-10-08 09:25:04',0,0),(30,'0x1b8d8b98fbae9f9912843b00a01871b4f14b3d83','player_20241071949','0x0',3,2,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-07 15:04:09','2024-10-21 10:51:58','2024-10-21 10:51:51',0,0),(31,'0xb70304ad7f9868c9a1c1bbd279fb95fd13030b0f','player_2024108181134','0x0',0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-08 16:11:35','2024-10-16 11:17:32','2024-10-16 11:17:29',0,0),(32,'0x81fd52514f8484843c7d68d644c3c60f42eed93d','player_2024108182149','0x0',0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-08 16:21:50','2024-10-08 16:23:33','2024-10-08 16:23:33',0,0),(33,'0x8ec9a94758ca5581a0b946f78aa7edf7d1713c9a','player_2024109142519','0x0',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-09 12:25:19','2024-10-09 12:25:35','2024-10-09 12:25:35',0,0),(34,'0xf5a4afe85d8b431ba0f5d9801f74fae368563bdd','player_2024101116231','0x0',0,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-11 14:02:32','2024-10-11 14:05:11','2024-10-11 14:05:11',0,0),(35,'0x2677ebe157b0d5b39fbe9158f19c6eb886c1da91','player_2024101116541','0x10b52dfa2eb9',0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-11 14:05:41','2024-10-17 12:49:16','2024-10-17 12:49:10',0,0),(36,'0x48ef5d4c5f4c0d992b519851066cf070b76ee960','player_2024101217714','0x0',0,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-12 13:07:15','2024-10-12 13:14:51','2024-10-12 13:14:51',0,0),(37,'0xd6ca71c24c89b12ca71a4f8db9f845b18136a04f','player_20241013192048','0x0',0,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-13 17:20:49','2024-10-13 17:20:53','2024-10-13 17:20:51',0,0),(38,'0xa132e85636056ebd80a58cd06f7231bbc0a4c9aa','player_20241013192344','0x0',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-13 17:23:45','2024-10-13 17:24:53','2024-10-13 17:24:53',0,0),(39,'0x7b8c0361bac6a48309f6c9bdba37b2ee298e27d9','player_20241014155041','0x0',0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-14 11:50:40','2024-10-14 11:53:00','2024-10-14 11:53:00',0,0),(40,'0xa578ae608d3c9d4cfdd719255bd5b8e148cc188e','player_20241014181928','0x0',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-14 14:19:27','2024-10-14 14:19:33','2024-10-14 14:19:33',0,0),(41,'0xdf2bca1e2a51e56aace6148c10b1171aff1937ad','player_20241014184820','0x0',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-14 14:48:21','2024-10-15 14:47:15','2024-10-15 14:47:15',0,0),(42,'0x44612366ae838c1b345c607a3a18df8e3e5f577a','player_2024101518584','0x0',6,0,0,0,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-15 14:58:04','2024-10-15 15:06:43','2024-10-15 15:06:43',0,0),(43,'0x9c6e800b4c49d1f3bcc7bedeb9d313c5b540875f','player_20241015213544','0x0',0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-15 17:35:43','2024-10-19 12:26:37','2024-10-15 17:35:55',0,0),(44,'0xad6b9b643f77eab9fa7f4bd176f5a2591e568ba1','player_20241015213936','0x0',3,3,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-15 17:39:37','2024-10-15 17:43:54','2024-10-15 17:43:38',0,0),(45,'0xf6a7b5958acc28a6909bafaf8abe5ca9e5f7c951','player_2024101521436','0x0',0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-15 17:43:07','2024-10-15 17:46:14','2024-10-15 17:46:14',0,0),(46,'0x51934627ed6f44cfffc617a355fc7ff006c7b32a','player_20241015214516','0x0',0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-15 17:45:16','2024-10-15 17:45:58','2024-10-15 17:45:18',0,0),(47,'0xa464d48134698d186040c3d54c6d9ab348e7078c','player_20241015212216','0x0',6,4,0,0,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-15 19:22:17','2024-10-15 19:42:31','2024-10-15 19:42:31',0,0),(48,'0x9210151e2e7185e6551191e296b1f29850821268','player_20241015213123','0x0',3,3,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-15 19:31:23','2024-10-15 19:35:32','2024-10-15 19:35:32',0,0),(49,'0x7262064cd2a802c3634532631ce24529de955e30','player_20241015224934','0x25c286ba64d29dec',0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2024-10-15 20:49:34','2024-10-16 11:07:08','2024-10-16 11:07:02',0,0);
/*!40000 ALTER TABLE `players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `websockets_statistics_entries`
--

DROP TABLE IF EXISTS `websockets_statistics_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `websockets_statistics_entries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connections_count` int NOT NULL,
  `websocket_messages_count` int NOT NULL,
  `api_messages_count` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `websockets_statistics_entries`
--

LOCK TABLES `websockets_statistics_entries` WRITE;
/*!40000 ALTER TABLE `websockets_statistics_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `websockets_statistics_entries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-22  0:38:54
