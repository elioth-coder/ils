-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 06:00 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ils`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `card_number`, `name`, `role`, `created_at`, `updated_at`) VALUES
(1, 'NEUST-F-932', 'christian peña', 'teacher', '2024-11-14 01:42:19', '2024-11-14 01:42:19'),
(2, 'NEUST-F-932', 'christian peña', 'teacher', '2024-11-15 06:32:13', '2024-11-15 06:32:13'),
(3, 'NEUST-F-932', 'christian peña', 'teacher', '2024-11-22 01:58:47', '2024-11-22 01:58:47'),
(4, 'NEUST-F-932', 'christian peña', 'teacher', '2024-11-22 14:41:46', '2024-11-22 14:41:46'),
(5, 'NEUST-P-100', 'Elioth Coder', 'student', '2024-11-22 14:43:11', '2024-11-22 14:43:11'),
(6, 'NEUST-F-923', 'edward mansibang', 'teacher', '2024-11-23 04:50:37', '2024-11-23 04:50:37'),
(7, 'NEUST-F-932', 'christian peña', 'teacher', '2024-11-23 05:11:18', '2024-11-23 05:11:18'),
(8, 'NEUST-F-923', 'edward mansibang', 'teacher', '2024-11-23 05:11:36', '2024-11-23 05:11:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campuses`
--

CREATE TABLE `campuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campuses`
--

