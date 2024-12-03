-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: test_ils
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `card_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,'NEUST-F-932','christian pe√±a','teacher','2024-11-14 01:42:19','2024-11-14 01:42:19'),(2,'NEUST-F-932','christian pe√±a','teacher','2024-11-15 06:32:13','2024-11-15 06:32:13'),(3,'NEUST-F-932','christian pe√±a','teacher','2024-11-22 01:58:47','2024-11-22 01:58:47'),(4,'NEUST-F-932','christian pe√±a','teacher','2024-11-22 14:41:46','2024-11-22 14:41:46'),(5,'NEUST-P-100','Elioth Coder','student','2024-11-22 14:43:11','2024-11-22 14:43:11'),(6,'NEUST-F-923','edward mansibang','teacher','2024-11-23 04:50:37','2024-11-23 04:50:37'),(7,'NEUST-F-932','christian pe√±a','teacher','2024-11-23 05:11:18','2024-11-23 05:11:18'),(8,'NEUST-F-923','edward mansibang','teacher','2024-11-23 05:11:36','2024-11-23 05:11:36');
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campuses`
--

DROP TABLE IF EXISTS `campuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `campuses_name_unique` (`name`),
  UNIQUE KEY `campuses_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campuses`
--

LOCK TABLES `campuses` WRITE;
/*!40000 ALTER TABLE `campuses` DISABLE KEYS */;
INSERT INTO `campuses` VALUES (4,'NEUST-PPY','NEUST Papaya Off-Campus','General Tinio','..','2024-09-09 17:13:39','2024-09-09 17:13:39');
/*!40000 ALTER TABLE `campuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colleges`
--

DROP TABLE IF EXISTS `colleges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colleges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `colleges_code_unique` (`code`),
  UNIQUE KEY `colleges_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colleges`
--

