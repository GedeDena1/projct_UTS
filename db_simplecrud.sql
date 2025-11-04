-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_simplecrud
CREATE DATABASE IF NOT EXISTS `db_simplecrud` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `db_simplecrud`;

-- Dumping structure for table db_simplecrud.tb_mahasiswa
CREATE TABLE IF NOT EXISTS `tb_mahasiswa` (
  `id_mhs` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mhs` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `prodi_mhs` char(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` mediumint(3) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telp` char(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status_mhs` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_mhs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_simplecrud.tb_mahasiswa: ~0 rows (approximately)

-- Dumping structure for table db_simplecrud.tb_prodi
CREATE TABLE IF NOT EXISTS `tb_program_latihan` (
  `kode_program` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_program` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`kode_program`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_simplecrud.tb_prodi: ~9 rows (approximately)
INSERT INTO `tb_prodi` (`kode_prodi`, `nama_prodi`) VALUES
	('ARS', 'Arsitek'),
	('BD', 'Bisnis Digital'),
	('DI', 'Desain Interior'),
	('DKV', 'Desain Komunikasi Visual'),
	('DM', 'Desain Mode'),
	('MBD', 'Magister Bisnis Digital'),
	('MDS', 'Magister Desain'),
	('MR', 'Manajemen Ritel'),
	('STI', 'Sistem dan Teknologi Informasi');

-- Dumping structure for table db_simplecrud.tb_provinsi
CREATE TABLE IF NOT EXISTS `tb_provinsi` (
  `id_provinsi` smallint(3) NOT NULL AUTO_INCREMENT,
  `nama_provinsi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_simplecrud.tb_provinsi: ~6 rows (approximately)
INSERT INTO `tb_provinsi` (`id_provinsi`, `nama_provinsi`) VALUES
	(1, 'Bali'),
	(2, 'Nusa Tenggara Timur'),
	(3, 'Nusa Tenggara Barat'),
	(4, 'Jawa Timur'),
	(5, 'Jawa Tengah'),
	(6, 'Jawa Barat');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