INSERT INTO `campuses` (`id`, `code`, `name`, `address`, `description`, `created_at`, `updated_at`) VALUES
(4, 'NEUST-PPY', 'NEUST Papaya Off-Campus', 'General Tinio', '..', '2024-09-09 17:13:39', '2024-09-09 17:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'CICT', 'College of Information and Communications Technology', 'Some descriptions', '2024-08-28 00:55:40', '2024-08-28 00:56:11'),
(2, 'CMBT', 'College of Management and Business Technology', '..', '2024-09-08 22:27:27', '2024-09-08 22:27:27'),
(3, 'COED', 'College of Education', '..', '2024-09-08 22:27:43', '2024-09-08 22:27:43'),
(4, 'CIT', 'College of Industrial Technology', 'New College', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `face_encodings`
--

CREATE TABLE `face_encodings` (
  `card_number` varchar(255) NOT NULL,
  `encodings` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `face_encodings`
--

INSERT INTO `face_encodings` (`card_number`, `encodings`) VALUES
('NEUST-F-932', 0x8004958b040000000000008c156e756d70792e636f72652e6d756c74696172726179948c0c5f7265636f6e7374727563749493948c056e756d7079948c076e6461727261799493944b0085944301629487945294284b014b80859468038c0564747970659493948c02663894898887945294284b038c013c944e4e4e4affffffff4affffffff4b0074946289420004000000000080e34dbabf00000040c1efba3f00000040eaccb33f00000040b759acbf00000020356c9f3f0000000000649ebf000000a0aa0b933f00000020560bc6bf00000020ce67c83f000000e02acabfbf000000603fe3d03f00000000624092bf000000e05c17c8bf00000020d746c1bf00000080778d9b3f000000e0c9cfc33f000000805632c3bf000000e0907fc3bf000000e0c035aebf000000408384a4bf00000080b45b7ebf000000c0a137a4bf0000002083d8a83f000000007a88a23f000000e06373b3bf000000c08d1bd9bf0000000071bcbabf00000020b98bb7bf0000002076a4933f00000020a2e761bf000000a0209fa1bf000000e0f5d7863f000000201906d1bf000000e0f363a2bf0000008098369bbf000000807a50bd3f00000080cb7aa4bf000000a0ef2c90bf000000e00aa0c83f00000000f3f86e3f000000201738c6bf000000a0554ba9bf000000404b777fbf000000a0c7f9cf3f00000020d5b2bd3f000000a0378d8f3f00000080352dac3f000000a00ba9a2bf000000e092f6a43f00000060b237c2bf0000000051f3ba3f00000080f56bbc3f000000e09855bc3f000000a099d0b73f00000020f54791bf000000a0deadc2bf00000040446f7fbf00000040becfb13f000000a04866c1bf000000c0b20fad3f000000801e6eb53f00000080c15bbdbf00000000d992babf000000005f1949bf000000202b93d03f000000c0d397bf3f000000800c32c0bf000000c0749ac1bf00000040c133c43f000000a01825b9bf00000040338760bf000000405314813f000000e01423c5bf000000e0ed03cabf000000003860d2bf000000809cb8c13f000000400f30d53f000000206403bc3f000000000c37c7bf000000c0a18c77bf000000405252b1bf000000001b80a13f000000604c5ab83f000000c01051c53f00000000309588bf00000000f3c4bf3f000000a001d2b3bf000000c06287b93f000000002e1cc13f00000060cdd8aabf00000040e23cb3bf000000e03421cd3f00000060fc52b3bf00000060c822b13f000000205966a1bf000000e0d7d6a23f000000401778753f000000803788b03f000000805709c3bf000000e0fe5ba13f00000060545fc03f00000000956b993f000000c0d3ee5bbf000000a07287b63f000000c06814c2bf00000080d518bc3f000000a0ec4c963f00000000958f863f0000008012d2a03f00000020540c903f000000409c85b8bf000000209cdac0bf000000c0cf82ba3f000000605d94cbbf00000020eacace3f000000c0a0b3cc3f0000006020658c3f000000a0ac2bc33f000000c0012fb33f000000e0df80b23f00000060daf1b43f000000e07f04a9bf000000e0747cc9bf000000a060b98abf000000c0cd61b63f00000060e6cda73f000000007e14ab3f00000000dceea23f947494622e),
('NEUST-T-00001', 0x8004958b040000000000008c156e756d70792e636f72652e6d756c74696172726179948c0c5f7265636f6e7374727563749493948c056e756d7079948c076e6461727261799493944b0085944301629487945294284b014b80859468038c0564747970659493948c02663894898887945294284b038c013c944e4e4e4affffffff4affffffff4b0074946289420004000000000060cff8cabf000000c0ea2dbc3f0000000047e79e3f000000a0a42cb4bf00000080b8f1c2bf000000e0d126b9bf000000e0fdf6adbf000000408151c2bf000000e03a2ab83f00000040eaa3c6bf000000c0e0ebc83f000000a000a7c6bf000000e08bb8c9bf000000001d53b1bf000000605831c0bf00000040ed41c93f000000c0a8e5ccbf000000605433ccbf00000040fa49843f000000005badacbf000000e009d0c13f000000e09a66a9bf000000a0c8a79c3f00000060b196c13f00000080e991c0bf00000000597ed6bf00000000fb6fb9bf00000060a3d7b4bf00000000c995b03f000000c0da54b3bf000000001fba7d3f000000405a688f3f000000405f3acdbf000000a02a4da2bf000000001358543f000000001166c43f000000a0afb9a33f0000002017bdadbf00000040f564c73f00000060e6afb3bf000000206f82d1bf0000000045419abf000000c08cb2c63f000000201ac8d13f00000000bcefbe3f000000c0e66c9f3f0000008035c79bbf00000000f357c1bf000000c0db78c23f000000602fecc3bf000000c06c51983f00000000bcf8c13f000000006277b63f00000040f4b9a43f00000080f541b03f00000000f196b8bf000000602aa3b53f000000e026bfc23f000000203b0bc6bf000000000909433f00000020e416b93f000000c00cafa8bf000000e0fbf28d3f000000209387c2bf000000e05de0ca3f000000e0030baf3f00000020d040adbf000000805fe1ccbf0000000096b6c93f000000c06bcecfbf000000c0bdc4b0bf000000801479c33f000000601b6eafbf00000080950dbdbf000000400371d4bf000000205c02b2bf000000801663d73f00000040be83c33f000000c07d26b8bf000000e09250b23f0000000095a7613f000000a08761acbf000000406915bb3f000000609513c43f00000000992d9bbf00000000ee93b13f00000040c96ac1bf00000080088188bf000000000417cb3f00000080511f9abf000000c0e4c49c3f000000c0d448c53f000000007e98af3f0000008031e2953f00000060b18faf3f000000c0af2a853f00000000d661c9bf0000008055e98e3f000000e0cd21c6bf000000a0faae77bf00000020cb57bcbf000000c063409dbf000000c04704b0bf000000009948b53f000000807928c1bf000000a0fd5db03f00000020b828a1bf000000c0d1fcacbf00000000ddcabebf000000e064a3ad3f000000807c0fb1bf000000407f3bbcbf000000a0006eb23f00000040adeacdbf00000080f3a5b73f00000080935ac83f00000040c058b03f00000060c0d7bd3f000000c026d5ba3f0000000024dab73f000000c03ce790bf0000004068e19dbf000000a06c9cc5bf000000a04f5ea3bf00000060b9b5b13f00000060c6adc2bf0000000041b0a83f0000008047648fbf947494622e),
('NEUST-F-00001', 0x8004958b040000000000008c156e756d70792e636f72652e6d756c74696172726179948c0c5f7265636f6e7374727563749493948c056e756d7079948c076e6461727261799493944b0085944301629487945294284b014b80859468038c0564747970659493948c02663894898887945294284b038c013c944e4e4e4affffffff4affffffff4b0074946289420004000000000060f08ebebf00000080236bb53f00000060b5f3933f000000a0002ca3bf00000060f2cac3bf000000a09b5082bf000000c0e4af9abf000000e02b80c1bf0000002060dcc63f000000800b43c1bf00000020a356cc3f000000a0acbfb6bf00000020cf5fd1bf000000e0fd67aabf00000020900399bf000000c0fd55cd3f000000e01f05d1bf00000080e7d0c1bf00000000b1cf6abf000000e0c8b8a63f000000a07f05ab3f000000c0c25f56bf000000c05588a83f00000000c211b23f000000403653b3bf000000a0cbf8d9bf000000002a86b1bf000000c084efc3bf000000a07e17afbf000000c0fb34b1bf00000000f0a9a3bf000000605965b03f000000406463c5bf000000408af2aabf000000405c888c3f000000409b62a03f00000080b31aa8bf000000e0914bb1bf000000608606ca3f000000c0a136a0bf000000a0030fd1bf00000040fe0fa7bf000000e03a84b43f0000008049f8c93f00000000e281c13f000000a06dc3993f000000006c996ebf0000002093d3c8bf000000602364bd3f000000a0d29cc9bf00000000768a543f000000001ee5bb3f000000a0af296b3f0000000086a2a53f000000809bbf873f000000000c86c3bf000000809e52963f000000e05c64ac3f000000a056d3c1bf000000402a7d8cbf00000020013cbc3f0000000060bbb1bf000000c05599a6bf000000a0d235b9bf000000a0a629d33f000000801cfbb83f00000060138fb4bf00000080e108c6bf000000c0a0f6bd3f0000000003bfc1bf000000a00abbbbbf000000e08955b43f000000800c64c2bf00000000e0f4c7bf00000080c33bd1bf000000806ea6b5bf000000201b07d63f00000080029cb03f000000605a02c5bf00000000d513913f000000606b89b3bf0000006047d49bbf000000809055c23f000000a0e7fdca3f000000200b77a93f0000006097da9a3f000000608c29b3bf000000200c288c3f000000809c88c93f000000607a68bcbf00000080c4aa833f00000080f314d03f0000000031b56d3f00000040ff1db53f000000e02f16a23f00000080ac3b7bbf000000e02d90b1bf000000a0270ba23f000000604575c6bf00000020afeea8bf00000060224ea43f000000406f04a83f00000020ff0b81bf000000c08d3ab93f000000009120c2bf000000e0fce9ac3f00000020b93e64bf00000040b568953f000000402716ab3f00000040bbacb0bf000000c0897eafbf00000040f6d3b5bf000000c05f95c03f000000e05272cbbf000000807db8c73f00000020f455be3f000000609eca9a3f000000c08f0ebc3f000000800ff8a73f000000e04669b33f000000400856b1bf000000e01762a8bf000000409212d2bf000000004f07b03f000000e01b9cc43f00000000ceb591bf000000c08e04a73f000000209552a7bf947494622e),
('NEUST-F-00002', 0x8004958b040000000000008c156e756d70792e636f72652e6d756c74696172726179948c0c5f7265636f6e7374727563749493948c056e756d7079948c076e6461727261799493944b0085944301629487945294284b014b80859468038c0564747970659493948c02663894898887945294284b038c013c944e4e4e4affffffff4affffffff4b00749462894200040000000000e07f35adbf000000007c75b93f00000000c62d44bf0000004086afb1bf000000e037bec4bf000000a06392a03f000000204662b5bf0000000070ceb1bf000000607324ca3f00000020ff6dc0bf00000040b893c33f00000060f3f0c2bf000000e0bc4dd1bf000000a0e517c03f00000020bae6b9bf00000000f7afc53f000000200c2bcabf000000e0fb5ac6bf00000000501fa2bf000000000adfb8bf000000808d6d3d3f00000000d8f8713f000000a05bdeb0bf00000040ed3ec23f000000007aecb4bf00000040eedfd3bf00000060981da13f000000008627a6bf00000040355fb73f0000004099e9b5bf00000080e7647d3f00000080a0fbba3f000000e0c377ccbf00000020f96e9c3f00000040420a763f000000c07f6dc23f00000080e6dc713f00000080c21fc0bf000000405597cd3f00000080995f80bf00000000e32cd1bf00000060ef98b7bf00000060c56cbc3f00000040e9a9d03f0000002037fbc03f000000007feaa53f0000006006fea2bf000000201a36b5bf000000202ccbc13f000000009fc0d4bf000000409cb0a23f00000040ae32c93f000000009a04b13f00000040c046aa3f00000080852ba03f000000e05f1acbbf000000e0941b963f00000060f6cbba3f000000c07937c1bf000000a057669c3f000000a0a00ab53f000000e0f0a6a1bf00000040dfe4963f000000a0b121c1bf000000e0136cd33f000000e0aa77b33f000000e06546b2bf000000c04bb6c5bf0000008029edc83f000000807ddacbbf0000008008a3bbbf000000a0f870c43f000000e041008ebf000000402cfcc3bf000000207736d2bf000000009ced593f000000007063d53f0000008024ffc43f000000a079fab8bf000000407a9cb33f00000040b7a780bf00000080371cb8bf000000802fe6b13f000000002d88c33f000000a0239a83bf00000060618382bf00000040fde5b8bf0000000006565cbf0000004039bad33f000000400474a0bf000000202fe49c3f000000c0baa5ce3f0000000099708c3f000000a0d036a6bf000000209326afbf000000800b5ab73f000000e082c4c2bf00000080771da13f000000804049c2bf0000004037d8abbf000000601360b93f000000e0626bae3f000000c06b8b91bf00000080c7a3c43f0000002059b7d1bf00000000e1a9b43f000000406665b4bf000000a09c18b2bf00000080d5f4ae3f000000e07e906cbf000000c0b218a8bf00000000bb21b6bf00000040dcc7ca3f000000a0585bd2bf000000205697b93f0000004093f6c13f0000008066cfb43f000000809243ba3f000000c08808ad3f000000209344b03f00000020799db73f00000060ae44b9bf000000a084b5cdbf00000060943bbabf000000e05245a43f000000801189b9bf000000e093adb3bf00000020662aab3f947494622e),
('NEUST-F-923', 0x8004958b040000000000008c156e756d70792e636f72652e6d756c74696172726179948c0c5f7265636f6e7374727563749493948c056e756d7079948c076e6461727261799493944b0085944301629487945294284b014b80859468038c0564747970659493948c02663894898887945294284b038c013c944e4e4e4affffffff4affffffff4b00749462894200040000000000a03a5da7bf000000c0e831b43f000000e06e5fa3bf000000806584a2bf000000a0ca8a7fbf00000060f13ea4bf00000020de8e9f3f000000e09214b8bf000000e0d27ac03f000000a0342ab9bf00000000eb3dd23f000000002671adbf000000e06440c9bf000000e0feb0c5bf000000404e9ca03f000000c07730c03f000000a042aec1bf000000a0b34dbfbf000000c0249ab8bf000000000168513f00000020c76bc13f000000c02218873f000000e0d18ba3bf00000060a793a63f000000a01d19b2bf0000008042fdd9bf000000805279b8bf00000020e264b5bf000000402c01b13f000000a0ae9ebabf000000c074de75bf000000805db7923f000000a0b445c7bf000000408f48b3bf000000c0eaeea93f000000004f70b43f00000060cbe5a9bf00000040bec5903f00000080a46dca3f00000000af98a93f00000020ec5fcbbf000000601367633f0000002099e49b3f000000e09983d23f000000e034d7c43f000000a0dba0b73f00000000000fa2bf000000a056dfb5bf000000207e15c13f000000806e53c6bf000000c027c49a3f000000e0dea3c13f000000609dbdc83f000000005675b53f000000c014f4b03f000000c064a0bdbf00000000b82e3c3f000000c08160b93f000000c08d4ad0bf000000805acc91bf000000807a77a03f000000a02ee3babf000000a0c313a1bf000000201c0bbbbf00000020edebcc3f000000c05af3963f000000e0e799c2bf00000000d616babf000000e0e85bc33f00000080df51c3bf000000c0ccd79cbf000000809fdca73f000000608723b9bf00000020d1f3cabf000000002d76d0bf000000409d1eb23f00000020aecad53f000000209b0dc43f000000406775cdbf0000002055ff89bf00000020f1c59ebf000000802db999bf00000080375dc23f00000060ea9cb53f00000000f7a171bf00000040bdbfa13f0000000009c6b3bf000000c0d8ce76bf0000008062e7bf3f000000a0d095afbf00000020f6b67a3f00000080aa5eca3f000000e04738b1bf000000801483c03f00000080edd4843f000000c0497fa2bf000000c03ca7bebf00000000e485ab3f000000006d05c2bf0000004068ce88bf000000c0721694bf000000c067f09ebf00000080ba07a53f000000a04be6b63f000000e08c0bb8bf0000008077cdc43f00000040c2e1903f00000020b7d8843f0000004063a488bf000000c08135663f000000601a9ebabf00000060324cb8bf00000060f8a1b43f00000040ffcfcfbf00000080dc0ecc3f000000203628c53f000000206547853f000000c06497bf3f000000a033e6b53f00000080aff3ac3f000000e055aa90bf000000403b4cadbf000000201085d1bf000000e0bd098bbf000000e076a9bc3f0000004057609fbf00000020d1b9ac3f0000004052eeb6bf947494622e);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `accession_number`, `barcode`, `call_number`, `title`, `author`, `advisor`, `isbn`, `doi`, `publisher`, `publication_year`, `language`, `genre`, `number_of_pages`, `format`, `cover_image`, `summary`, `price`, `location`, `tags`, `type`, `date_acquired`, `library`, `section`, `degree`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(5, NULL, '1478665428748', NULL, 'Harry Potter and the Prisoners of Azkaban (Book 3)', 'J.K. Rowling', NULL, '9781338878943', NULL, 'Scholastic Inc.', 2005, 'english', 'fiction', NULL, 'paperback', '5.png', NULL, '520.00', NULL, 'harry,potter,prisoner,azkaban', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'damaged', '2024-09-30 23:11:07', '2024-11-22 18:09:59'),
(6, NULL, '9780358380239', NULL, 'The Lord of the Rings: The Fellowship of The Ring (Book 1)', 'J.R.R. Tolkien', NULL, '9780358380238', NULL, 'Bloomsbury', 1995, 'english', 'fiction', NULL, 'hardcover', '6.png', NULL, NULL, NULL, NULL, 'book', '2024-11-22', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-09-30 23:45:11', '2024-11-22 15:00:33'),
(7, NULL, '7894536971584', NULL, 'The Girl on the Train', 'Paula Hawkins', NULL, '9781594634024', NULL, 'New York Times', 2015, 'english', 'thriller', 336, 'paperback', '7.png', 'Rachel catches the same commuter train every morning. She knows it will wait at the same signal each time, overlooking a row of back gardens. She’s even started to feel like she knows the people who live in one of the houses. “Jess and Jason,” she calls them. Their life—as she sees it—is perfect. If only Rachel could be that happy. And then she sees something shocking. It’s only a minute until the train moves on, but it’s enough. Now everything’s changed. Now Rachel has a chance to become a part of the lives she’s only watched from afar. Now they’ll see; she’s much more than just the girl on the train', '780.00', NULL, 'girl,train,mystery', 'book', '2024-11-01', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-10-06 00:11:21', '2024-11-22 15:03:41'),
(8, NULL, '1886486789417', NULL, 'Harry Potter and the Chamber of Secrets (Book 2)', 'J.K. Rowling', NULL, '9781338878936', NULL, 'Scholastic Inc.', 2000, 'english', 'fiction', 514, 'paperback', '8.png', 'While spending the summer with the Dursleys, the twelve-year-old Harry Potter is visited by Dobby, a house-elf. Dobby says Harry is in danger and must promise not to return to Hogwarts. When Harry refuses, Dobby uses magic to destroy a pudding made by Aunt Petunia. Believing that Harry created the mess, Uncle Vernon locks him in his room. The Ministry of Magic sends a notice accusing Harry of performing underage magic and threatening to expel him from Hogwarts.\r\n\r\nThe Weasley brothers Ron, Fred, and George arrive in their father\'s flying car and take Harry to their home. When Harry and the Weasleys go to Diagon Alley for school supplies, they meet Gilderoy Lockhart, a celebrity author who is the new Defence Against the Dark Arts professor. At King\'s Cross station, Harry and Ron cannot enter Platform 9¾ to board the Hogwarts Express, so they fly to Hogwarts in the enchanted car.\r\n\r\nDuring the school year, Harry hears a strange voice emanating from the castle walls. Argus Filch\'s cat is found Petrified, along with a warning scrawled on the wall: \"The Chamber of Secrets has been opened. Enemies of the heir, beware\". Harry learns that the Chamber supposedly houses a monster that attacks Muggle-born students, and which only the Heir of Slytherin can control. During a Quidditch match, a rogue Bludger strikes Harry, breaking his arm. Professor Lockhart botches an attempt to mend it, which sends Harry to the hospital wing. Dobby visits Harry and reveals that he jinxed the Bludger and sealed the portal at King\'s Cross. He also tells Harry that house-elves are bound to serve a master, and cannot be freed unless their master gives them clothing.\r\n\r\nAfter another attack from the monster, students attend a defensive duelling class. During the class, Harry displays the rare ability to speak Parseltongue, the language of snakes. Moaning Myrtle, a ghost who haunts a bathroom, shows Harry and his friends a diary that was left in her stall. It belonged to Tom Riddle, a student who witnessed another student\'s death when the Chamber was last opened. During the next attack by the monster, Hermione Granger is Petrified.\r\n\r\nHarry and Ron discover that the monster is a Basilisk, a gigantic snake that can kill victims with a direct gaze and Petrify them with an indirect gaze. Harry realizes the Basilisk is producing the voice he hears in the walls. After Ron\'s sister Ginny is abducted and taken into the Chamber, Harry and Ron discover the Chamber entrance in Myrtle\'s bathroom. When they force Lockhart to enter with them, he confesses that the stories he told of his heroic adventures are fabrications. He attempts to erase the boys\' memories, but his spell backfires and obliterates his own memory.\r\n\r\nHarry finds an unconscious Ginny in the Chamber. A manifestation of Tom Riddle appears and reveals that he is Lord Voldemort and the Heir of Slytherin. After explaining that he opened the Chamber, Riddle summons the Basilisk to kill Harry. Dumbledore\'s phoenix Fawkes arrives, bringing Harry the Sorting Hat. While Fawkes blinds the Basilisk, Harry pulls the Sword of Gryffindor from the Hat. He slays the serpent, then stabs the diary with a Basilisk fang, destroying it and the manifestation of Riddle. Later, Harry liberates Dobby by tricking his master into giving him clothing. At the end of the novel, the Petrified students are cured and Gryffindor wins the House Cup.', '3199.00', NULL, 'harry,potter,chamber,secrets,mystery,serpent,sword', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'checked out', '2024-10-17 08:01:40', '2024-11-21 13:34:12'),
(9, NULL, '1987467186417', NULL, 'Harry Potter and the Sorcerer\'s Stone (Book 1)', 'J.K. Rowling', NULL, '9781338878929', NULL, 'Scholastic Inc.', 1998, 'english', 'fiction', NULL, 'paperback', '9.png', NULL, '480.00', NULL, 'harry,potter,sorcerer,stone', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-10-26 01:52:11', '2024-11-17 08:18:04'),
(10, NULL, '5747852147891', NULL, 'Harry Potter and the Goblet of Fire (Book 4)', 'J.K. Rowling', NULL, '9781338878950', NULL, 'Scholastic Inc.', 2008, 'english', 'fiction', NULL, 'paperback', '10.png', NULL, '650.00', NULL, 'harry,potter,goblet,fire', 'book', '2024-11-08', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-10-26 02:24:03', '2024-11-19 13:18:29'),
(11, NULL, '9798487963541', NULL, 'Harry Potter and the Order of the Phoenix (Book 5)', 'J.K. Rowling', NULL, '9781338878967', NULL, 'Scholastic Inc.', 2012, 'english', 'fiction', NULL, 'paperback', '11.png', NULL, NULL, NULL, 'harry,potter,order,phoenix', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'checked out', '2024-10-26 02:28:45', '2024-11-23 03:58:13'),
(12, NULL, '3597857891467', NULL, 'Harry Potter and the Half-Blood Prince (Book 6)', 'J.K. Rowling', NULL, '9781338878974', NULL, 'Scholastic Inc.', 2006, 'english', 'fiction', NULL, 'paperback', '12.png', NULL, '780.00', NULL, 'harry,potter,half-blood,prince', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'checked out', '2024-10-26 02:31:34', '2024-11-19 13:16:14'),
(13, NULL, '7894258941365', NULL, 'Harry Potter and the Deathly Hallows (Book 7)', 'J.K. Rowling', NULL, '9781338878981', NULL, 'Scholastic Inc.', 2018, 'english', 'fiction', NULL, 'paperback', '13.png', NULL, '820.00', NULL, 'harry,potter,deathly,hallows', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-10-26 02:34:09', '2024-11-08 06:09:58'),
(14, NULL, '1784575884789', NULL, 'The Lord of the Rings: The Fellowship of The Ring (Book 1)', 'J.R.R. Tolkien', NULL, '9780358380238', NULL, 'Bloomsbury', 1995, 'english', 'fiction', NULL, 'hardcover', '14.png', NULL, '820.00', NULL, NULL, 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-10-26 02:38:10', '2024-11-22 15:00:33'),
(15, NULL, '45897656314752', NULL, 'The Lord of the Rings: The Two Towers (Book 2)', 'J.R.R. Tolkien', NULL, '9780358380245', NULL, 'Clarion Books', 2000, 'english', 'fiction', NULL, 'paperback', '15.png', NULL, '820.00', NULL, 'lord,ring,two towers', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-10-26 02:41:39', '2024-11-23 05:27:04'),
(16, NULL, '4987467112564', NULL, 'The Lord of the Rings: The Return of The King (Book 3)', 'J.R.R. Tolkien', NULL, '9780358380252', NULL, 'Clarion Books', 2000, 'english', 'fiction', NULL, 'paperback', '16.png', NULL, '820.00', NULL, 'lord,ring,return,king', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'checked out', '2024-10-26 02:47:00', '2024-11-21 14:12:50'),
(17, NULL, '5789413478941', NULL, 'The Hobbit: A Graphic Novel: An Enchanting Fantasy Adventure (Hobbit Fantasy Classic)', 'J.R.R. Tolkien', NULL, '9780063388468', NULL, 'William Morrow Paperbacks', 2024, 'english', 'fiction', NULL, 'paperback', '9780063388468.png', NULL, NULL, NULL, 'hobbit', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-10-28 05:18:39', '2024-10-29 13:57:40'),
(18, NULL, '5789413478942', NULL, 'The Hobbit: A Graphic Novel: An Enchanting Fantasy Adventure (Hobbit Fantasy Classic)', 'J.R.R. Tolkien', NULL, '9780063388468', NULL, 'William Morrow Paperbacks', 2024, 'english', 'fiction', NULL, 'paperback', '9780063388468.png', NULL, NULL, NULL, 'hobbit', 'book', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-10-28 05:36:44', '2024-10-28 05:36:44'),
(19, NULL, '1112213455229', NULL, 'Image Processing and Searching', 'Daniel Klein,Dean Jackson', NULL, NULL, NULL, 'Technical Disclosure Commons', 2015, 'english', 'developmental', 11, 'paperback', NULL, 'An image searching system is used to provide images in response to a query. The images can be captured by one or more users over a certain period of time. The system receives a query to search for images. The system parses the query and determines a type of request. The system then processes and searches for images in response to the determined request type. The system then presents the images to the user.', NULL, NULL, 'image processing,image,searching', 'research', '2024-11-19', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-05 01:38:09', '2024-11-19 12:30:31'),
(20, NULL, '1344556677744', NULL, 'Image Processing and Searching', 'Daniel Klein,Dean Jackson', NULL, NULL, NULL, 'Technical Disclosure Commons', 2015, 'english', 'developmental', 11, 'paperback', '', 'An image searching system is used to provide images in response to a query. The images can be captured by one or more users over a certain period of time. The system receives a query to search for images. The system parses the query and determines a type of request. The system then processes and searches for images in response to the determined request type. The system then presents the images to the user.', NULL, NULL, 'image processing,image,searching', 'research', '2024-11-19', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-05 03:21:26', '2024-11-19 12:30:24'),
(22, NULL, '1325476547894', NULL, 'Where Are You Now', 'Honor Society', NULL, NULL, NULL, 'BandSlam Inc.', 2000, 'english', 'romance', NULL, NULL, '22.png', NULL, NULL, NULL, NULL, 'audio', '2024-11-19', 'NEUST-PPY-LIB', 'circulation', NULL, 225, 'available', '2024-11-05 07:13:00', '2024-11-19 12:44:44'),
(23, NULL, '1784665484154', NULL, 'Sky High', 'Mike Mitchell', NULL, NULL, NULL, 'Walt Disney Pictures', 2005, 'english', 'fiction', NULL, NULL, '23.png', 'At a school in the sky where teens learn how to be superheroes, Will Stronghold (Michael Angarano) lands in a class for students who show special promise. Classmate Gwen (Mary Elizabeth Winstead) quickly cozies up to Will, but it\'s soon clear that she has other motives. When he learns that Gwen\'s mother is a villain who was defeated by his father, Steve Stronghold (Kurt Russell), Will realizes that Gwen is aiming for revenge, and he rushes to a school dance in the hope of stopping her.', NULL, NULL, 'superhero,sky high,sky,high', 'video', '2024-10-01', 'NEUST-PPY-LIB', 'circulation', NULL, 6000, 'available', '2024-11-05 07:58:32', '2024-11-25 12:38:49'),
(24, NULL, '5747852147892', NULL, 'Harry Potter and the Goblet of Fire (Book 4)', 'J.K. Rowling', NULL, '9781338878950', NULL, 'Scholastic Inc.', 2008, 'english', 'fiction', NULL, 'paperback', '24.png', NULL, '650.00', NULL, 'harry,potter,goblet,fire', 'book', '2024-11-08', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-08 02:05:42', '2024-11-19 13:18:29'),
(25, NULL, NULL, NULL, 'Sky High', 'Mike Mitchell', NULL, NULL, NULL, 'Walt Disney Pictures', 2005, 'english', 'fiction', NULL, NULL, '25.png', 'At a school in the sky where teens learn how to be superheroes, Will Stronghold (Michael Angarano) lands in a class for students who show special promise. Classmate Gwen (Mary Elizabeth Winstead) quickly cozies up to Will, but it\'s soon clear that she has other motives. When he learns that Gwen\'s mother is a villain who was defeated by his father, Steve Stronghold (Kurt Russell), Will realizes that Gwen is aiming for revenge, and he rushes to a school dance in the hope of stopping her.', NULL, NULL, 'superhero,sky high,sky,high', 'video', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, 6000, 'available', '2024-11-08 07:51:31', '2024-11-08 07:51:32'),
(26, NULL, NULL, NULL, 'Where Are You Now', 'Honor Society', NULL, NULL, NULL, 'BandSlam Inc.', 2000, 'english', 'romance', NULL, NULL, '26.png', NULL, NULL, NULL, NULL, 'audio', NULL, 'NEUST-PPY-LIB', 'circulation', NULL, 225, 'available', '2024-11-08 07:52:46', '2024-11-08 07:52:46'),
(27, NULL, NULL, NULL, 'Introduction to PC Hardware and Troubleshooting', 'Mike Mayers', NULL, '0-07-125211-8', NULL, 'Osborne', 2006, 'english', 'non-fiction', 447, 'hardcover', '27.png', NULL, '750.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 14:04:28', '2024-11-25 14:04:33'),
(28, NULL, NULL, NULL, 'CSS and Networking Guide for CCNA and CSS (NCII)', 'Marygin E. Sarmiento, Ph.d; Marmelo V. Abante, Ph.D; Rolando R. Lansigan, Ph.D; Luisa M. Macatangay, Ph.D; Jaime Sebastian S. Mendiola;  Kenneth A. Cambaya', NULL, '978-621-427-046-0', NULL, 'Unlimited Books Library Services & Publishing Inc', 2019, 'english', 'fiction', 366, 'hardcover', '28.png', NULL, '575.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 14:15:08', '2024-11-25 14:15:08'),
(29, NULL, NULL, NULL, 'Operating Systems (Second Edition)', 'Ron Carswell; Terrill Fresse; Shen Jiang', NULL, '978-981-4510-91-2', NULL, 'Philmont Academic Solutions, Inc', 2013, 'english', 'non-fiction', 612, 'hardcover', '29.png', NULL, '500.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 14:25:19', '2024-11-25 14:25:19'),
(30, NULL, NULL, NULL, 'WordPress ALL-IN-ONE for Dummies A Wiley Brand', 'Lisa Sabin-Wilson', NULL, '9781394225385', NULL, 'Media and Software Compilation', 2024, 'english', 'fiction', 608, 'hardcover', '30.png', NULL, '2397.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 14:34:11', '2024-11-25 15:33:36'),
(31, NULL, NULL, NULL, 'Essential Computer Hardware', 'Kevin Wilson', NULL, '1911174592', NULL, 'Elluminet Press', 2017, 'english', 'non-fiction', 230, 'hardcover', '31.png', NULL, '230.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 14:41:13', '2024-11-25 14:41:14'),
(32, NULL, NULL, NULL, 'Clean Code: A Handbook of Agile Software Craftsmanship', 'Robert C. Martin', NULL, '9780132350884', NULL, 'MIT Press', 2008, 'english', 'non-fiction', 464, 'hardcover', NULL, NULL, '750.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 14:47:57', '2024-11-25 14:47:57'),
(33, NULL, NULL, NULL, 'Introduction to Algorithms, 3rd Edition', 'Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein', NULL, '9780262033848', NULL, 'MIT Press', 2019, 'english', 'non-fiction', 1312, 'hardcover', '33.png', NULL, '3500.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 14:49:53', '2024-11-25 14:49:53'),
(34, NULL, NULL, NULL, 'Code: The Hidden Language of Computer Hardware and Software', 'Charles Petzold', NULL, '9780735611313', NULL, 'Microsoft Press', 2000, 'english', 'non-fiction', 393, 'hardcover', '34.png', NULL, '550.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 14:55:28', '2024-11-25 14:55:28'),
(35, NULL, NULL, NULL, 'Algorithms, 4th Edition', 'Robert Sedgewick, Kevin Wayne', NULL, '9780321573513', NULL, 'Addison-Wesley', 2011, 'english', 'non-fiction', 976, 'hardcover', '35.png', NULL, '760.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 14:57:42', '2024-11-25 14:57:42'),
(36, NULL, NULL, NULL, 'The Pragmatic Programmer: Your Journey to Mastery, 20th Anniversary Edition', 'Andrew Hunt, David Thomas', NULL, '9780135957059', NULL, 'Addison-Wesley Professional', 2019, 'english', 'non-fiction', 352, 'hardcover', '36.png', NULL, '1750.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:01:57', '2024-11-25 15:01:57'),
(37, NULL, NULL, NULL, 'The C Programming Language, 2nd Edition', 'Prentice Hall', NULL, '9780131103627', NULL, 'Prentice Hall', 2018, 'english', 'non-fiction', 288, 'hardcover', '37.png', NULL, NULL, NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:09:49', '2024-11-25 15:09:49'),
(38, NULL, NULL, NULL, 'Python Crash Course, 2nd Edition', 'Eric Matthes', NULL, '9781593279288', NULL, 'No Starch Press', 2019, 'english', 'non-fiction', 544, 'hardcover', '38.png', NULL, '1890.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:22:36', '2024-11-25 15:22:37'),
(39, NULL, NULL, NULL, 'Head First Java, 2nd Edition', 'Kathy Sierra, Bert Bates', NULL, '9780596009205', NULL, 'O\'Reilly Media', 2005, 'english', 'non-fiction', 720, 'hardcover', '39.png', NULL, '2550.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:25:38', '2024-11-25 15:25:38'),
(40, NULL, NULL, NULL, 'Design Patterns: Elements of Reusable Object-Oriented Software', 'Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides', NULL, '9780201633610', NULL, 'Addison-Wesley Professional', 1994, 'english', 'non-fiction', 395, 'hardcover', '40.png', NULL, '879.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:28:19', '2024-11-25 15:28:19'),
(41, NULL, NULL, NULL, 'Algorithms to Live By: The Computer Science of Human Decisions', 'Brian Christian, Tom Griffiths', NULL, '9781627790369', NULL, 'Henry Holt and Co.', 2016, 'english', 'fiction', 368, 'hardcover', '41.png', NULL, '890.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:29:48', '2024-11-25 15:30:47'),
(42, NULL, NULL, NULL, 'The Lean Startup', 'Eric Ries', NULL, '9780307887894', NULL, 'Crown Business', 2011, 'english', 'fiction', 336, 'hardcover', '42.png', NULL, '999.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:40:16', '2024-11-25 15:40:16'),
(43, NULL, NULL, NULL, 'Good to Great', 'Jim Collins', NULL, '9780066620992', NULL, 'Harper Business', 2001, 'english', 'non-fiction', 320, 'hardcover', '43.png', NULL, '1500.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:43:44', '2024-11-25 15:43:44'),
(44, NULL, NULL, NULL, 'Blue Ocean Strategy', 'W. Chan Kim, Renée Mauborgne', NULL, '9781591396192', NULL, 'Harvard Business Review Press', 2005, 'english', 'fiction', 240, 'hardcover', '44.png', NULL, '1350.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:46:39', '2024-11-25 15:46:39'),
(45, NULL, NULL, NULL, 'The Hard Thing About Hard Things', 'Ben Horowitz', NULL, '9780062273208', NULL, 'Harper Business', 2014, 'english', 'fiction', 304, 'hardcover', '45.png', NULL, '1250.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:50:47', '2024-11-25 15:50:48'),
(46, NULL, NULL, NULL, 'How to Win Friends and Influence People', 'Dale Carnegie', NULL, '9780671027032', NULL, 'Simon & Schuster', 1936, 'english', 'non-fiction', 291, 'hardcover', '46.png', NULL, '670.00', NULL, NULL, 'book', '2024-11-25', 'NEUST-PPY-LIB', 'circulation', NULL, NULL, 'available', '2024-11-25 15:59:27', '2024-11-25 15:59:27');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `libraries`
--

CREATE TABLE `libraries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `libraries`
--

INSERT INTO `libraries` (`id`, `code`, `name`, `host`, `address`, `description`, `created_at`, `updated_at`) VALUES
(16, 'NEUST-PPY-LIB', 'Library of NEUST - Papaya', 'papaya.ils.ph', 'General Tinio, Nueva Ecija', '..', '2024-09-09 00:38:08', '2024-10-01 20:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `loaned_items`
--

CREATE TABLE `loaned_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `date_loaned` date NOT NULL,
  `due_date` date NOT NULL,
  `date_returned` date DEFAULT NULL,
  `loaner_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'checked out',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loaned_items`
--

INSERT INTO `loaned_items` (`id`, `type`, `barcode`, `date_loaned`, `due_date`, `date_returned`, `loaner_id`, `status`, `created_at`, `updated_at`) VALUES
(15, 'book', '1987467186417', '2024-10-29', '2024-11-05', '2024-10-29', 19, 'returned', '2024-10-29 14:44:11', '2024-10-29 14:49:44'),
(16, 'book', '1886486789417', '2024-10-29', '2024-11-05', '2024-10-29', 19, 'returned', '2024-10-29 15:05:06', '2024-10-29 15:06:15'),
(17, 'book', '1886486789417', '2024-10-29', '2024-11-05', '2024-10-29', 20, 'returned', '2024-10-29 15:51:35', '2024-10-29 15:59:28'),
(18, 'book', '1478665428748', '2024-10-30', '2024-11-06', '2024-10-30', 19, 'returned', '2024-10-29 16:44:25', '2024-10-29 16:45:00'),
(19, 'book', '5747852147891', '2024-10-30', '2024-11-06', '2024-10-30', 20, 'returned', '2024-10-29 16:53:36', '2024-10-29 16:54:02'),
(20, 'book', '9798487963541', '2024-10-30', '2024-11-06', '2024-10-30', 19, 'returned', '2024-10-29 16:56:39', '2024-10-29 16:56:54'),
(21, 'book', '5747852147891', '2024-10-30', '2024-11-06', '2024-11-08', 19, 'returned', '2024-10-29 16:59:17', '2024-11-08 07:23:31'),
(22, 'book', '3597857891467', '2024-10-30', '2024-11-06', NULL, 19, 'checked out', '2024-10-29 16:59:55', '2024-11-21 07:19:17'),
(23, 'book', '1886486789417', '2024-11-21', '2024-11-28', NULL, 19, 'checked out', '2024-11-21 13:34:12', '2024-11-21 13:34:12'),
(24, 'book', '4987467112564', '2024-11-21', '2024-11-28', NULL, 19, 'checked out', '2024-11-21 13:41:07', '2024-11-21 13:41:07'),
(25, 'book', '9798487963541', '2024-11-23', '2024-11-30', NULL, 23, 'checked out', '2024-11-23 03:58:13', '2024-11-23 03:58:13'),
(26, 'book', '45897656314752', '2024-11-23', '2024-11-30', '2024-11-23', 23, 'returned', '2024-11-23 05:22:48', '2024-11-23 05:24:05'),
(27, 'book', '45897656314752', '2024-11-23', '2024-11-30', '2024-11-23', 23, 'returned', '2024-11-23 05:26:00', '2024-11-23 05:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `media_discs`
--

CREATE TABLE `media_discs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accession_number` varchar(255) DEFAULT NULL,
  `barcode_number` varchar(255) DEFAULT NULL,
  `lcc_number` varchar(255) DEFAULT NULL,
  `ddc_number` varchar(255) DEFAULT NULL,
  `ir_number` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `year_released` int(11) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT '''''''English''''''',
  `cover_image` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `library` varchar(255) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_discs`
--

INSERT INTO `media_discs` (`id`, `accession_number`, `barcode_number`, `lcc_number`, `ddc_number`, `ir_number`, `title`, `author`, `year_released`, `publisher`, `language`, `cover_image`, `summary`, `duration`, `location`, `tags`, `library`, `genre`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, '101056492420988933', 'The Light Beyond the Garden Wall of Egypt', 'Scott Whitehead', 2005, 'Orange Records', 'english', '1.png', NULL, 73, NULL, NULL, NULL, 'autobiography', 'cd', 'available', '2024-10-14 07:37:19', '2024-10-14 07:52:08'),
(2, NULL, NULL, NULL, NULL, '101056492420988933', 'The Light Beyond the Garden Wall of Egypt', 'Scott Whitehead', 2005, 'Orange Records', 'english', '1.png', NULL, 73, NULL, NULL, NULL, 'autobiography', 'cd', 'available', '2024-10-14 07:58:59', '2024-10-14 07:58:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_08_21_125536_create_libraries_table', 2),
(5, '2024_08_28_012241_create_campuses_table', 3),
(6, '2024_08_28_082509_create_colleges_table', 4),
(7, '2024_09_09_025017_add_code_on_library_and_campus', 5),
(8, '2024_09_09_054337_create_programs_table', 5),
(21, '2024_09_11_015423_create_books_table', 6),
(22, '2024_09_17_055707_create_students_table', 6),
(23, '2024_09_18_074159_create_teachers_table', 7),
(25, '2024_09_26_123244_create_staffs_table', 8),
(26, '2024_10_01_065857_add_library_to_books_table', 9),
(27, '2024_10_01_075645_add_library_to_teachers_table', 10),
(28, '2024_10_01_081214_add_library_to_students_table', 11),
(33, '2024_10_14_060440_create_researches_table', 12),
(34, '2024_10_14_140214_create_media_discs_table', 13),
(35, '2024_10_17_022725_update_tags_attribute', 14),
(37, '2024_10_19_010915_create_tokens_table', 15),
(38, '2024_10_21_133155_create_requested_items_table', 16),
(39, '2024_10_21_133242_create_loaned_items_table', 16),
(43, '2024_10_23_180328_use_id_number_for_patrons', 17),
(44, '2024_10_23_221654_add_card_number_column_to_user', 17),
(45, '2024_10_24_103303_add_status_column_to_requested_items_table', 18),
(46, '2024_10_24_131022_add_status_column_to_loaned_items_table', 19),
(48, '2024_10_24_213940_create_user_details_table', 20),
(49, '2024_10_25_014852_rename_barcode_number_column_in_books_table', 21),
(50, '2024_10_25_162940_add_due_date_to_requested_items_table', 22),
(51, '2024_10_25_165939_add_date_returned_to_loaned_items_table', 23),
(52, '2024_10_28_100105_create_items_table', 24),
(53, '2024_10_28_112930_rename_books_table_to_items_table', 25),
(55, '2024_10_28_114513_add_type_column_to_items_table', 26),
(56, '2024_11_04_222618_replace_lcc_ddc_number_with_call_number_items_table', 27),
(58, '2024_11_05_085428_add_columns_for_research_items_table', 28),
(59, '2024_11_05_143526_add_duration_column_to_items_table', 29),
(60, '2024_11_08_094700_add_date_acquired_to_items_table', 30),
(62, '2024_11_08_205811_add_pin_to_users_table', 31),
(64, '2024_11_10_153657_create_face_encodings_table', 32),
(66, '2024_11_14_090308_create_attendance_table', 33),
(68, '2024_11_23_014033_create_reported_items_table', 34),
(69, '2024_11_25_224616_add_section_to_items_table', 35);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `program_length` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `code`, `name`, `description`, `college`, `program_length`, `created_at`, `updated_at`) VALUES
(1, 'BSIT', 'Bachelor of Science in Information Technology', '..', 'CICT', 4, '2024-09-08 22:30:59', '2024-09-08 22:50:20'),
(3, 'BSBA', 'Bachelor of Science in Business Administration', '..', 'CMBT', 4, '2024-09-16 23:26:05', '2024-09-16 23:26:05'),
(4, 'BEED', 'Bachelor of Elementary Education', '..', 'COED', 4, '2024-09-16 23:26:41', '2024-09-16 23:26:41'),
(5, 'BSED', 'Bachelor of Secondary Education', '..', 'COED', 4, '2024-09-16 23:27:19', '2024-09-16 23:27:19');

-- --------------------------------------------------------

--
-- Table structure for table `reported_items`
--

CREATE TABLE `reported_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reported_items`
--

INSERT INTO `reported_items` (`id`, `barcode`, `status`, `details`, `item_id`, `reporter_id`, `created_at`, `updated_at`) VALUES
(1, '1478665428748', 'damaged', 'Too many of the pages are torn and missing. Even the front page is missing', 5, 1, '2024-11-22 18:09:59', '2024-11-22 18:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `requested_items`
--

CREATE TABLE `requested_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `date_requested` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `requester_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requested_items`
--

INSERT INTO `requested_items` (`id`, `type`, `barcode`, `date_requested`, `due_date`, `requester_id`, `status`, `created_at`, `updated_at`) VALUES
(26, 'book', '1987467186417', '2024-10-29', '2024-11-01', 19, 'checked out', '2024-10-29 14:40:18', '2024-10-29 14:44:11'),
(28, 'book', '1784575884789', '2024-10-30', '2024-11-02', 20, 'cancelled', '2024-10-29 16:05:46', '2024-10-29 16:29:23'),
(29, 'book', '5747852147891', '2024-10-30', '2024-11-02', 20, 'checked out', '2024-10-29 16:46:30', '2024-10-29 16:53:36'),
(31, 'book', '1886486789417', '2024-11-21', '2024-11-24', 19, 'checked out', '2024-11-21 12:30:56', '2024-11-21 13:34:12'),
(32, 'book', '4987467112564', '2024-11-21', '2024-11-24', 19, 'checked out', '2024-11-21 13:36:36', '2024-11-21 13:41:07'),
(33, 'book', '1784665484154', '2024-11-22', '2024-11-28', 20, 'cancelled', '2024-11-22 04:03:37', '2024-11-25 12:38:49'),
(34, 'book', '9798487963541', '2024-11-23', '2024-11-26', 23, 'checked out', '2024-11-23 03:49:37', '2024-11-23 03:58:13'),
(35, 'book', '45897656314752', '2024-11-23', '2024-11-26', 23, 'checked out', '2024-11-23 05:19:32', '2024-11-23 05:22:48'),
(36, 'book', '1784575884789', '2024-11-25', NULL, 20, 'pending', '2024-11-25 12:32:34', '2024-11-25 12:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `researches`
--

CREATE TABLE `researches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accession_number` varchar(255) DEFAULT NULL,
  `barcode_number` varchar(255) DEFAULT NULL,
  `lcc_number` varchar(255) DEFAULT NULL,
  `ddc_number` varchar(255) DEFAULT NULL,
  `ir_number` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `year_submitted` int(11) NOT NULL,
  `language` varchar(255) DEFAULT 'English',
  `type` varchar(255) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `format` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `library` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `researches`
--

INSERT INTO `researches` (`id`, `accession_number`, `barcode_number`, `lcc_number`, `ddc_number`, `ir_number`, `title`, `author`, `year_submitted`, `language`, `type`, `number_of_pages`, `format`, `cover_image`, `summary`, `location`, `tags`, `library`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, 'BCE75C9C-EEE6-47ED-AA38-3B1C71CEEDB8', 'Research Paper Title Proposal', 'Connor Hunter', 2022, 'english', 'exploratory', 321, 'hardcover', '1.png', NULL, NULL, NULL, NULL, 'reference only', '2024-10-14 00:40:33', '2024-10-14 05:21:30'),
(2, NULL, NULL, NULL, NULL, '101056492420988931', 'Research Proposal Title: The Light Beyond the Garden Wall', 'Scott Whitehead', 2018, 'english', 'developmental', 333, 'paperback', '2.png', NULL, NULL, NULL, NULL, 'reference only', '2024-10-14 05:34:30', '2024-10-14 05:35:31'),
(3, NULL, NULL, NULL, NULL, '101056492420988931', 'Research Proposal Title: The Light Beyond the Garden Wall', 'Scott Whitehead', 2018, 'english', 'developmental', 333, 'paperback', '2.png', NULL, NULL, NULL, NULL, 'reference only', '2024-10-14 05:48:18', '2024-10-14 05:48:18');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('pzezxt9Q7A0tdYRwA6ASeLKE7uXKnDNQ5WjUi5n5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMFZBV3BzME5JcGZVSFI5MjlybWljMTBlaEc5Y3RkS2lpcHlsV25ibiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2NvbGxlY3Rpb25zL2Jvb2siO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1732596084);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `purpose` varchar(255) NOT NULL,
  `expiration` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `pin` varchar(255) DEFAULT '0000',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `card_number`, `pin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'elioth barker', 'elioth.barker@gmail.com', '2024-08-20 00:16:29', '$2y$12$zcPJE7rJSVLEzKz8YkG4ue6Y6hteFhQV2EoqJMIrxD01lXxXqR8w.', 'admin', 'NEUST-F-001', '0000', 'F6YHHPtPMdNazMlOuEQ4gVVxccnUVyMnRPevS2SfKX7181Cv2FG6933w1N5x', '2024-08-20 00:16:30', '2024-11-15 07:33:26'),
(16, 'JUAN DELA CRUZ', 'juan.delacruz.01.11.2001@gmail.com', NULL, '$2y$12$sLzI0QOAWHCV93RHVDE0FOpOgslIusKc34Ls5DS0WnHlI9MZCzHI2', 'librarian', 'NEUST-F-002', '0000', NULL, '2024-10-24 15:16:48', '2024-10-24 15:16:48'),
(19, 'christian peña', 'christian940616@gmail.com', '2024-10-24 17:45:40', '$2y$12$FN5MmjLR5PmJTif3vwWZ5u1BjNOUO1vcH/8nck.XgHmfvRYiBeIAi', 'teacher', 'NEUST-F-932', '0000', NULL, '2024-10-24 17:45:40', '2024-10-25 01:22:43'),
(20, 'Elioth Coder', 'elioth.coder@gmail.com', '2024-10-24 19:57:48', '$2y$12$bhkxRA/fb.XWR.nV7Q7kteZpT1CjWGXSA2hvycVhqHJ.hxnjIhTzq', 'student', 'NEUST-P-100', '0000', NULL, '2024-10-24 19:57:48', '2024-10-24 19:57:48'),
(21, 'maria nina reyes', 'marianina.reyes04@gmail.com', '2024-11-21 14:55:03', '$2y$12$7fnBvS3RrWtCYB8Sa/MSM.Q9lVQehHFVl06d9jIo56QawPhbEYgBK', 'student', 'NEUST-F-00001', '0000', NULL, '2024-11-21 14:55:03', '2024-11-21 14:55:03'),
(23, 'edward mansibang', 'ewamansibang@gmail.com', '2024-11-23 03:33:44', '$2y$12$nw1SVa20tYe6jiVXUTQ5fuu89ftulFSfEBK.ZHxYSkKG1Y5qibMWG', 'teacher', 'NEUST-F-923', '0000', NULL, '2024-11-23 03:33:44', '2024-11-23 03:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `card_number`, `first_name`, `middle_name`, `last_name`, `suffix`, `gender`, `birthday`, `email`, `mobile_number`, `barangay`, `municipality`, `province`, `profile`, `library`, `status`, `role`, `college`, `campus`, `academic_rank`, `program`, `year`, `section`, `created_at`, `updated_at`) VALUES
(1, 'NEUST-F-002', 'JUAN', NULL, 'DELA CRUZ', NULL, 'male', '2003-10-24', 'juan.delacruz.01.11.2001@gmail.com', '09157149207', NULL, NULL, NULL, 'NEUST-F-002.png', 'NEUST-PPY-LIB', 'active', 'librarian', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-24 15:16:48', '2024-11-15 07:40:15'),
(4, 'NEUST-F-500', 'melody', NULL, 'barnes', NULL, 'female', '2007-08-20', 'melody.barnes@gmail.com', NULL, NULL, NULL, NULL, 'NEUST-F-500.png', 'NEUST-PPY-LIB', 'active', 'teacher', 'CICT', 'NEUST-PPY', 'lecturer', NULL, NULL, NULL, '2024-10-24 17:08:06', '2024-11-07 18:50:45'),
(6, 'NEUST-F-501', 'MARTIN', NULL, 'CORS', NULL, 'male', '1994-10-29', 'martin.cors@gmail.com', NULL, NULL, NULL, NULL, 'NEUST-F-501.png', 'NEUST-PPY-LIB', 'active', 'teacher', 'COED', 'NEUST-PPY', 'instructor iii', NULL, NULL, NULL, '2024-10-24 17:14:12', '2024-10-24 17:21:07'),
(7, 'NEUST-F-932', 'christian', NULL, 'peña', NULL, 'male', '1994-06-16', 'christian940616@gmail.com', '09694708031', NULL, 'GENERAL TINIO', 'NUEVA ECIJA', 'NEUST-F-932.png', 'NEUST-PPY-LIB', 'active', 'teacher', 'CICT', 'NEUST-PPY', 'lecturer', NULL, NULL, NULL, '2024-10-24 17:30:22', '2024-10-25 01:22:43'),
(8, 'NEUST-P-100', 'elioth', NULL, 'coder', NULL, 'male', '1994-10-16', 'elioth.coder@gmail.com', NULL, NULL, NULL, NULL, 'NEUST-P-100.png', 'NEUST-PPY-LIB', 'active', 'student', 'CICT', 'NEUST-PPY', NULL, 'BSIT', 4, 'A', '2024-10-24 19:17:17', '2024-11-10 03:00:11'),
(10, 'NEUST-T-00001', 'angel', NULL, 'locsin', NULL, 'female', '1997-11-05', 'angel.locsin@gmail.com', NULL, NULL, NULL, NULL, 'NEUST-T-00001.png', 'NEUST-PPY-LIB', 'active', 'student', 'CICT', 'NEUST-PPY', NULL, 'BSIT', 2, 'A', '2024-11-10 10:38:20', '2024-11-10 10:38:24'),
(11, 'NEUST-F-001', 'elioth', NULL, 'barker', NULL, 'male', '1994-06-16', 'elioth.barker@gmail.com', '09694708031', NULL, NULL, NULL, 'NEUST-F-001.png', 'NEUST-PPY-LIB', 'active', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-24 15:16:48', '2024-11-21 15:22:56'),
(12, 'NEUST-F-00001', 'maria nina', NULL, 'reyes', NULL, 'female', '2008-06-19', 'marianina.reyes04@gmail.com', NULL, NULL, NULL, NULL, 'NEUST-F-00001.png', 'NEUST-PPY-LIB', 'active', 'student', 'COED', 'NEUST-PPY', NULL, 'BSED', 1, 'A', '2024-11-21 14:48:08', '2024-11-22 02:04:39'),
(13, 'NEUST-F-00002', 'marian', NULL, 'rivera', NULL, 'female', '1992-03-05', 'marian.rivera019@gmail.com', NULL, NULL, NULL, NULL, 'NEUST-F-00002.png', 'NEUST-PPY-LIB', 'active', 'student', 'CMBT', 'NEUST-PPY', NULL, 'BSBA', 4, 'A', '2024-11-22 13:12:40', '2024-11-22 13:12:44'),
(15, 'NEUST-F-923', 'edward', 'mirasol', 'mansibang', NULL, 'male', '1985-01-12', 'ewamansibang@gmail.com', '09166902122', NULL, NULL, NULL, 'NEUST-F-923.png', 'NEUST-PPY-LIB', 'active', 'teacher', 'CICT', 'NEUST-PPY', 'instructor i', NULL, NULL, NULL, '2024-11-23 03:30:28', '2024-11-23 03:32:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `campuses`
--
ALTER TABLE `campuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `campuses_name_unique` (`name`),
  ADD UNIQUE KEY `campuses_code_unique` (`code`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colleges_code_unique` (`code`),
  ADD UNIQUE KEY `colleges_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_accession_number_unique` (`accession_number`),
  ADD UNIQUE KEY `books_barcode_number_unique` (`barcode`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `libraries`
--
ALTER TABLE `libraries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `libraries_name_unique` (`name`),
  ADD UNIQUE KEY `libraries_code_unique` (`code`);

--
-- Indexes for table `loaned_items`
--
ALTER TABLE `loaned_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_discs`
--
ALTER TABLE `media_discs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_discs_accession_number_unique` (`accession_number`),
  ADD UNIQUE KEY `media_discs_barcode_number_unique` (`barcode_number`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `programs_code_unique` (`code`),
  ADD UNIQUE KEY `programs_name_unique` (`name`);

--
-- Indexes for table `reported_items`
--
ALTER TABLE `reported_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reported_items_barcode_unique` (`barcode`);

--
-- Indexes for table `requested_items`
--
ALTER TABLE `requested_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `researches`
--
ALTER TABLE `researches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `researches_accession_number_unique` (`accession_number`),
  ADD UNIQUE KEY `researches_barcode_number_unique` (`barcode_number`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_details_card_number_unique` (`card_number`),
  ADD UNIQUE KEY `user_details_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `campuses`
--
ALTER TABLE `campuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `libraries`
--
ALTER TABLE `libraries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `loaned_items`
--
ALTER TABLE `loaned_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `media_discs`
--
ALTER TABLE `media_discs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reported_items`
--
ALTER TABLE `reported_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `requested_items`
--
ALTER TABLE `requested_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `researches`
--
ALTER TABLE `researches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