LOCK TABLES `colleges` WRITE;
/*!40000 ALTER TABLE `colleges` DISABLE KEYS */;
INSERT INTO `colleges` VALUES (1,'CICT','College of Information and Communications Technology','Some descriptions','2024-08-28 00:55:40','2024-08-28 00:56:11'),(2,'CMBT','College of Management and Business Technology','..','2024-09-08 22:27:27','2024-09-08 22:27:27'),(3,'COED','College of Education','..','2024-09-08 22:27:43','2024-09-08 22:27:43'),(4,'CIT','College of Industrial Technology','New College',NULL,NULL);
/*!40000 ALTER TABLE `colleges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `face_encodings`
--

DROP TABLE IF EXISTS `face_encodings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `face_encodings` (
  `card_number` varchar(255) NOT NULL,
  `encodings` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_encodings`
--

LOCK TABLES `face_encodings` WRITE;
/*!40000 ALTER TABLE `face_encodings` DISABLE KEYS */;
INSERT INTO `face_encodings` VALUES ('NEUST-F-932','Äïã\0\0\0\0\0\0ånumpy.core.multiarrayîå_reconstructîìîånumpyîåndarrayîìîK\0ÖîCbîáîRî(KKÄÖîhådtypeîìîåf8îâàáîRî(Kå<îNNNJˇˇˇˇJˇˇˇˇK\0tîbâB\0\0\0\0\0\0Ä„M∫ø\0\0\0@¡Ô∫?\0\0\0@ÍÃ≥?\0\0\0@∑Y¨ø\0\0\0 5lü?\0\0\0\0\0dûø\0\0\0†™ì?\0\0\0 V∆ø\0\0\0 Œg»?\0\0\0‡* øø\0\0\0`?„–?\0\0\0\0b@íø\0\0\0‡\\»ø\0\0\0 ◊F¡ø\0\0\0Äwçõ?\0\0\0‡…œ√?\0\0\0ÄV2√ø\0\0\0‡ê√ø\0\0\0‡¿5Æø\0\0\0@ÉÑ§ø\0\0\0Ä¥[~ø\0\0\0¿°7§ø\0\0\0 Éÿ®?\0\0\0\0zà¢?\0\0\0‡cs≥ø\0\0\0¿çŸø\0\0\0\0qº∫ø\0\0\0 πã∑ø\0\0\0 v§ì?\0\0\0 ¢Áaø\0\0\0† ü°ø\0\0\0‡ı◊Ü?\0\0\0 —ø\0\0\0‡Ûc¢ø\0\0\0Äò6õø\0\0\0ÄzPΩ?\0\0\0ÄÀz§ø\0\0\0†Ô,êø\0\0\0‡\n†»?\0\0\0\0Û¯n?\0\0\0 8∆ø\0\0\0†UK©ø\0\0\0@Kwø\0\0\0†«˘œ?\0\0\0 ’≤Ω?\0\0\0†7çè?\0\0\0Ä5-¨?\0\0\0†©¢ø\0\0\0‡íˆ§?\0\0\0`≤7¬ø\0\0\0\0QÛ∫?\0\0\0Äıkº?\0\0\0‡òUº?\0\0\0†ô–∑?\0\0\0 ıGëø\0\0\0†ﬁ≠¬ø\0\0\0@Doø\0\0\0@æœ±?\0\0\0†Hf¡ø\0\0\0¿≤≠?\0\0\0Änµ?\0\0\0Ä¡[Ωø\0\0\0\0Ÿí∫ø\0\0\0\0_Iø\0\0\0 +ì–?\0\0\0¿”óø?\0\0\0Ä2¿ø\0\0\0¿tö¡ø\0\0\0@¡3ƒ?\0\0\0†%πø\0\0\0@3á`ø\0\0\0@SÅ?\0\0\0‡#≈ø\0\0\0‡Ì ø\0\0\0\08`“ø\0\0\0Äú∏¡?\0\0\0@0’?\0\0\0 dº?\0\0\0\07«ø\0\0\0¿°åwø\0\0\0@RR±ø\0\0\0\0Ä°?\0\0\0`LZ∏?\0\0\0¿Q≈?\0\0\0\00ïàø\0\0\0\0Ûƒø?\0\0\0†“≥ø\0\0\0¿báπ?\0\0\0\0.¡?\0\0\0`Õÿ™ø\0\0\0@‚<≥ø\0\0\0‡4!Õ?\0\0\0`¸R≥ø\0\0\0`»\"±?\0\0\0 Yf°ø\0\0\0‡◊÷¢?\0\0\0@xu?\0\0\0Ä7à∞?\0\0\0ÄW	√ø\0\0\0‡˛[°?\0\0\0`T_¿?\0\0\0\0ïkô?\0\0\0¿”Ó[ø\0\0\0†rá∂?\0\0\0¿h¬ø\0\0\0Ä’º?\0\0\0†ÏLñ?\0\0\0\0ïèÜ?\0\0\0Ä“†?\0\0\0 Tê?\0\0\0@úÖ∏ø\0\0\0 ú⁄¿ø\0\0\0¿œÇ∫?\0\0\0`]îÀø\0\0\0 Í Œ?\0\0\0¿†≥Ã?\0\0\0` eå?\0\0\0†¨+√?\0\0\0¿/≥?\0\0\0‡ﬂÄ≤?\0\0\0`⁄Ò¥?\0\0\0‡©ø\0\0\0‡t|…ø\0\0\0†`πäø\0\0\0¿Õa∂?\0\0\0`ÊÕß?\0\0\0\0~´?\0\0\0\0‹Ó¢?îtîb.'),('NEUST-T-00001','Äïã\0\0\0\0\0\0ånumpy.core.multiarrayîå_reconstructîìîånumpyîåndarrayîìîK\0ÖîCbîáîRî(KKÄÖîhådtypeîìîåf8îâàáîRî(Kå<îNNNJˇˇˇˇJˇˇˇˇK\0tîbâB\0\0\0\0\0\0`œ¯ ø\0\0\0¿Í-º?\0\0\0\0GÁû?\0\0\0†§,¥ø\0\0\0Ä∏Ò¬ø\0\0\0‡—&πø\0\0\0‡˝ˆ≠ø\0\0\0@ÅQ¬ø\0\0\0‡:*∏?\0\0\0@Í£∆ø\0\0\0¿‡Î»?\0\0\0†\0ß∆ø\0\0\0‡ã∏…ø\0\0\0\0S±ø\0\0\0`X1¿ø\0\0\0@ÌA…?\0\0\0¿®ÂÃø\0\0\0`T3Ãø\0\0\0@˙IÑ?\0\0\0\0[≠¨ø\0\0\0‡	–¡?\0\0\0‡öf©ø\0\0\0†»ßú?\0\0\0`±ñ¡?\0\0\0ÄÈë¿ø\0\0\0\0Y~÷ø\0\0\0\0˚oπø\0\0\0`£◊¥ø\0\0\0\0…ï∞?\0\0\0¿⁄T≥ø\0\0\0\0∫}?\0\0\0@Zhè?\0\0\0@_:Õø\0\0\0†*M¢ø\0\0\0\0XT?\0\0\0\0fƒ?\0\0\0†Øπ£?\0\0\0 Ω≠ø\0\0\0@ıd«?\0\0\0`ÊØ≥ø\0\0\0 oÇ—ø\0\0\0\0EAöø\0\0\0¿å≤∆?\0\0\0 \Z»—?\0\0\0\0ºÔæ?\0\0\0¿Êlü?\0\0\0Ä5«õø\0\0\0\0ÛW¡ø\0\0\0¿€x¬?\0\0\0`/Ï√ø\0\0\0¿lQò?\0\0\0\0º¯¡?\0\0\0\0bw∂?\0\0\0@Ùπ§?\0\0\0ÄıA∞?\0\0\0\0Òñ∏ø\0\0\0`*£µ?\0\0\0‡&ø¬?\0\0\0 ;∆ø\0\0\0\0		C?\0\0\0 ‰π?\0\0\0¿Ø®ø\0\0\0‡˚Úç?\0\0\0 ìá¬ø\0\0\0‡]‡ ?\0\0\0‡Ø?\0\0\0 –@≠ø\0\0\0Ä_·Ãø\0\0\0\0ñ∂…?\0\0\0¿kŒœø\0\0\0¿Ωƒ∞ø\0\0\0Äy√?\0\0\0`nØø\0\0\0Äï\rΩø\0\0\0@q‘ø\0\0\0 \\≤ø\0\0\0Äc◊?\0\0\0@æÉ√?\0\0\0¿}&∏ø\0\0\0‡íP≤?\0\0\0\0ïßa?\0\0\0†áa¨ø\0\0\0@iª?\0\0\0`ïƒ?\0\0\0\0ô-õø\0\0\0\0Óì±?\0\0\0@…j¡ø\0\0\0ÄÅàø\0\0\0\0À?\0\0\0ÄQöø\0\0\0¿‰ƒú?\0\0\0¿‘H≈?\0\0\0\0~òØ?\0\0\0Ä1‚ï?\0\0\0`±èØ?\0\0\0¿Ø*Ö?\0\0\0\0÷a…ø\0\0\0ÄUÈé?\0\0\0‡Õ!∆ø\0\0\0†˙Æwø\0\0\0 ÀWºø\0\0\0¿c@ùø\0\0\0¿G∞ø\0\0\0\0ôHµ?\0\0\0Äy(¡ø\0\0\0†˝]∞?\0\0\0 ∏(°ø\0\0\0¿—¸¨ø\0\0\0\0› æø\0\0\0‡d£≠?\0\0\0Ä|±ø\0\0\0@;ºø\0\0\0†\0n≤?\0\0\0@≠ÍÕø\0\0\0ÄÛ•∑?\0\0\0ÄìZ»?\0\0\0@¿X∞?\0\0\0`¿◊Ω?\0\0\0¿&’∫?\0\0\0\0$⁄∑?\0\0\0¿<Áêø\0\0\0@h·ùø\0\0\0†lú≈ø\0\0\0†O^£ø\0\0\0`πµ±?\0\0\0`∆≠¬ø\0\0\0\0A∞®?\0\0\0ÄGdèøîtîb.'),('NEUST-F-00001','Äïã\0\0\0\0\0\0ånumpy.core.multiarrayîå_reconstructîìîånumpyîåndarrayîìîK\0ÖîCbîáîRî(KKÄÖîhådtypeîìîåf8îâàáîRî(Kå<îNNNJˇˇˇˇJˇˇˇˇK\0tîbâB\0\0\0\0\0\0`éæø\0\0\0Ä#kµ?\0\0\0`µÛì?\0\0\0†\0,£ø\0\0\0`Ú √ø\0\0\0†õPÇø\0\0\0¿‰Øöø\0\0\0‡+Ä¡ø\0\0\0 `‹∆?\0\0\0ÄC¡ø\0\0\0 £VÃ?\0\0\0†¨ø∂ø\0\0\0 œ_—ø\0\0\0‡˝g™ø\0\0\0 êôø\0\0\0¿˝UÕ?\0\0\0‡—ø\0\0\0ÄÁ–¡ø\0\0\0\0±œjø\0\0\0‡»∏¶?\0\0\0†´?\0\0\0¿¬_Vø\0\0\0¿Uà®?\0\0\0\0¬≤?\0\0\0@6S≥ø\0\0\0†À¯Ÿø\0\0\0\0*Ü±ø\0\0\0¿ÑÔ√ø\0\0\0†~Øø\0\0\0¿˚4±ø\0\0\0\0©£ø\0\0\0`Ye∞?\0\0\0@dc≈ø\0\0\0@äÚ™ø\0\0\0@\\àå?\0\0\0@õb†?\0\0\0Ä≥\Z®ø\0\0\0‡ëK±ø\0\0\0`Ü ?\0\0\0¿°6†ø\0\0\0†—ø\0\0\0@˛ßø\0\0\0‡:Ñ¥?\0\0\0ÄI¯…?\0\0\0\0‚Å¡?\0\0\0†m√ô?\0\0\0\0lônø\0\0\0 ì”»ø\0\0\0`#dΩ?\0\0\0†“ú…ø\0\0\0\0väT?\0\0\0\0Âª?\0\0\0†Ø)k?\0\0\0\0Ü¢•?\0\0\0Äõøá?\0\0\0\0Ü√ø\0\0\0ÄûRñ?\0\0\0‡\\d¨?\0\0\0†V”¡ø\0\0\0@*}åø\0\0\0 <º?\0\0\0\0`ª±ø\0\0\0¿Uô¶ø\0\0\0†“5πø\0\0\0†¶)”?\0\0\0Ä˚∏?\0\0\0`è¥ø\0\0\0Ä·∆ø\0\0\0¿†ˆΩ?\0\0\0\0ø¡ø\0\0\0†\nªªø\0\0\0‡âU¥?\0\0\0Äd¬ø\0\0\0\0‡Ù«ø\0\0\0Ä√;—ø\0\0\0Än¶µø\0\0\0 ÷?\0\0\0Äú∞?\0\0\0`Z≈ø\0\0\0\0’ë?\0\0\0`kâ≥ø\0\0\0`G‘õø\0\0\0ÄêU¬?\0\0\0†Á˝ ?\0\0\0 w©?\0\0\0`ó⁄ö?\0\0\0`å)≥ø\0\0\0 (å?\0\0\0Äúà…?\0\0\0`zhºø\0\0\0Äƒ™É?\0\0\0ÄÛ–?\0\0\0\01µm?\0\0\0@ˇµ?\0\0\0‡/¢?\0\0\0Ä¨;{ø\0\0\0‡-ê±ø\0\0\0†\'¢?\0\0\0`Eu∆ø\0\0\0 ØÓ®ø\0\0\0`\"N§?\0\0\0@o®?\0\0\0 ˇÅø\0\0\0¿ç:π?\0\0\0\0ë ¬ø\0\0\0‡¸È¨?\0\0\0 π>dø\0\0\0@µhï?\0\0\0@\'´?\0\0\0@ª¨∞ø\0\0\0¿â~Øø\0\0\0@ˆ”µø\0\0\0¿_ï¿?\0\0\0‡RrÀø\0\0\0Ä}∏«?\0\0\0 ÙUæ?\0\0\0`û ö?\0\0\0¿èº?\0\0\0Ä¯ß?\0\0\0‡Fi≥?\0\0\0@V±ø\0\0\0‡b®ø\0\0\0@í“ø\0\0\0\0O∞?\0\0\0‡úƒ?\0\0\0\0Œµëø\0\0\0¿éß?\0\0\0 ïRßøîtîb.'),('NEUST-F-00002','Äïã\0\0\0\0\0\0ånumpy.core.multiarrayîå_reconstructîìîånumpyîåndarrayîìîK\0ÖîCbîáîRî(KKÄÖîhådtypeîìîåf8îâàáîRî(Kå<îNNNJˇˇˇˇJˇˇˇˇK\0tîbâB\0\0\0\0\0\0‡5≠ø\0\0\0\0|uπ?\0\0\0\0∆-Dø\0\0\0@ÜØ±ø\0\0\0‡7æƒø\0\0\0†cí†?\0\0\0 Fbµø\0\0\0\0pŒ±ø\0\0\0`s$ ?\0\0\0 ˇm¿ø\0\0\0@∏ì√?\0\0\0`Û¬ø\0\0\0‡ºM—ø\0\0\0†Â¿?\0\0\0 ∫Êπø\0\0\0\0˜Ø≈?\0\0\0 + ø\0\0\0‡˚Z∆ø\0\0\0\0P¢ø\0\0\0\0\nﬂ∏ø\0\0\0Äçm=?\0\0\0\0ÿ¯q?\0\0\0†[ﬁ∞ø\0\0\0@Ì>¬?\0\0\0\0zÏ¥ø\0\0\0@Óﬂ”ø\0\0\0`ò°?\0\0\0\0Ü\'¶ø\0\0\0@5_∑?\0\0\0@ôÈµø\0\0\0ÄÁd}?\0\0\0Ä†˚∫?\0\0\0‡√wÃø\0\0\0 ˘nú?\0\0\0@B\nv?\0\0\0¿m¬?\0\0\0ÄÊ‹q?\0\0\0Ä¬¿ø\0\0\0@UóÕ?\0\0\0Äô_Äø\0\0\0\0„,—ø\0\0\0`Ôò∑ø\0\0\0`≈lº?\0\0\0@È©–?\0\0\0 7˚¿?\0\0\0\0Í•?\0\0\0`˛¢ø\0\0\0 \Z6µø\0\0\0 ,À¡?\0\0\0\0ü¿‘ø\0\0\0@ú∞¢?\0\0\0@Æ2…?\0\0\0\0ö±?\0\0\0@¿F™?\0\0\0ÄÖ+†?\0\0\0‡_\ZÀø\0\0\0‡îñ?\0\0\0`ˆÀ∫?\0\0\0¿y7¡ø\0\0\0†Wfú?\0\0\0††\nµ?\0\0\0‡¶°ø\0\0\0@ﬂ‰ñ?\0\0\0†±!¡ø\0\0\0‡l”?\0\0\0‡™w≥?\0\0\0‡eF≤ø\0\0\0¿K∂≈ø\0\0\0Ä)Ì»?\0\0\0Ä}⁄Àø\0\0\0Ä£ªø\0\0\0†¯pƒ?\0\0\0‡A\0éø\0\0\0@,¸√ø\0\0\0 w6“ø\0\0\0\0úÌY?\0\0\0\0pc’?\0\0\0Ä$ˇƒ?\0\0\0†y˙∏ø\0\0\0@zú≥?\0\0\0@∑ßÄø\0\0\0Ä7∏ø\0\0\0Ä/Ê±?\0\0\0\0-à√?\0\0\0†#öÉø\0\0\0`aÉÇø\0\0\0@˝Â∏ø\0\0\0\0V\\ø\0\0\0@9∫”?\0\0\0@t†ø\0\0\0 /‰ú?\0\0\0¿∫•Œ?\0\0\0\0ôpå?\0\0\0†–6¶ø\0\0\0 ì&Øø\0\0\0ÄZ∑?\0\0\0‡Çƒ¬ø\0\0\0Äw°?\0\0\0Ä@I¬ø\0\0\0@7ÿ´ø\0\0\0``π?\0\0\0‡bkÆ?\0\0\0¿kãëø\0\0\0Ä«£ƒ?\0\0\0 Y∑—ø\0\0\0\0·©¥?\0\0\0@fe¥ø\0\0\0†ú≤ø\0\0\0Ä’ÙÆ?\0\0\0‡~êlø\0\0\0¿≤®ø\0\0\0\0ª!∂ø\0\0\0@‹« ?\0\0\0†X[“ø\0\0\0 Vóπ?\0\0\0@ìˆ¡?\0\0\0Äfœ¥?\0\0\0ÄíC∫?\0\0\0¿à≠?\0\0\0 ìD∞?\0\0\0 yù∑?\0\0\0`ÆDπø\0\0\0†ÑµÕø\0\0\0`î;∫ø\0\0\0‡RE§?\0\0\0Äâπø\0\0\0‡ì≠≥ø\0\0\0 f*´?îtîb.'),('NEUST-F-923','Äïã\0\0\0\0\0\0ånumpy.core.multiarrayîå_reconstructîìîånumpyîåndarrayîìîK\0ÖîCbîáîRî(KKÄÖîhådtypeîìîåf8îâàáîRî(Kå<îNNNJˇˇˇˇJˇˇˇˇK\0tîbâB\0\0\0\0\0\0†:]ßø\0\0\0¿Ë1¥?\0\0\0‡n_£ø\0\0\0ÄeÑ¢ø\0\0\0† äø\0\0\0`Ò>§ø\0\0\0 ﬁéü?\0\0\0‡í∏ø\0\0\0‡“z¿?\0\0\0†4*πø\0\0\0\0Î=“?\0\0\0\0&q≠ø\0\0\0‡d@…ø\0\0\0‡˛∞≈ø\0\0\0@Nú†?\0\0\0¿w0¿?\0\0\0†BÆ¡ø\0\0\0†≥Møø\0\0\0¿$ö∏ø\0\0\0\0hQ?\0\0\0 «k¡?\0\0\0¿\"á?\0\0\0‡—ã£ø\0\0\0`ßì¶?\0\0\0†≤ø\0\0\0ÄB˝Ÿø\0\0\0ÄRy∏ø\0\0\0 ‚dµø\0\0\0@,±?\0\0\0†Æû∫ø\0\0\0¿tﬁuø\0\0\0Ä]∑í?\0\0\0†¥E«ø\0\0\0@èH≥ø\0\0\0¿ÍÓ©?\0\0\0\0Op¥?\0\0\0`ÀÂ©ø\0\0\0@æ≈ê?\0\0\0Ä§m ?\0\0\0\0Øò©?\0\0\0 Ï_Àø\0\0\0`gc?\0\0\0 ô‰õ?\0\0\0‡ôÉ“?\0\0\0‡4◊ƒ?\0\0\0†€†∑?\0\0\0\0\0¢ø\0\0\0†Vﬂµø\0\0\0 ~¡?\0\0\0ÄnS∆ø\0\0\0¿\'ƒö?\0\0\0‡ﬁ£¡?\0\0\0`ùΩ»?\0\0\0\0Vuµ?\0\0\0¿Ù∞?\0\0\0¿d†Ωø\0\0\0\0∏.<?\0\0\0¿Å`π?\0\0\0¿çJ–ø\0\0\0ÄZÃëø\0\0\0Äzw†?\0\0\0†.„∫ø\0\0\0†√°ø\0\0\0 ªø\0\0\0 ÌÎÃ?\0\0\0¿ZÛñ?\0\0\0‡Áô¬ø\0\0\0\0÷∫ø\0\0\0‡Ë[√?\0\0\0ÄﬂQ√ø\0\0\0¿Ã◊úø\0\0\0Äü‹ß?\0\0\0`á#πø\0\0\0 —Û ø\0\0\0\0-v–ø\0\0\0@ù≤?\0\0\0 Æ ’?\0\0\0 õ\rƒ?\0\0\0@guÕø\0\0\0 Uˇâø\0\0\0 Ò≈ûø\0\0\0Ä-πôø\0\0\0Ä7]¬?\0\0\0`Íúµ?\0\0\0\0˜°qø\0\0\0@Ωø°?\0\0\0\0	∆≥ø\0\0\0¿ÿŒvø\0\0\0ÄbÁø?\0\0\0†–ïØø\0\0\0 ˆ∂z?\0\0\0Ä™^ ?\0\0\0‡G8±ø\0\0\0ÄÉ¿?\0\0\0ÄÌ‘Ñ?\0\0\0¿I¢ø\0\0\0¿<ßæø\0\0\0\0‰Ö´?\0\0\0\0m¬ø\0\0\0@hŒàø\0\0\0¿rîø\0\0\0¿gûø\0\0\0Ä∫•?\0\0\0†KÊ∂?\0\0\0‡å∏ø\0\0\0ÄwÕƒ?\0\0\0@¬·ê?\0\0\0 ∑ÿÑ?\0\0\0@c§àø\0\0\0¿Å5f?\0\0\0`\Zû∫ø\0\0\0`2L∏ø\0\0\0`¯°¥?\0\0\0@ˇœœø\0\0\0Ä‹Ã?\0\0\0 6(≈?\0\0\0 eGÖ?\0\0\0¿dóø?\0\0\0†3Êµ?\0\0\0ÄØÛ¨?\0\0\0‡U™êø\0\0\0@;L≠ø\0\0\0 Ö—ø\0\0\0‡Ω	ãø\0\0\0‡v©º?\0\0\0@W`üø\0\0\0 —π¨?\0\0\0@RÓ∂øîtîb.');
/*!40000 ALTER TABLE `face_encodings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
INSERT INTO `failed_jobs` VALUES (1,'6e3bf35b-5a60-46ea-a2fd-b322516f27a7','database','default','{\"uuid\":\"6e3bf35b-5a60-46ea-a2fd-b322516f27a7\",\"displayName\":\"App\\\\Jobs\\\\BackupDatabaseJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\BackupDatabaseJob\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\BackupDatabaseJob\\\":0:{}\"}}','Exception: Backup file does not exist: C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\storage\\backups\\BACKUP_2024_12_03_153443.sql in C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\app\\Jobs\\BackupDatabaseJob.php:53\nStack trace:\n#0 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\BackupDatabaseJob->handle()\n#1 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#2 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#3 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#4 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#5 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#6 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\BackupDatabaseJob))\n#7 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\BackupDatabaseJob))\n#8 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#9 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\BackupDatabaseJob), false)\n#10 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\BackupDatabaseJob))\n#11 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\BackupDatabaseJob))\n#12 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(123): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#13 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(71): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\BackupDatabaseJob))\n#14 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#15 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#16 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#17 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#18 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(139): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(122): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#20 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#21 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#22 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#23 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#24 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(690): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#25 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)\n#26 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#27 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\symfony\\console\\Application.php(1047): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#29 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\symfony\\console\\Application.php(316): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\symfony\\console\\Application.php(167): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1203): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 C:\\Users\\xtian\\OneDrive\\Desktop\\ils\\artisan(13): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#34 {main}','2024-12-03 07:34:44');
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `accession_number` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `call_number` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `advisor` varchar(255) DEFAULT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `doi` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) NOT NULL,
  `publication_year` int(11) NOT NULL,
  `language` varchar(255) DEFAULT 'English',
  `genre` varchar(255) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `format` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'book',
  `date_acquired` date DEFAULT NULL,
  `library` varchar(255) DEFAULT NULL,
  `section` varchar(255) NOT NULL DEFAULT 'circulation',
  `degree` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_accession_number_unique` (`accession_number`),
  UNIQUE KEY `books_barcode_number_unique` (`barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (5,NULL,'147866542874',NULL,'Harry Potter and the Prisoners of Azkaban (Book 3)','J.K. Rowling',NULL,'9781338878943',NULL,'Scholastic Inc.',2005,'english','fiction',NULL,'paperback','5.png',NULL,520.00,NULL,'harry,potter,prisoner,azkaban','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'damaged','2024-09-30 23:11:07','2024-11-22 18:09:59'),(6,NULL,'978035838023',NULL,'The Lord of the Rings: The Fellowship of The Ring (Book 1)','J.R.R. Tolkien',NULL,'9780358380238',NULL,'Bloomsbury',1995,'english','fiction',NULL,'hardcover','6.png',NULL,NULL,NULL,NULL,'book','2024-11-22','NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-09-30 23:45:11','2024-12-02 04:20:40'),(7,NULL,'789453697158',NULL,'The Girl on the Train','Paula Hawkins',NULL,'9781594634024',NULL,'New York Times',2015,'english','thriller',336,'paperback','7.png','Rachel catches the same commuter train every morning. She knows it will wait at the same signal each time, overlooking a row of back gardens. She‚Äôs even started to feel like she knows the people who live in one of the houses. ‚ÄúJess and Jason,‚Äù she calls them. Their life‚Äîas she sees it‚Äîis perfect. If only Rachel could be that happy. And then she sees something shocking. It‚Äôs only a minute until the train moves on, but it‚Äôs enough. Now everything‚Äôs changed. Now Rachel has a chance to become a part of the lives she‚Äôs only watched from afar. Now they‚Äôll see; she‚Äôs much more than just the girl on the train',780.00,NULL,'girl,train,mystery','book','2024-11-01','NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-10-06 00:11:21','2024-12-03 05:52:03'),(8,NULL,'188648678941',NULL,'Harry Potter and the Chamber of Secrets (Book 2)','J.K. Rowling',NULL,'9781338878936',NULL,'Scholastic Inc.',2000,'english','fiction',514,'paperback','8.png','While spending the summer with the Dursleys, the twelve-year-old Harry Potter is visited by Dobby, a house-elf. Dobby says Harry is in danger and must promise not to return to Hogwarts. When Harry refuses, Dobby uses magic to destroy a pudding made by Aunt Petunia. Believing that Harry created the mess, Uncle Vernon locks him in his room. The Ministry of Magic sends a notice accusing Harry of performing underage magic and threatening to expel him from Hogwarts.\r\n\r\nThe Weasley brothers Ron, Fred, and George arrive in their father\'s flying car and take Harry to their home. When Harry and the Weasleys go to Diagon Alley for school supplies, they meet Gilderoy Lockhart, a celebrity author who is the new Defence Against the Dark Arts professor. At King\'s Cross station, Harry and Ron cannot enter Platform 9¬æ to board the Hogwarts Express, so they fly to Hogwarts in the enchanted car.\r\n\r\nDuring the school year, Harry hears a strange voice emanating from the castle walls. Argus Filch\'s cat is found Petrified, along with a warning scrawled on the wall: \"The Chamber of Secrets has been opened. Enemies of the heir, beware\". Harry learns that the Chamber supposedly houses a monster that attacks Muggle-born students, and which only the Heir of Slytherin can control. During a Quidditch match, a rogue Bludger strikes Harry, breaking his arm. Professor Lockhart botches an attempt to mend it, which sends Harry to the hospital wing. Dobby visits Harry and reveals that he jinxed the Bludger and sealed the portal at King\'s Cross. He also tells Harry that house-elves are bound to serve a master, and cannot be freed unless their master gives them clothing.\r\n\r\nAfter another attack from the monster, students attend a defensive duelling class. During the class, Harry displays the rare ability to speak Parseltongue, the language of snakes. Moaning Myrtle, a ghost who haunts a bathroom, shows Harry and his friends a diary that was left in her stall. It belonged to Tom Riddle, a student who witnessed another student\'s death when the Chamber was last opened. During the next attack by the monster, Hermione Granger is Petrified.\r\n\r\nHarry and Ron discover that the monster is a Basilisk, a gigantic snake that can kill victims with a direct gaze and Petrify them with an indirect gaze. Harry realizes the Basilisk is producing the voice he hears in the walls. After Ron\'s sister Ginny is abducted and taken into the Chamber, Harry and Ron discover the Chamber entrance in Myrtle\'s bathroom. When they force Lockhart to enter with them, he confesses that the stories he told of his heroic adventures are fabrications. He attempts to erase the boys\' memories, but his spell backfires and obliterates his own memory.\r\n\r\nHarry finds an unconscious Ginny in the Chamber. A manifestation of Tom Riddle appears and reveals that he is Lord Voldemort and the Heir of Slytherin. After explaining that he opened the Chamber, Riddle summons the Basilisk to kill Harry. Dumbledore\'s phoenix Fawkes arrives, bringing Harry the Sorting Hat. While Fawkes blinds the Basilisk, Harry pulls the Sword of Gryffindor from the Hat. He slays the serpent, then stabs the diary with a Basilisk fang, destroying it and the manifestation of Riddle. Later, Harry liberates Dobby by tricking his master into giving him clothing. At the end of the novel, the Petrified students are cured and Gryffindor wins the House Cup.',3199.00,NULL,'harry,potter,chamber,secrets,mystery,serpent,sword','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-10-17 08:01:40','2024-12-03 05:52:19'),(9,NULL,'198746718641',NULL,'Harry Potter and the Sorcerer\'s Stone (Book 1)','J.K. Rowling',NULL,'9781338878929',NULL,'Scholastic Inc.',1998,'english','fiction',NULL,'paperback','9.png',NULL,480.00,NULL,'harry,potter,sorcerer,stone','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-10-26 01:52:11','2024-12-03 05:52:32'),(10,NULL,'574785214788',NULL,'Harry Potter and the Goblet of Fire (Book 4)','J.K. Rowling',NULL,'9781338878950',NULL,'Scholastic Inc.',2008,'english','fiction',NULL,'paperback','10.png',NULL,650.00,NULL,'harry,potter,goblet,fire','book','2024-11-08','NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-10-26 02:24:03','2024-12-03 05:52:53'),(11,NULL,'979848796354',NULL,'Harry Potter and the Order of the Phoenix (Book 5)','J.K. Rowling',NULL,'9781338878967',NULL,'Scholastic Inc.',2012,'english','fiction',NULL,'paperback','11.png',NULL,NULL,NULL,'harry,potter,order,phoenix','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'checked out','2024-10-26 02:28:45','2024-11-23 03:58:13'),(12,NULL,'359785789146',NULL,'Harry Potter and the Half-Blood Prince (Book 6)','J.K. Rowling',NULL,'9781338878974',NULL,'Scholastic Inc.',2006,'english','fiction',NULL,'paperback','12.png',NULL,780.00,NULL,'harry,potter,half-blood,prince','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'checked out','2024-10-26 02:31:34','2024-11-19 13:16:14'),(13,NULL,'789425894136',NULL,'Harry Potter and the Deathly Hallows (Book 7)','J.K. Rowling',NULL,'9781338878981',NULL,'Scholastic Inc.',2018,'english','fiction',NULL,'paperback','13.png',NULL,820.00,NULL,'harry,potter,deathly,hallows','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-10-26 02:34:09','2024-12-03 05:53:12'),(14,NULL,'178457588478',NULL,'The Lord of the Rings: The Fellowship of The Ring (Book 1)','J.R.R. Tolkien',NULL,'9780358380238',NULL,'Bloomsbury',1995,'english','fiction',NULL,'hardcover','14.png',NULL,820.00,NULL,NULL,'book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-10-26 02:38:10','2024-12-03 05:53:24'),(15,NULL,'458976563147',NULL,'The Lord of the Rings: The Two Towers (Book 2)','J.R.R. Tolkien',NULL,'9780358380245',NULL,'Clarion Books',2000,'english','fiction',NULL,'paperback','15.png',NULL,820.00,NULL,'lord,ring,two towers','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-10-26 02:41:39','2024-12-03 05:53:36'),(16,NULL,'498746711256',NULL,'The Lord of the Rings: The Return of The King (Book 3)','J.R.R. Tolkien',NULL,'9780358380252',NULL,'Clarion Books',2000,'english','fiction',NULL,'paperback','16.png',NULL,820.00,NULL,'lord,ring,return,king','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'checked out','2024-10-26 02:47:00','2024-11-21 14:12:50'),(17,NULL,'578941347893',NULL,'The Hobbit: A Graphic Novel: An Enchanting Fantasy Adventure (Hobbit Fantasy Classic)','J.R.R. Tolkien',NULL,'9780063388468',NULL,'William Morrow Paperbacks',2024,'english','fiction',NULL,'paperback','9780063388468.png',NULL,NULL,NULL,'hobbit','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-10-28 05:18:39','2024-12-03 05:53:47'),(18,NULL,'578941347894',NULL,'The Hobbit: A Graphic Novel: An Enchanting Fantasy Adventure (Hobbit Fantasy Classic)','J.R.R. Tolkien',NULL,'9780063388468',NULL,'William Morrow Paperbacks',2024,'english','fiction',NULL,'paperback','9780063388468.png',NULL,NULL,NULL,'hobbit','book',NULL,'NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-10-28 05:36:44','2024-12-03 05:54:01'),(19,NULL,'111221345522',NULL,'Image Processing and Searching','Daniel Klein,Dean Jackson',NULL,NULL,NULL,'Technical Disclosure Commons',2015,'english','developmental',11,'paperback',NULL,'An image searching system is used to provide images in response to a query. The images can be captured by one or more users over a certain period of time. The system receives a query to search for images. The system parses the query and determines a type of request. The system then processes and searches for images in response to the determined request type. The system then presents the images to the user.',NULL,NULL,'image processing,image,searching','research','2024-11-19','NEUST-PPY-LIB','thesis',NULL,NULL,'available','2024-11-05 01:38:09','2024-12-03 06:27:25'),(20,NULL,'134455667774',NULL,'Image Processing and Searching','Daniel Klein,Dean Jackson',NULL,NULL,NULL,'Technical Disclosure Commons',2015,'english','developmental',11,'paperback','','An image searching system is used to provide images in response to a query. The images can be captured by one or more users over a certain period of time. The system receives a query to search for images. The system parses the query and determines a type of request. The system then processes and searches for images in response to the determined request type. The system then presents the images to the user.',NULL,NULL,'image processing,image,searching','research','2024-11-19','NEUST-PPY-LIB','thesis',NULL,NULL,'no barcode','2024-11-05 03:21:26','2024-11-28 03:22:25'),(22,NULL,'132547654789',NULL,'Where Are You Now','Honor Society',NULL,NULL,NULL,'BandSlam Inc.',2000,'english','romance',NULL,NULL,'22.png',NULL,NULL,NULL,NULL,'audio','2024-11-19','NEUST-PPY-LIB','audio-visual',NULL,225,'no barcode','2024-11-05 07:13:00','2024-11-28 02:51:45'),(23,NULL,'178466548415',NULL,'Sky High','Mike Mitchell',NULL,NULL,NULL,'Walt Disney Pictures',2005,'english','fiction',NULL,NULL,'23.png','At a school in the sky where teens learn how to be superheroes, Will Stronghold (Michael Angarano) lands in a class for students who show special promise. Classmate Gwen (Mary Elizabeth Winstead) quickly cozies up to Will, but it\'s soon clear that she has other motives. When he learns that Gwen\'s mother is a villain who was defeated by his father, Steve Stronghold (Kurt Russell), Will realizes that Gwen is aiming for revenge, and he rushes to a school dance in the hope of stopping her.',NULL,NULL,'superhero,sky high,sky,high','video','2024-10-01','NEUST-PPY-LIB','audio-visual',NULL,6000,'no barcode','2024-11-05 07:58:32','2024-11-28 02:52:09'),(24,NULL,'574785214789',NULL,'Harry Potter and the Goblet of Fire (Book 4)','J.K. Rowling',NULL,'9781338878950',NULL,'Scholastic Inc.',2008,'english','fiction',NULL,'paperback','24.png',NULL,650.00,NULL,'harry,potter,goblet,fire','book','2024-11-08','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-08 02:05:42','2024-11-19 13:18:29'),(25,NULL,NULL,NULL,'Sky High','Mike Mitchell',NULL,NULL,NULL,'Walt Disney Pictures',2005,'english','fiction',NULL,NULL,'25.png','At a school in the sky where teens learn how to be superheroes, Will Stronghold (Michael Angarano) lands in a class for students who show special promise. Classmate Gwen (Mary Elizabeth Winstead) quickly cozies up to Will, but it\'s soon clear that she has other motives. When he learns that Gwen\'s mother is a villain who was defeated by his father, Steve Stronghold (Kurt Russell), Will realizes that Gwen is aiming for revenge, and he rushes to a school dance in the hope of stopping her.',NULL,NULL,'superhero,sky high,sky,high','video',NULL,'NEUST-PPY-LIB','audio-visual',NULL,6000,'no barcode','2024-11-08 07:51:31','2024-11-28 02:52:00'),(26,NULL,NULL,NULL,'Where Are You Now','Honor Society',NULL,NULL,NULL,'BandSlam Inc.',2000,'english','romance',NULL,NULL,'26.png',NULL,NULL,NULL,NULL,'audio',NULL,'NEUST-PPY-LIB','audio-visual',NULL,225,'no barcode','2024-11-08 07:52:46','2024-11-28 02:51:33'),(27,NULL,NULL,NULL,'Introduction to PC Hardware and Troubleshooting','Mike Mayers',NULL,'0-07-125211-8',NULL,'Osborne',2006,'english','non-fiction',447,'hardcover','27.png',NULL,750.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 14:04:28','2024-11-25 14:04:33'),(28,NULL,NULL,NULL,'CSS and Networking Guide for CCNA and CSS (NCII)','Marygin E. Sarmiento, Ph.d; Marmelo V. Abante, Ph.D; Rolando R. Lansigan, Ph.D; Luisa M. Macatangay, Ph.D; Jaime Sebastian S. Mendiola;  Kenneth A. Cambaya',NULL,'978-621-427-046-0',NULL,'Unlimited Books Library Services & Publishing Inc',2019,'english','fiction',366,'hardcover','28.png',NULL,575.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 14:15:08','2024-11-25 14:15:08'),(29,NULL,NULL,NULL,'Operating Systems (Second Edition)','Ron Carswell; Terrill Fresse; Shen Jiang',NULL,'978-981-4510-91-2',NULL,'Philmont Academic Solutions, Inc',2013,'english','non-fiction',612,'hardcover','29.png',NULL,500.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 14:25:19','2024-11-25 14:25:19'),(30,NULL,NULL,NULL,'WordPress ALL-IN-ONE for Dummies A Wiley Brand','Lisa Sabin-Wilson',NULL,'9781394225385',NULL,'Media and Software Compilation',2024,'english','fiction',608,'hardcover','30.png',NULL,2397.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 14:34:11','2024-11-25 15:33:36'),(31,NULL,NULL,NULL,'Essential Computer Hardware','Kevin Wilson',NULL,'1911174592',NULL,'Elluminet Press',2017,'english','non-fiction',230,'hardcover','31.png',NULL,230.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 14:41:13','2024-11-25 14:41:14'),(32,NULL,NULL,NULL,'Clean Code: A Handbook of Agile Software Craftsmanship','Robert C. Martin',NULL,'9780132350884',NULL,'MIT Press',2008,'english','non-fiction',464,'hardcover',NULL,NULL,750.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 14:47:57','2024-11-25 14:47:57'),(33,NULL,NULL,NULL,'Introduction to Algorithms, 3rd Edition','Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein',NULL,'9780262033848',NULL,'MIT Press',2019,'english','non-fiction',1312,'hardcover','33.png',NULL,3500.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 14:49:53','2024-11-25 14:49:53'),(34,NULL,NULL,NULL,'Code: The Hidden Language of Computer Hardware and Software','Charles Petzold',NULL,'9780735611313',NULL,'Microsoft Press',2000,'english','non-fiction',393,'hardcover','34.png',NULL,550.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 14:55:28','2024-11-25 14:55:28'),(35,NULL,NULL,NULL,'Algorithms, 4th Edition','Robert Sedgewick, Kevin Wayne',NULL,'9780321573513',NULL,'Addison-Wesley',2011,'english','non-fiction',976,'hardcover','35.png',NULL,760.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 14:57:42','2024-11-25 14:57:42'),(36,NULL,NULL,NULL,'The Pragmatic Programmer: Your Journey to Mastery, 20th Anniversary Edition','Andrew Hunt, David Thomas',NULL,'9780135957059',NULL,'Addison-Wesley Professional',2019,'english','non-fiction',352,'hardcover','36.png',NULL,1750.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:01:57','2024-11-25 15:01:57'),(37,NULL,NULL,NULL,'The C Programming Language, 2nd Edition','Prentice Hall',NULL,'9780131103627',NULL,'Prentice Hall',2018,'english','non-fiction',288,'hardcover','37.png',NULL,NULL,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:09:49','2024-11-25 15:09:49'),(38,NULL,NULL,NULL,'Python Crash Course, 2nd Edition','Eric Matthes',NULL,'9781593279288',NULL,'No Starch Press',2019,'english','non-fiction',544,'hardcover','38.png',NULL,1890.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:22:36','2024-11-25 15:22:37'),(39,NULL,NULL,NULL,'Head First Java, 2nd Edition','Kathy Sierra, Bert Bates',NULL,'9780596009205',NULL,'O\'Reilly Media',2005,'english','non-fiction',720,'hardcover','39.png',NULL,2550.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:25:38','2024-11-25 15:25:38'),(40,NULL,NULL,NULL,'Design Patterns: Elements of Reusable Object-Oriented Software','Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides',NULL,'9780201633610',NULL,'Addison-Wesley Professional',1994,'english','non-fiction',395,'hardcover','40.png',NULL,879.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:28:19','2024-11-25 15:28:19'),(41,NULL,NULL,NULL,'Algorithms to Live By: The Computer Science of Human Decisions','Brian Christian, Tom Griffiths',NULL,'9781627790369',NULL,'Henry Holt and Co.',2016,'english','fiction',368,'hardcover','41.png',NULL,890.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:29:48','2024-11-25 15:30:47'),(42,NULL,NULL,NULL,'The Lean Startup','Eric Ries',NULL,'9780307887894',NULL,'Crown Business',2011,'english','fiction',336,'hardcover','42.png',NULL,999.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:40:16','2024-11-25 15:40:16'),(43,NULL,NULL,NULL,'Good to Great','Jim Collins',NULL,'9780066620992',NULL,'Harper Business',2001,'english','non-fiction',320,'hardcover','43.png',NULL,1500.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:43:44','2024-11-25 15:43:44'),(44,NULL,NULL,NULL,'Blue Ocean Strategy','W. Chan Kim, Ren√©e Mauborgne',NULL,'9781591396192',NULL,'Harvard Business Review Press',2005,'english','fiction',240,'hardcover','44.png',NULL,1350.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:46:39','2024-12-02 02:08:28'),(45,NULL,'789453651478',NULL,'The Hard Thing About Hard Things','Ben Horowitz',NULL,'9780062273208',NULL,'Harper Business',2014,'english','fiction',304,'hardcover','45.png',NULL,1250.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'available','2024-11-25 15:50:47','2024-12-02 04:32:39'),(46,NULL,'365417458941',NULL,'How to Win Friends and Influence People','Dale Carnegie',NULL,'9780671027032',NULL,'Simon & Schuster',1936,'english','non-fiction',291,'hardcover','46.png',NULL,670.00,NULL,NULL,'book','2024-11-25','NEUST-PPY-LIB','circulation',NULL,NULL,'no barcode','2024-11-25 15:59:27','2024-12-02 02:09:30'),(47,NULL,'784941489745',NULL,'Noli Me Tangere (Touch Me Not)','Jose Rizal',NULL,'9780143039693',NULL,'Penguin Classics',2006,'english','fiction',NULL,'paperback','47.png',NULL,NULL,NULL,NULL,'book','2024-11-28','NEUST-PPY-LIB','filipiniana',NULL,NULL,'no barcode','2024-11-28 03:07:06','2024-12-02 01:17:59'),(48,NULL,'198646545774',NULL,'El Filibusterismo (Penguin Classics)','Jose Rizal',NULL,'9780143106395',NULL,'Penguin Classics',2011,'english','fiction',NULL,'paperback','48.png',NULL,NULL,NULL,NULL,'book','2024-11-28','NEUST-PPY-LIB','filipiniana',NULL,NULL,'no barcode','2024-11-28 03:10:52','2024-12-02 01:15:13');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (9,'default','{\"uuid\":\"a50147a1-bad4-442f-b3ec-078d80c3460a\",\"displayName\":\"App\\\\Jobs\\\\BackupDatabaseJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\BackupDatabaseJob\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\BackupDatabaseJob\\\":0:{}\"}}',1,1733233733,1733233733,1733233733);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libraries`
--

DROP TABLE IF EXISTS `libraries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `libraries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `libraries_name_unique` (`name`),
  UNIQUE KEY `libraries_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libraries`
--

LOCK TABLES `libraries` WRITE;
/*!40000 ALTER TABLE `libraries` DISABLE KEYS */;
INSERT INTO `libraries` VALUES (16,'NEUST-PPY-LIB','Library of NEUST - Papaya','papaya.ils.ph','General Tinio, Nueva Ecija','..','2024-09-09 00:38:08','2024-10-01 20:06:12');
/*!40000 ALTER TABLE `libraries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loaned_items`
--

DROP TABLE IF EXISTS `loaned_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loaned_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `date_loaned` date NOT NULL,
  `due_date` date NOT NULL,
  `date_returned` date DEFAULT NULL,
  `loaner_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'checked out',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loaned_items`
--

LOCK TABLES `loaned_items` WRITE;
/*!40000 ALTER TABLE `loaned_items` DISABLE KEYS */;
INSERT INTO `loaned_items` VALUES (15,'book','198746718641','2024-10-29','2024-11-05','2024-10-29',19,'returned','2024-10-29 14:44:11','2024-10-29 14:49:44'),(16,'book','188648678941','2024-10-29','2024-11-05','2024-10-29',19,'returned','2024-10-29 15:05:06','2024-10-29 15:06:15'),(17,'book','188648678941','2024-10-29','2024-11-05','2024-10-29',20,'returned','2024-10-29 15:51:35','2024-10-29 15:59:28'),(18,'book','147866542874','2024-10-30','2024-11-06','2024-10-30',19,'returned','2024-10-29 16:44:25','2024-10-29 16:45:00'),(19,'book','574785214789','2024-10-30','2024-11-06','2024-10-30',20,'returned','2024-10-29 16:53:36','2024-10-29 16:54:02'),(20,'book','979848796354','2024-10-30','2024-11-06','2024-10-30',19,'returned','2024-10-29 16:56:39','2024-10-29 16:56:54'),(21,'book','574785214789','2024-10-30','2024-11-06','2024-11-08',19,'returned','2024-10-29 16:59:17','2024-11-08 07:23:31'),(22,'book','359785789146','2024-10-30','2024-11-06',NULL,19,'checked out','2024-10-29 16:59:55','2024-11-21 07:19:17'),(23,'book','188648678941','2024-11-21','2024-11-28',NULL,19,'checked out','2024-11-21 13:34:12','2024-11-21 13:34:12'),(24,'book','498746711256','2024-11-21','2024-11-28',NULL,19,'checked out','2024-11-21 13:41:07','2024-11-21 13:41:07'),(25,'book','979848796354','2024-11-23','2024-11-30',NULL,23,'checked out','2024-11-23 03:58:13','2024-11-23 03:58:13'),(26,'book','458976563147','2024-11-23','2024-11-30','2024-11-23',23,'returned','2024-11-23 05:22:48','2024-11-23 05:24:05'),(27,'book','458976563147','2024-11-23','2024-11-30','2024-11-23',23,'returned','2024-11-23 05:26:00','2024-11-23 05:27:04');
/*!40000 ALTER TABLE `loaned_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_08_21_125536_create_libraries_table',2),(5,'2024_08_28_012241_create_campuses_table',3),(6,'2024_08_28_082509_create_colleges_table',4),(7,'2024_09_09_025017_add_code_on_library_and_campus',5),(8,'2024_09_09_054337_create_programs_table',5),(21,'2024_09_11_015423_create_books_table',6),(22,'2024_09_17_055707_create_students_table',6),(23,'2024_09_18_074159_create_teachers_table',7),(25,'2024_09_26_123244_create_staffs_table',8),(26,'2024_10_01_065857_add_library_to_books_table',9),(27,'2024_10_01_075645_add_library_to_teachers_table',10),(28,'2024_10_01_081214_add_library_to_students_table',11),(33,'2024_10_14_060440_create_researches_table',12),(34,'2024_10_14_140214_create_media_discs_table',13),(35,'2024_10_17_022725_update_tags_attribute',14),(37,'2024_10_19_010915_create_tokens_table',15),(38,'2024_10_21_133155_create_requested_items_table',16),(39,'2024_10_21_133242_create_loaned_items_table',16),(43,'2024_10_23_180328_use_id_number_for_patrons',17),(44,'2024_10_23_221654_add_card_number_column_to_user',17),(45,'2024_10_24_103303_add_status_column_to_requested_items_table',18),(46,'2024_10_24_131022_add_status_column_to_loaned_items_table',19),(48,'2024_10_24_213940_create_user_details_table',20),(49,'2024_10_25_014852_rename_barcode_number_column_in_books_table',21),(50,'2024_10_25_162940_add_due_date_to_requested_items_table',22),(51,'2024_10_25_165939_add_date_returned_to_loaned_items_table',23),(52,'2024_10_28_100105_create_items_table',24),(53,'2024_10_28_112930_rename_books_table_to_items_table',25),(55,'2024_10_28_114513_add_type_column_to_items_table',26),(56,'2024_11_04_222618_replace_lcc_ddc_number_with_call_number_items_table',27),(58,'2024_11_05_085428_add_columns_for_research_items_table',28),(59,'2024_11_05_143526_add_duration_column_to_items_table',29),(60,'2024_11_08_094700_add_date_acquired_to_items_table',30),(62,'2024_11_08_205811_add_pin_to_users_table',31),(64,'2024_11_10_153657_create_face_encodings_table',32),(66,'2024_11_14_090308_create_attendance_table',33),(68,'2024_11_23_014033_create_reported_items_table',34),(69,'2024_11_25_224616_add_section_to_items_table',35);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `program_length` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `programs_code_unique` (`code`),
  UNIQUE KEY `programs_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programs`
--

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;
INSERT INTO `programs` VALUES (1,'BSIT','Bachelor of Science in Information Technology','..','CICT',4,'2024-09-08 22:30:59','2024-09-08 22:50:20'),(3,'BSBA','Bachelor of Science in Business Administration','..','CMBT',4,'2024-09-16 23:26:05','2024-09-16 23:26:05'),(4,'BEED','Bachelor of Elementary Education','..','COED',4,'2024-09-16 23:26:41','2024-09-16 23:26:41'),(5,'BSED','Bachelor of Secondary Education','..','COED',4,'2024-09-16 23:27:19','2024-09-16 23:27:19');
/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reported_items`
--

DROP TABLE IF EXISTS `reported_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reported_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `barcode` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reported_items_barcode_unique` (`barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reported_items`
--

LOCK TABLES `reported_items` WRITE;
/*!40000 ALTER TABLE `reported_items` DISABLE KEYS */;
INSERT INTO `reported_items` VALUES (1,'1478665428748','damaged','Too many of the pages are torn and missing. Even the front page is missing',5,1,'2024-11-22 18:09:59','2024-11-22 18:09:59');
/*!40000 ALTER TABLE `reported_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requested_items`
--

DROP TABLE IF EXISTS `requested_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requested_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `date_requested` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `requester_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requested_items`
--

LOCK TABLES `requested_items` WRITE;
/*!40000 ALTER TABLE `requested_items` DISABLE KEYS */;
INSERT INTO `requested_items` VALUES (26,'book','198746718641','2024-10-29','2024-11-01',19,'checked out','2024-10-29 14:40:18','2024-10-29 14:44:11'),(28,'book','178457588478','2024-10-30','2024-11-02',20,'cancelled','2024-10-29 16:05:46','2024-10-29 16:29:23'),(29,'book','574785214789','2024-10-30','2024-11-02',20,'checked out','2024-10-29 16:46:30','2024-10-29 16:53:36'),(31,'book','188648678941','2024-11-21','2024-11-24',19,'checked out','2024-11-21 12:30:56','2024-11-21 13:34:12'),(32,'book','498746711256','2024-11-21','2024-11-24',19,'checked out','2024-11-21 13:36:36','2024-11-21 13:41:07'),(33,'book','178466548415','2024-11-22','2024-11-28',20,'cancelled','2024-11-22 04:03:37','2024-11-25 12:38:49'),(34,'book','979848796354','2024-11-23','2024-11-26',23,'checked out','2024-11-23 03:49:37','2024-11-23 03:58:13'),(35,'book','458976563147','2024-11-23','2024-11-26',23,'checked out','2024-11-23 05:19:32','2024-11-23 05:22:48'),(36,'book','178457588478','2024-11-25',NULL,20,'pending','2024-11-25 12:32:34','2024-11-25 12:32:34');
/*!40000 ALTER TABLE `requested_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('eO8p25yw1BtZqwgqRm4XM8jvQNAQEsJsq8Mj4ids',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT3FBSmRjN2QwMGhDclA5aVlkQ0pkZ3lpcm82RGtJRE1UR1kydmx1ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ub3RpZmljYXRpb25zL2xpYnJhcnlfc2VydmljZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1733233709),('JCZArcAnPOhAdUAQAPk4QV1hw4rkExIqcRcBWQrP',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM1FoT1FRVEdqYllRc0sxSFRiTWZLbEFqUGpUQnd2TGQ4b20zTHJXSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ub3RpZmljYXRpb25zL2xpYnJhcnlfc2VydmljZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjcwOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvY29sbGVjdGlvbnMvaXRlbXMvQmx1ZSUyME9jZWFuJTIwU3RyYXRlZ3kvZGV0YWlsIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1733214646);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `purpose` varchar(255) NOT NULL,
  `expiration` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `card_number` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `birthday` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `library` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `college` varchar(255) DEFAULT NULL,
  `campus` varchar(255) DEFAULT NULL,
  `academic_rank` varchar(255) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_details_card_number_unique` (`card_number`),
  UNIQUE KEY `user_details_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` VALUES (1,'NEUST-F-002','JUAN',NULL,'DELA CRUZ',NULL,'male','2003-10-24','juan.delacruz.01.11.2001@gmail.com','09157149207',NULL,NULL,NULL,'NEUST-F-002.png','NEUST-PPY-LIB','active','librarian',NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-24 15:16:48','2024-11-15 07:40:15'),(4,'NEUST-F-500','melody',NULL,'barnes',NULL,'female','2007-08-20','melody.barnes@gmail.com',NULL,NULL,NULL,NULL,'NEUST-F-500.png','NEUST-PPY-LIB','active','teacher','CICT','NEUST-PPY','lecturer',NULL,NULL,NULL,'2024-10-24 17:08:06','2024-11-07 18:50:45'),(6,'NEUST-F-501','MARTIN',NULL,'CORS',NULL,'male','1994-10-29','martin.cors@gmail.com',NULL,NULL,NULL,NULL,'NEUST-F-501.png','NEUST-PPY-LIB','active','teacher','COED','NEUST-PPY','instructor iii',NULL,NULL,NULL,'2024-10-24 17:14:12','2024-10-24 17:21:07'),(7,'NEUST-F-932','christian',NULL,'pe√±a',NULL,'male','1994-06-16','christian940616@gmail.com','09694708031',NULL,'GENERAL TINIO','NUEVA ECIJA','NEUST-F-932.png','NEUST-PPY-LIB','active','teacher','CICT','NEUST-PPY','lecturer',NULL,NULL,NULL,'2024-10-24 17:30:22','2024-10-25 01:22:43'),(8,'NEUST-P-100','elioth',NULL,'coder',NULL,'male','1994-10-16','elioth.coder@gmail.com',NULL,NULL,NULL,NULL,'NEUST-P-100.png','NEUST-PPY-LIB','active','student','CICT','NEUST-PPY',NULL,'BSIT',4,'A','2024-10-24 19:17:17','2024-11-10 03:00:11'),(10,'NEUST-T-00001','angel',NULL,'locsin',NULL,'female','1997-11-05','angel.locsin@gmail.com',NULL,NULL,NULL,NULL,'NEUST-T-00001.png','NEUST-PPY-LIB','active','student','CICT','NEUST-PPY',NULL,'BSIT',2,'A','2024-11-10 10:38:20','2024-11-10 10:38:24'),(11,'NEUST-F-001','elioth',NULL,'barker',NULL,'male','1994-06-16','elioth.barker@gmail.com','09694708031',NULL,NULL,NULL,'NEUST-F-001.png','NEUST-PPY-LIB','active','admin',NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-24 15:16:48','2024-12-02 08:41:14'),(12,'NEUST-F-00001','maria nina',NULL,'reyes',NULL,'female','2008-06-19','marianina.reyes04@gmail.com',NULL,NULL,NULL,NULL,'NEUST-F-00001.png','NEUST-PPY-LIB','active','student','COED','NEUST-PPY',NULL,'BSED',1,'A','2024-11-21 14:48:08','2024-11-22 02:04:39'),(13,'NEUST-F-00002','marian',NULL,'rivera',NULL,'female','1992-03-05','marian.rivera019@gmail.com',NULL,NULL,NULL,NULL,'NEUST-F-00002.png','NEUST-PPY-LIB','active','student','CMBT','NEUST-PPY',NULL,'BSBA',4,'A','2024-11-22 13:12:40','2024-11-22 13:12:44'),(15,'NEUST-F-923','edward','mirasol','mansibang',NULL,'male','1985-01-12','ewamansibang@gmail.com','09166902122',NULL,NULL,NULL,'NEUST-F-923.png','NEUST-PPY-LIB','active','teacher','CICT','NEUST-PPY','instructor i',NULL,NULL,NULL,'2024-11-23 03:30:28','2024-11-23 03:32:46');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `pin` varchar(255) DEFAULT '0000',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'elioth barker','elioth.barker@gmail.com','2024-08-20 00:16:29','$2y$12$zcPJE7rJSVLEzKz8YkG4ue6Y6hteFhQV2EoqJMIrxD01lXxXqR8w.','admin','NEUST-F-001','0000','L45f1PznJ84TLaQGpBVlGZs8i80gYWAIiq2A8byuuNWziPpE40LpOLIvVVXc','2024-08-20 00:16:30','2024-11-15 07:33:26'),(16,'JUAN DELA CRUZ','juan.delacruz.01.11.2001@gmail.com',NULL,'$2y$12$sLzI0QOAWHCV93RHVDE0FOpOgslIusKc34Ls5DS0WnHlI9MZCzHI2','librarian','NEUST-F-002','0000',NULL,'2024-10-24 15:16:48','2024-10-24 15:16:48'),(19,'christian pe√±a','christian940616@gmail.com','2024-10-24 17:45:40','$2y$12$FN5MmjLR5PmJTif3vwWZ5u1BjNOUO1vcH/8nck.XgHmfvRYiBeIAi','teacher','NEUST-F-932','0000',NULL,'2024-10-24 17:45:40','2024-10-25 01:22:43'),(20,'Elioth Coder','elioth.coder@gmail.com','2024-10-24 19:57:48','$2y$12$bhkxRA/fb.XWR.nV7Q7kteZpT1CjWGXSA2hvycVhqHJ.hxnjIhTzq','student','NEUST-P-100','8888',NULL,'2024-10-24 19:57:48','2024-12-02 09:01:37'),(21,'maria nina reyes','marianina.reyes04@gmail.com','2024-11-21 14:55:03','$2y$12$7fnBvS3RrWtCYB8Sa/MSM.Q9lVQehHFVl06d9jIo56QawPhbEYgBK','student','NEUST-F-00001','0000',NULL,'2024-11-21 14:55:03','2024-11-21 14:55:03'),(23,'edward mansibang','ewamansibang@gmail.com','2024-11-23 03:33:44','$2y$12$nw1SVa20tYe6jiVXUTQ5fuu89ftulFSfEBK.ZHxYSkKG1Y5qibMWG','teacher','NEUST-F-923','0000',NULL,'2024-11-23 03:33:44','2024-11-23 03:33:44');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'test_ils'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-03 21:48:55
