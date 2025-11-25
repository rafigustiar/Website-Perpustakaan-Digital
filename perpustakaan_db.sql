-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for perpustakaan_db
CREATE DATABASE IF NOT EXISTS `perpustakaan_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `perpustakaan_db`;

-- Dumping structure for table perpustakaan_db.books
CREATE TABLE IF NOT EXISTS `books` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `year` int DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `pages` int DEFAULT NULL,
  `stock` int DEFAULT '0',
  `cover` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table perpustakaan_db.books: ~0 rows (approximately)
INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `year`, `category`, `isbn`, `pages`, `stock`, `cover`, `created_at`) VALUES
	(2, 'Pendidikan Pancasila', 'KBP (Purn.) Dr. H. Yusuf Setyadi, SH., SStMk, MM, M. Hum, Dr. Abdul Aziz, M.Ag.', 'PT Adab Indonesia', 2011, 'Pendidikan', '09991238841', 302, 2, '1764075822_WhatsApp_Image_2025-11-25_at_19.43.31.jpeg', '2025-11-25 13:03:42'),
	(3, 'Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, 'Pemrograman', '9780132350884', 464, 5, '1764077422_clean_code.png', '2025-11-25 13:10:51'),
	(4, 'The Pragmatic Programmer', 'Andrew Hunt; David Thomas', 'Addison-Wesley', 1999, 'Pemrograman', '9780201616224', 352, 4, '1764077533_Screenshot_2025-11-25_203145.png', '2025-11-25 13:10:51'),
	(5, 'Design Patterns: Elements of Reusable Object-Oriented Software', 'Erich Gamma et al.', 'Addison-Wesley', 1994, 'Pemrograman', '9780201633610', 395, 3, '1764077656_Screenshot_2025-11-25_203406.png', '2025-11-25 13:10:51'),
	(6, 'Refactoring: Improving the Design of Existing Code', 'Martin Fowler', 'Addison-Wesley', 1999, 'Pemrograman', '9780201485677', 431, 4, '1764077683_Screenshot_2025-11-25_203437.png', '2025-11-25 13:10:51'),
	(7, 'Introduction to Algorithms', 'Thomas H. Cormen et al.', 'MIT Press', 2009, 'Algoritma', '9780262033848', 1312, 2, '1764077715_Screenshot_2025-11-25_203504.png', '2025-11-25 13:10:51'),
	(8, 'Artificial Intelligence: A Modern Approach', 'Stuart Russell; Peter Norvig', 'Prentice Hall', 2010, 'Kecerdasan Buatan', '9780136042594', 1152, 2, '1764077767_81H9lRjd0vL._AC_UF1000_1000_QL80_.jpg', '2025-11-25 13:10:51'),
	(9, 'Computer Networking: A Top-Down Approach', 'James F. Kurose; Keith W. Ross', 'Pearson', 2017, 'Jaringan Komputer', '9780133594140', 864, 3, '1764077820_41gZDvcbrJL._AC_UF1000_1000_QL80_.jpg', '2025-11-25 13:10:51'),
	(10, 'Database System Concepts', 'Abraham Silberschatz et al.', 'McGraw-Hill', 2010, 'Basis Data', '9780078022159', 1376, 3, '1764077853_51dC4E2S_qL._AC_UF1000_1000_QL80_.jpg', '2025-11-25 13:10:51'),
	(11, 'Operating System Concepts', 'Abraham Silberschatz et al.', 'Wiley', 2018, 'Sistem Operasi', '9781118063330', 976, 2, '1764077886_91xvtzqH5xL._UF1000_1000_QL80_.jpg', '2025-11-25 13:10:51'),
	(12, 'Eloquent JavaScript', 'Marijn Haverbeke', 'No Starch Press', 2018, 'Pemrograman Web', '9781593279509', 472, 4, '1764077912_81HqVRRwp3L._AC_UF1000_1000_QL80_.jpg', '2025-11-25 13:10:51'),
	(13, 'You Don\'t Know JS: Up & Going', 'Kyle Simpson', 'O\'Reilly Media', 2015, 'Pemrograman Web', '9781491924464', 88, 4, '1764077943_817kywRJjVL._AC_UF1000_1000_QL80_.jpg', '2025-11-25 13:10:51'),
	(14, 'PHP and MySQL Web Development', 'Luke Welling; Laura Thomson', 'Addison-Wesley', 2016, 'Pemrograman Web', '9780321833891', 1000, 5, '1764077971_71zOhDjANXL._AC_UF1000_1000_QL80_.jpg', '2025-11-25 13:10:51'),
	(15, 'Laravel: Up and Running', 'Matt Stauffer', 'O\'Reilly Media', 2019, 'Framework Web', '9781491936085', 520, 3, '1764077996_81Qcj1W-2CL._AC_UF1000_1000_QL80_.jpg', '2025-11-25 13:10:51'),
	(16, 'Head First Design Patterns', 'Eric Freeman et al.', 'O\'Reilly Media', 2004, 'Pemrograman', '9780596007126', 694, 3, '1764078028_91bobQSPQrL._AC_UF350_350_QL50_.jpg', '2025-11-25 13:10:51'),
	(17, 'Clean Architecture: A Craftsman\'s Guide to Software Structure and Design', 'Robert C. Martin', 'Prentice Hall', 2017, 'Arsitektur Perangkat Lunak', '9780134494166', 432, 3, '1764078057_images.jpg', '2025-11-25 13:10:51'),
	(18, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 'Novel', '9786022916628', 529, 7, '1764078105_Laskar_pelangi_sampul.jpg', '2025-11-25 13:10:51'),
	(19, 'Sang Pemimpi', 'Andrea Hirata', 'Bentang Pustaka', 2006, 'Novel', '9786028811378', 292, 6, '1764078130_Sang_Pemimpi_sampul.jpg', '2025-11-25 13:10:51'),
	(20, 'Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia Pustaka Utama', 2009, 'Novel', '9789792248616', 424, 6, '1764078156_9789792248616_negeri-5-menara-_cu-cover-baru_.jpg', '2025-11-25 13:10:51'),
	(21, 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, 'Novel Sejarah', '9789799731234', 535, 4, '1764078174_bumi-manusia-edit.jpg', '2025-11-25 13:10:51'),
	(22, 'Rindu', 'Tere Liye', 'Republika', 2014, 'Novel Religi', '9786239554552', 544, 5, '1764078197_63c11a2538ee9_20230113154525-1.jpg', '2025-11-25 13:10:51'),
	(23, 'Hafalan Shalat Delisa', 'Tere Liye', 'Republika', 2005, 'Novel Religi', '9789793210605', 304, 5, '1764078219_Hafalan_Shalat_Delisa.jpg', '2025-11-25 13:10:51'),
	(24, 'Dilan: Dia adalah Dilanku 1990', 'Pidi Baiq', 'Pastel Books', 2014, 'Novel Remaja', '9786027870864', 332, 8, '1764078239_9786027870864_dilan-1990.jpg', '2025-11-25 13:10:51'),
	(25, 'Koala Kumal', 'Raditya Dika', 'GagasMedia', 2015, 'Humor', '9789797808990', 244, 6, '1764078261_9789797808990_Koala-Kumal-Edisi-Revisi.jpg', '2025-11-25 13:10:51'),
	(26, 'Marmut Merah Jambu', 'Raditya Dika', 'Bukune', 2010, 'Humor', '6028066648', 256, 6, '1764078278_marmut-merah-jambu.jpg', '2025-11-25 13:10:51'),
	(27, 'Rectoverso', 'Dee Lestari', 'Bentang Pustaka', 2008, 'Fiksi', '9786027888036', 344, 4, '1764078298_xt58zr7217.jpg', '2025-11-25 13:10:51');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
