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

-- Dumping structure for table apkjadwal.antrian_pasien
CREATE TABLE IF NOT EXISTS `antrian_pasien` (
  `id_antrian_pasien` int NOT NULL AUTO_INCREMENT,
  `id_jadwal_pemeriksaan` int NOT NULL,
  `no_antrian` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_antrian_pasien`),
  KEY `id_jadwal_pemeriksaan` (`id_jadwal_pemeriksaan`),
  CONSTRAINT `FK__antrian_pasien_jadwal_pemeriksaan` FOREIGN KEY (`id_jadwal_pemeriksaan`) REFERENCES `jadwal_pemeriksaan` (`id_jadwal_pemeriksaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.antrian_pasien: ~0 rows (approximately)

-- Dumping structure for table apkjadwal.cuti
CREATE TABLE IF NOT EXISTS `cuti` (
  `id_cuti` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int NOT NULL,
  `id_validator` int DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` enum('proses','diterima','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'proses',
  PRIMARY KEY (`id_cuti`),
  KEY `id_pegawai` (`id_pegawai`),
  KEY `id_validator` (`id_validator`),
  CONSTRAINT `FK__pegawai_cuti` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`),
  CONSTRAINT `FK_cuti_pegawai` FOREIGN KEY (`id_validator`) REFERENCES `pegawai` (`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.cuti: ~0 rows (approximately)

-- Dumping structure for table apkjadwal.dokter
CREATE TABLE IF NOT EXISTS `dokter` (
  `id_dokter` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int NOT NULL,
  `spesialisasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `poli` enum('Gigi','THT','PDL','Anak','Saraf','Mata') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `no_sip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_dokter`),
  UNIQUE KEY `no_sip` (`no_sip`),
  KEY `id_pegawai` (`id_pegawai`),
  CONSTRAINT `FK__dokter_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.dokter: ~0 rows (approximately)
INSERT INTO `dokter` (`id_dokter`, `id_pegawai`, `spesialisasi`, `poli`, `no_sip`) VALUES
	(1, 2, 'THT\r\n', 'THT', '002');

-- Dumping structure for table apkjadwal.jadwal_dokter
CREATE TABLE IF NOT EXISTS `jadwal_dokter` (
  `id_jadwal_dokter` int NOT NULL AUTO_INCREMENT,
  `id_dokter` int NOT NULL,
  `id_validator` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `shift` enum('pagi','siang','malam') NOT NULL,
  `status` enum('proses','diterima','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'proses',
  PRIMARY KEY (`id_jadwal_dokter`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_validator` (`id_validator`),
  CONSTRAINT `FK__jadwal_dokter_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  CONSTRAINT `FK_jadwal_dokter_pegawai` FOREIGN KEY (`id_validator`) REFERENCES `pegawai` (`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.jadwal_dokter: ~0 rows (approximately)

-- Dumping structure for table apkjadwal.jadwal_operasi
CREATE TABLE IF NOT EXISTS `jadwal_operasi` (
  `id_jadwal_operasi` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_dokter` int NOT NULL,
  `id_validator` int NOT NULL,
  `id_ruangan` int NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('proses','diterima','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'proses',
  PRIMARY KEY (`id_jadwal_operasi`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_ruangan` (`id_ruangan`),
  KEY `id_validator` (`id_validator`),
  CONSTRAINT `FK_jadwal_operasi_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  CONSTRAINT `FK_jadwal_operasi_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  CONSTRAINT `FK_jadwal_operasi_pegawai` FOREIGN KEY (`id_validator`) REFERENCES `pegawai` (`id_pegawai`),
  CONSTRAINT `FK_jadwal_operasi_ruangan` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.jadwal_operasi: ~0 rows (approximately)

-- Dumping structure for table apkjadwal.jadwal_pemeriksaan
CREATE TABLE IF NOT EXISTS `jadwal_pemeriksaan` (
  `id_jadwal_pemeriksaan` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_dokter` int NOT NULL,
  `id_ruangan` int NOT NULL,
  `tanggal` date NOT NULL,
  `poli` enum('Gigi','THT','PDL','Anak','Saraf','Mata') NOT NULL,
  PRIMARY KEY (`id_jadwal_pemeriksaan`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_ruangan` (`id_ruangan`),
  CONSTRAINT `FK__jadwal_pemeriksaan_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  CONSTRAINT `FK__jadwal_pemeriksaan_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  CONSTRAINT `FK__jadwal_pemeriksaan_ruangan` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.jadwal_pemeriksaan: ~0 rows (approximately)

-- Dumping structure for table apkjadwal.jadwal_perawat
CREATE TABLE IF NOT EXISTS `jadwal_perawat` (
  `id_jadwal_perawat` int NOT NULL AUTO_INCREMENT,
  `id_perawat` int NOT NULL,
  `id_validator` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `shift` enum('1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` enum('proses','diterima','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'proses',
  PRIMARY KEY (`id_jadwal_perawat`),
  KEY `id_perawat` (`id_perawat`),
  KEY `id_validator` (`id_validator`),
  CONSTRAINT `FK_jadwal_perawat_pegawai` FOREIGN KEY (`id_validator`) REFERENCES `pegawai` (`id_pegawai`),
  CONSTRAINT `FK_jadwal_perawat_perawat` FOREIGN KEY (`id_perawat`) REFERENCES `perawat` (`id_perawat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.jadwal_perawat: ~0 rows (approximately)

-- Dumping structure for table apkjadwal.libur
CREATE TABLE IF NOT EXISTS `libur` (
  `id_libur` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int NOT NULL,
  `id_validator` int NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('proses','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'proses',
  PRIMARY KEY (`id_libur`),
  KEY `id_pegawai` (`id_pegawai`),
  KEY `validator` (`id_validator`) USING BTREE,
  CONSTRAINT `FK_libur_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`),
  CONSTRAINT `FK_libur_pegawai_2` FOREIGN KEY (`id_validator`) REFERENCES `pegawai` (`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.libur: ~0 rows (approximately)

-- Dumping structure for table apkjadwal.pasien
CREATE TABLE IF NOT EXISTS `pasien` (
  `id_pasien` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `no_telepon` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_pasien`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `FK__pasien_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.pasien: ~0 rows (approximately)

-- Dumping structure for table apkjadwal.pegawai
CREATE TABLE IF NOT EXISTS `pegawai` (
  `id_pegawai` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `nip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `no_telepon` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `jabatan` enum('kepala bidang','kepala seksi','staff') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'staff',
  `status_pegawai` enum('aktif','nonaktif','cuti') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'aktif',
  PRIMARY KEY (`id_pegawai`),
  UNIQUE KEY `nip` (`nip`),
  UNIQUE KEY `id_user_unique` (`id_user`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `FK__pegawai_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.pegawai: ~0 rows (approximately)
INSERT INTO `pegawai` (`id_pegawai`, `id_user`, `nip`, `nama`, `alamat`, `no_telepon`, `jabatan`, `status_pegawai`) VALUES
	(1, 1, '001', 'Admin', 'jl. abc', '08130001', 'staff', 'aktif'),
	(2, 5, '002', 'Dokter', 'jl. abc', '0813xxx', 'staff', 'aktif'),
	(4, 6, '003', 'Perawat', 'jl. abc', '0813xxxx', 'staff', 'aktif');

-- Dumping structure for table apkjadwal.perawat
CREATE TABLE IF NOT EXISTS `perawat` (
  `id_perawat` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int NOT NULL,
  `no_sip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_perawat`),
  KEY `id_pegawai` (`id_pegawai`),
  CONSTRAINT `FK__perawat_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.perawat: ~0 rows (approximately)
INSERT INTO `perawat` (`id_perawat`, `id_pegawai`, `no_sip`) VALUES
	(1, 4, '001');

-- Dumping structure for table apkjadwal.ruangan
CREATE TABLE IF NOT EXISTS `ruangan` (
  `id_ruangan` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ruangan`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.ruangan: ~2 rows (approximately)
INSERT INTO `ruangan` (`id_ruangan`, `nama`) VALUES
	(1, 'Ruangan');

-- Dumping structure for table apkjadwal.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `role` enum('user','admin','pasien') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table apkjadwal.user: ~8 rows (approximately)
INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `role`) VALUES
	(1, 'admin', 'admin@gmail.com', '3b612c75a7b5048a435fb6ec81e52ff92d6d795a8b5a9c17070f6a63c97a53b2', 'admin'),
	(2, 'kabid', 'kabid@gmail.com', '9459f6f78a7c23eb79428d0b0b37710b51017edda33f22ba69db1d9f587fd462', 'user'),
	(3, 'direktur', 'direktur@gmail.com', '0197f965f8efadc659be3877b94c0794fd9e86c5e2b3f6fc8f241fa43015210b', 'user'),
	(4, 'kasi', 'kasi@gmail.com', '4f9827d1801b8570b09457d46aa04ea2cb4c2065dd72d6ba0d063074efa246a5', 'user'),
	(5, 'dokter', 'dokter@gmail.com', '98d8632e2d368ebf0f8116f2a81c313be21056ac5d25b8430ec5320e8b2e708a', 'user'),
	(6, 'perawat', 'perawat@gmail.com', '27ae02afb7286d4564a330d32a2aad249d243456507c25a67fea10fadb5ee9ce', 'user'),
	(7, 'user', 'user@gmail.com', 'a61a8adf60038792a2cb88e670b20540a9d6c2ca204ab754fc768950e79e7d36', 'user'),
	(8, 'pasien', 'pasien@gmail.com', '87347be37ea9f5663a9f7cc0aabb1d2f3afe0102a0eef5fdb5cd77f7aadf6a9b', 'pasien');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
