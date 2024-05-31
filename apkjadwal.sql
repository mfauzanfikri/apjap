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
  CONSTRAINT `FK__antrian_pasien_jadwal_pemeriksaan` FOREIGN KEY (`id_jadwal_pemeriksaan`) REFERENCES `jadwal_pemeriksaan` (`id_jadwal_pemeriksaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.antrian_pasien: ~0 rows (approximately)

-- Dumping structure for table apkjadwal.cuti
CREATE TABLE IF NOT EXISTS `cuti` (
  `id_cuti` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int NOT NULL,
  `id_validator` int DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` enum('proses','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'proses',
  PRIMARY KEY (`id_cuti`),
  KEY `id_pegawai` (`id_pegawai`),
  KEY `id_validator` (`id_validator`),
  CONSTRAINT `FK__pegawai_cuti` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE,
  CONSTRAINT `FK_cuti_pegawai` FOREIGN KEY (`id_validator`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.cuti: ~3 rows (approximately)
REPLACE INTO `cuti` (`id_cuti`, `id_pegawai`, `id_validator`, `tanggal_mulai`, `tanggal_selesai`, `status`) VALUES
	(1, 2, 1, '2024-05-25', '2024-05-27', 'disetujui'),
	(2, 1, NULL, '2024-05-26', '2024-05-29', 'proses'),
	(3, 1, 1, '2024-05-28', '2024-06-05', 'disetujui');

-- Dumping structure for table apkjadwal.dokter
CREATE TABLE IF NOT EXISTS `dokter` (
  `id_dokter` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int NOT NULL,
  `spesialisasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `poli` enum('Gigi','THT','PDL','Anak','Saraf','Mata') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `no_sip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_dokter`),
  UNIQUE KEY `no_sip` (`no_sip`),
  KEY `id_pegawai` (`id_pegawai`),
  CONSTRAINT `FK__dokter_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.dokter: ~7 rows (approximately)
REPLACE INTO `dokter` (`id_dokter`, `id_pegawai`, `spesialisasi`, `poli`, `no_sip`) VALUES
	(1, 2, 'THT\r\n', 'THT', '002'),
	(2, 5, 'Gigi', 'Gigi', '003'),
	(3, 6, 'Gigi', 'Gigi', '004'),
	(4, 7, 'Gigi', 'Gigi', '005'),
	(5, 8, 'THT', 'THT', '006'),
	(6, 9, 'THT', 'THT', '007'),
	(8, 10, 'THT', 'THT', '009');

-- Dumping structure for table apkjadwal.jadwal_dokter
CREATE TABLE IF NOT EXISTS `jadwal_dokter` (
  `id_jadwal_dokter` int NOT NULL AUTO_INCREMENT,
  `id_dokter` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `shift` enum('pagi','siang','malam') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `notifikasi` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jadwal_dokter`),
  KEY `id_dokter` (`id_dokter`),
  CONSTRAINT `FK__jadwal_dokter_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.jadwal_dokter: ~9 rows (approximately)
REPLACE INTO `jadwal_dokter` (`id_jadwal_dokter`, `id_dokter`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `shift`, `notifikasi`) VALUES
	(2, 3, '2024-05-22', '14:00:00', '16:00:00', 'siang', 0),
	(3, 4, '2024-05-22', '19:00:00', '21:00:00', 'malam', 0),
	(4, 2, '2024-05-22', '08:00:00', '10:00:00', 'pagi', 0),
	(5, 5, '2024-05-22', '08:00:00', '10:00:00', 'pagi', 0),
	(6, 6, '2024-05-22', '14:00:00', '16:00:00', 'siang', 0),
	(7, 8, '2024-05-22', '19:00:00', '21:00:00', 'malam', 0),
	(8, 3, '2024-05-24', '08:00:00', '10:00:00', 'pagi', 0),
	(9, 4, '2024-05-24', '14:00:00', '16:00:00', 'siang', 0),
	(10, 2, '2024-05-24', '19:00:00', '21:00:00', 'malam', 0);

-- Dumping structure for table apkjadwal.jadwal_operasi
CREATE TABLE IF NOT EXISTS `jadwal_operasi` (
  `id_jadwal_operasi` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_dokter` int NOT NULL,
  `id_pengaju` int NOT NULL,
  `id_validator` int DEFAULT NULL,
  `id_ruangan` int NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('proses','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'proses',
  PRIMARY KEY (`id_jadwal_operasi`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_ruangan` (`id_ruangan`),
  KEY `id_validator` (`id_validator`),
  KEY `id_pengaju` (`id_pengaju`),
  CONSTRAINT `FK_jadwal_operasi_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE,
  CONSTRAINT `FK_jadwal_operasi_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE,
  CONSTRAINT `FK_jadwal_operasi_pegawai` FOREIGN KEY (`id_validator`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE,
  CONSTRAINT `FK_jadwal_operasi_pegawai_2` FOREIGN KEY (`id_pengaju`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_jadwal_operasi_ruangan` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.jadwal_operasi: ~2 rows (approximately)
REPLACE INTO `jadwal_operasi` (`id_jadwal_operasi`, `id_pasien`, `id_dokter`, `id_pengaju`, `id_validator`, `id_ruangan`, `tanggal`, `status`) VALUES
	(1, 1, 2, 4, 1, 1, '2024-06-01', 'disetujui'),
	(2, 1, 1, 1, NULL, 1, '2024-05-28', 'proses');

-- Dumping structure for table apkjadwal.jadwal_pemeriksaan
CREATE TABLE IF NOT EXISTS `jadwal_pemeriksaan` (
  `id_jadwal_pemeriksaan` int NOT NULL AUTO_INCREMENT,
  `id_pasien` int NOT NULL,
  `id_dokter` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time DEFAULT NULL,
  `poli` enum('Gigi','THT','PDL','Anak','Saraf','Mata') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_jadwal_pemeriksaan`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_dokter` (`id_dokter`),
  CONSTRAINT `FK__jadwal_pemeriksaan_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE,
  CONSTRAINT `FK__jadwal_pemeriksaan_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.jadwal_pemeriksaan: ~2 rows (approximately)
REPLACE INTO `jadwal_pemeriksaan` (`id_jadwal_pemeriksaan`, `id_pasien`, `id_dokter`, `tanggal`, `waktu`, `poli`) VALUES
	(1, 1, 1, '2024-05-27', '13:00:00', 'THT'),
	(2, 1, 2, '2024-05-27', '08:00:00', 'Gigi');

-- Dumping structure for table apkjadwal.jadwal_perawat
CREATE TABLE IF NOT EXISTS `jadwal_perawat` (
  `id_jadwal_perawat` int NOT NULL AUTO_INCREMENT,
  `id_perawat` int NOT NULL,
  `id_validator` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `shift` enum('1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `poli` enum('Gigi','THT','PDL','Anak','Saraf','Mata') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` enum('proses','ditolak','disetujui') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'proses',
  `notifikasi` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jadwal_perawat`),
  KEY `id_perawat` (`id_perawat`),
  KEY `id_validator` (`id_validator`),
  CONSTRAINT `FK_jadwal_perawat_pegawai` FOREIGN KEY (`id_validator`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE,
  CONSTRAINT `FK_jadwal_perawat_perawat` FOREIGN KEY (`id_perawat`) REFERENCES `perawat` (`id_perawat`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.jadwal_perawat: ~3 rows (approximately)
REPLACE INTO `jadwal_perawat` (`id_jadwal_perawat`, `id_perawat`, `id_validator`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `shift`, `poli`, `status`, `notifikasi`) VALUES
	(2, 1, 1, '2024-05-23', '07:00:00', '14:00:00', '1', 'THT', 'disetujui', 0),
	(3, 1, NULL, '2024-05-23', '07:00:00', '14:00:00', '1', 'PDL', 'proses', 0),
	(4, 1, NULL, '2024-05-23', '07:00:00', '14:00:00', '1', 'Gigi', 'proses', 0);

-- Dumping structure for table apkjadwal.libur
CREATE TABLE IF NOT EXISTS `libur` (
  `id_libur` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id_libur`),
  KEY `id_pegawai` (`id_pegawai`),
  CONSTRAINT `FK_libur_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.libur: ~5 rows (approximately)
REPLACE INTO `libur` (`id_libur`, `id_pegawai`, `tanggal`) VALUES
	(1, 5, '2024-05-25'),
	(2, 1, '2024-05-26'),
	(3, 1, '2024-05-30'),
	(4, 1, '2024-06-02'),
	(5, 1, '2024-05-28');

-- Dumping structure for table apkjadwal.pasien
CREATE TABLE IF NOT EXISTS `pasien` (
  `id_pasien` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `no_telepon` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_pasien`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `FK__pasien_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.pasien: ~3 rows (approximately)
REPLACE INTO `pasien` (`id_pasien`, `id_user`, `nama`, `alamat`, `no_telepon`) VALUES
	(1, 8, 'Pasien', 'jl. abc', '08xx'),
	(2, 15, 'Fauzan', 'Jl. DI Panjaitan', 'Fauzan'),
	(3, 16, 'Atikah', 'Jl. Demak', 'Atikah');

-- Dumping structure for table apkjadwal.pegawai
CREATE TABLE IF NOT EXISTS `pegawai` (
  `id_pegawai` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `nip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `no_telepon` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status_pegawai` enum('aktif','cuti') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'aktif',
  PRIMARY KEY (`id_pegawai`),
  UNIQUE KEY `nip` (`nip`),
  UNIQUE KEY `id_user_unique` (`id_user`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `FK__pegawai_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.pegawai: ~9 rows (approximately)
REPLACE INTO `pegawai` (`id_pegawai`, `id_user`, `nip`, `nama`, `alamat`, `no_telepon`, `status_pegawai`) VALUES
	(1, 1, '001', 'Admin', 'jl. abc', '08130001', 'cuti'),
	(2, 5, '002', 'Dokter', 'jl. abc', '0813xxx', 'aktif'),
	(4, 6, '003', 'Perawat', 'jl. abc', '0813xxxx', 'aktif'),
	(5, 9, '004', 'Dokter Gigi 1', 'jl. xx', '08xx', 'aktif'),
	(6, 10, '005', 'Dokter Gigi 2', 'jl. xx', '08xx', 'aktif'),
	(7, 14, '006', 'Dokter Gigi 3', 'jl. xx', '08xx', 'aktif'),
	(8, 11, '007', 'Dokter THT 1', 'jl. xx', '08xx', 'aktif'),
	(9, 12, '008', 'Dokter THT 2', 'jl. xx', '08xx', 'aktif'),
	(10, 13, '009', 'Dokter THT 3', 'jl. xx', '08xx', 'aktif'),
	(11, 2, '010', 'Kepala Bidang', 'jl. abc', '08xx', 'aktif');

-- Dumping structure for table apkjadwal.perawat
CREATE TABLE IF NOT EXISTS `perawat` (
  `id_perawat` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int NOT NULL,
  `no_sip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_perawat`),
  KEY `id_pegawai` (`id_pegawai`),
  CONSTRAINT `FK__perawat_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.perawat: ~0 rows (approximately)
REPLACE INTO `perawat` (`id_perawat`, `id_pegawai`, `no_sip`) VALUES
	(1, 4, '001');

-- Dumping structure for table apkjadwal.ruangan
CREATE TABLE IF NOT EXISTS `ruangan` (
  `id_ruangan` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ruangan`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.ruangan: ~2 rows (approximately)
REPLACE INTO `ruangan` (`id_ruangan`, `nama`) VALUES
	(1, 'Ruangan');

-- Dumping structure for table apkjadwal.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `role` enum('pegawai','atasan','admin','pasien') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'pegawai',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table apkjadwal.user: ~15 rows (approximately)
REPLACE INTO `user` (`id_user`, `username`, `email`, `password`, `role`) VALUES
	(1, 'admin', 'admin@gmail.com', '3b612c75a7b5048a435fb6ec81e52ff92d6d795a8b5a9c17070f6a63c97a53b2', 'admin'),
	(2, 'kabid', 'kabid@gmail.com', '9459f6f78a7c23eb79428d0b0b37710b51017edda33f22ba69db1d9f587fd462', 'atasan'),
	(4, 'kasi', 'kasi@gmail.com', '4f9827d1801b8570b09457d46aa04ea2cb4c2065dd72d6ba0d063074efa246a5', 'atasan'),
	(5, 'dokter', 'dokter@gmail.com', '98d8632e2d368ebf0f8116f2a81c313be21056ac5d25b8430ec5320e8b2e708a', 'pegawai'),
	(6, 'perawat', 'perawat@gmail.com', '27ae02afb7286d4564a330d32a2aad249d243456507c25a67fea10fadb5ee9ce', 'pegawai'),
	(7, 'user', 'user@gmail.com', 'a61a8adf60038792a2cb88e670b20540a9d6c2ca204ab754fc768950e79e7d36', 'pegawai'),
	(8, 'pasien', 'pasien@gmail.com', '87347be37ea9f5663a9f7cc0aabb1d2f3afe0102a0eef5fdb5cd77f7aadf6a9b', 'pegawai'),
	(9, 'doktergigi1', 'dg1@gmail.com', 'dd5da8821a7e373cc7e4be340614b030bbb3119795296fce3225cefd7d9e82bd', 'pegawai'),
	(10, 'doktergigi2', 'dg2@gmail.com', 'cc179080bbb4428f66b06b3672afadfc8717a4af481d08cdc5d30ff032f69435', 'pegawai'),
	(11, 'doktertht1', 'dt1@gmail.com', '2e861119124e5a7e89bcd836e441dfe4626c78d5572cc0f7037efe5a3c922a9e', 'pegawai'),
	(12, 'doktertht2', 'dt2@gmail.com', 'a321c24927fed60906c1d41e52b16a8869345c109dad6fd2e4ea21881c1fa054', 'pegawai'),
	(13, 'doktertht3', 'dt3@gmail.com', '5a83ee9798dd0fa348ff0c54e64b54935b377ea701629f33019d41d26c992d27', 'pegawai'),
	(14, 'doktergigi3', 'dg3@gmail.com', 'df88d8d6b2e72ba3962abe6b31afa75eb81800c3adea9425dcc39167ed45d91e', 'pegawai'),
	(15, 'fauzan', 'fauzan@gmail.com', 'cf9689e2009c168c8d7294b0ff24314271bb4560cdf17b8529503cc48d2183bb', 'pasien'),
	(16, 'atikah', 'atikah@gmail.com', '4f1b860016d0c89c94d9bda3192b30a02880283f349bf49957d8cd3168a83233', 'pasien');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
