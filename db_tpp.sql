/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 100417
Source Host           : localhost:3306
Source Database       : db_tpp

Target Server Type    : MYSQL
Target Server Version : 100417
File Encoding         : 65001

Date: 2022-09-20 05:50:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_approval
-- ----------------------------
DROP TABLE IF EXISTS `tb_approval`;
CREATE TABLE `tb_approval` (
  `id_approval` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pegawai` varchar(255) DEFAULT '',
  `nip_pegawai` varchar(255) DEFAULT '',
  `pangkat_golongan` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `unit_kerja` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_approval`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_approval
-- ----------------------------
INSERT INTO `tb_approval` VALUES ('1', 'ALI SADIKIN, S.Pd.I., M.Si\r\n', '19710604 200801 1 002', 'Penata Muda Tk.I / III.b\r\n', 'Verifikator\r\n', 'BKPSDM\r\n');
INSERT INTO `tb_approval` VALUES ('2', 'CECEP SUMITA AGUNG, SE\r\n', '19760716 200801 1 021\r\n', 'Penata Tk.I / III.d\r\n', 'Kepala Subbagian Umum dan Kepegawaian\r\n', 'Kecamatan Setu\r\n');
INSERT INTO `tb_approval` VALUES ('3', 'Drs. JOKO DWIJATMOKO, M.Si\r\n', '19721112 199302 1 001\r\n', 'Pembina Tk.I / IV.b\r\n', 'Camat Setu\r\n', 'Kecamatan Setu\r\n');

-- ----------------------------
-- Table structure for tb_capaian_kerja
-- ----------------------------
DROP TABLE IF EXISTS `tb_capaian_kerja`;
CREATE TABLE `tb_capaian_kerja` (
  `id_capaian_kinerja` int(30) NOT NULL AUTO_INCREMENT,
  `id_periode` int(30) DEFAULT NULL,
  `id_pegawai` int(30) DEFAULT NULL,
  `nilai_produktivitas_kerja` int(5) DEFAULT NULL,
  `id_approval` int(30) DEFAULT NULL,
  PRIMARY KEY (`id_capaian_kinerja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_capaian_kerja
-- ----------------------------

-- ----------------------------
-- Table structure for tb_jabatan
-- ----------------------------
DROP TABLE IF EXISTS `tb_jabatan`;
CREATE TABLE `tb_jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(255) DEFAULT NULL,
  `unit_kerja` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_jabatan
-- ----------------------------
INSERT INTO `tb_jabatan` VALUES ('1', 'CAMAT', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('2', 'SEKRETARIS KECAMATAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('3', 'KEPALA SUBBAGIAN PERENCANAAN DAN KEUANGAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('4', 'BENDAHARA', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('5', 'ANALIS PERENCANAAN, EVALUASI DAN PELAPORAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('6', 'PENATA LAPORAN KEUANGAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('7', 'KEPALA SUBBAGIAN UMUM DAN KEPEGAWAIAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('8', 'PENGADMINISTRASI UMUM', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('9', 'PENGELOLA KEPEGAWAIAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('10', 'PENYUSUN KEBUTUHAN BARANG INVENTARIS', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('11', 'PRANATA KEARSIPAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('12', 'PENGELOLA PERJALANAN DINAS', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('13', 'KEPALA SEKSI PEMERINTAHAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('14', 'PENGELOLA ADMINISTRASI PEMERINTAHAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('15', 'PENGELOLA KEKAYAAN DESA DAN ADMINISTRASI DESA', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('16', 'PENGELOLA KEAMANAN DAN KETERTIBAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('17', 'KEPALA SEKSI EKONOMI DAN PEMBANGUNAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('18', 'KEPALA SEKSI PEMBERDAYAAN MASYARAKAT DAN DESA', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('19', 'PENGELOLA PEMBERDAYAAN MASYARAKAT DAN KELEMBAGAAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('20', 'PENYUSUN RENCANA PENGUATAN KELEMBAGAAN MASYARAKAT', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('21', 'KEPALA SEKSI PELAYANAN PUBLIK', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('22', 'PENGOLAH DATA PELAYANAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('23', 'VERIFIKATOR', 'BKPSDM');
INSERT INTO `tb_jabatan` VALUES ('24', 'ADMIN UMUM DAN KEPEGAWAIAN', 'KECAMATAN SETU');
INSERT INTO `tb_jabatan` VALUES ('25', 'ADMIN KEUANGAN', 'KECAMATAN SETU');

-- ----------------------------
-- Table structure for tb_pegawai
-- ----------------------------
DROP TABLE IF EXISTS `tb_pegawai`;
CREATE TABLE `tb_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `nip_pegawai` varchar(255) DEFAULT NULL,
  `nama` varchar(50) DEFAULT '',
  `id_jabatan` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `password` text DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_pegawai
-- ----------------------------
INSERT INTO `tb_pegawai` VALUES ('2', 'jdwijatmoko', '19721112 199302 1 001', 'Drs. JOKO DWOJATMOKO, M.Si', '1', null, 'd41d8cd98f00b204e9800998ecf8427e');
INSERT INTO `tb_pegawai` VALUES ('3', null, null, 'MUHAMMAD ALI AMRAN, S.Si, M.Si', '2', null, null);
INSERT INTO `tb_pegawai` VALUES ('4', null, null, 'FAISAL RAHMAN, ST, MM', '3', null, null);
INSERT INTO `tb_pegawai` VALUES ('5', null, null, 'ACE HERYANTO, S.IP', '4', null, null);
INSERT INTO `tb_pegawai` VALUES ('6', null, null, 'IRVAN SOMANTHA. S.Sos', '5', null, null);
INSERT INTO `tb_pegawai` VALUES ('7', null, null, 'IIN INAYAH, S.AP', '6', null, null);
INSERT INTO `tb_pegawai` VALUES ('8', 'csagung', '19760716 200801 1 021\r\n', 'CECEP SUMITA AGUNG, SE', '7', '4', '82c5a8bf67d3b913eeac3016ac7e6a90');
INSERT INTO `tb_pegawai` VALUES ('9', null, null, 'MISAR AR', '8', null, null);
INSERT INTO `tb_pegawai` VALUES ('10', null, null, 'SANDI KARTAWIJAYA', '8', null, null);
INSERT INTO `tb_pegawai` VALUES ('11', null, null, 'DIAH SAVITRI, ST, MM', '9', null, null);
INSERT INTO `tb_pegawai` VALUES ('12', null, null, 'SUHANTA', '10', null, null);
INSERT INTO `tb_pegawai` VALUES ('13', null, null, 'DUDI ROHMAN ROHMAT', '11', null, null);
INSERT INTO `tb_pegawai` VALUES ('14', null, null, 'MULYADI ', '12', null, null);
INSERT INTO `tb_pegawai` VALUES ('15', null, null, 'KUSNADI, S.AP, M.Si', '13', null, null);
INSERT INTO `tb_pegawai` VALUES ('16', null, null, 'ANITA KARTINIYANTI, SE, M.Si', '14', null, null);
INSERT INTO `tb_pegawai` VALUES ('17', null, null, 'NABAN BININ SAEN, S.IP', '14', null, null);
INSERT INTO `tb_pegawai` VALUES ('18', null, null, 'AHMAD REPA\'I, S.IP', '15', null, null);
INSERT INTO `tb_pegawai` VALUES ('19', null, null, 'RASMAN', '16', null, null);
INSERT INTO `tb_pegawai` VALUES ('20', null, null, 'HENDRA HERMANTO', '16', null, null);
INSERT INTO `tb_pegawai` VALUES ('21', null, null, 'RONY RAMDHONY, SE', '16', null, null);
INSERT INTO `tb_pegawai` VALUES ('22', null, null, 'EKO JANUARTO, ST', '17', null, null);
INSERT INTO `tb_pegawai` VALUES ('23', null, null, 'Dra.ERNIATI', '18', null, null);
INSERT INTO `tb_pegawai` VALUES ('24', null, null, 'YULFIDA, S.AP', '19', null, null);
INSERT INTO `tb_pegawai` VALUES ('25', null, null, 'IRVAN HERMAWAN, A.Md', '19', null, null);
INSERT INTO `tb_pegawai` VALUES ('26', null, null, 'NURUL IMAN, SE', '20', null, null);
INSERT INTO `tb_pegawai` VALUES ('27', null, null, 'YAYA SUTARYA, S.AP', '21', null, null);
INSERT INTO `tb_pegawai` VALUES ('28', null, null, 'TIUR MAIDA, SE', '22', null, null);
INSERT INTO `tb_pegawai` VALUES ('29', null, '19710604 200801 1 002\r\n', 'ALI SADIKIN, S.Pd.I., M.Si\r\n', '23', null, null);
INSERT INTO `tb_pegawai` VALUES ('30', 'esabilla', null, 'ELLA SABILLA', '24', '1', '82c5a8bf67d3b913eeac3016ac7e6a90');
INSERT INTO `tb_pegawai` VALUES ('31', 'nkhairunnisa', null, 'NISRINA KHAIRUNNISA', '25', '2', '82c5a8bf67d3b913eeac3016ac7e6a90');
INSERT INTO `tb_pegawai` VALUES ('36', 'nzainpradana', '123', 'Nur Zain', null, null, null);
INSERT INTO `tb_pegawai` VALUES ('37', 'nzainpradana', '123', 'Nur Zain', null, null, null);
INSERT INTO `tb_pegawai` VALUES ('38', 'nzainpradana', '123', 'Nur Zain Pradana', null, null, null);
INSERT INTO `tb_pegawai` VALUES ('39', 'nzainpradana', '123', 'Nur Zain', '1', null, null);

-- ----------------------------
-- Table structure for tb_perilaku_kerja
-- ----------------------------
DROP TABLE IF EXISTS `tb_perilaku_kerja`;
CREATE TABLE `tb_perilaku_kerja` (
  `id_perilaku_kerja` int(30) NOT NULL AUTO_INCREMENT,
  `id_periode` int(30) DEFAULT NULL,
  `id_pegawai` int(30) DEFAULT NULL,
  `jumlah_hari_kerja` int(10) DEFAULT NULL,
  `jumlah_tidak_hadir` int(2) DEFAULT NULL,
  `jumlah_dt_pc` int(10) DEFAULT NULL,
  `jumlah_tidak_hadir_apel` int(10) DEFAULT NULL,
  `total_pengurang_tpp` int(10) DEFAULT NULL,
  `nilai_disiplin_kerja` int(5) DEFAULT NULL,
  `id_approval` int(30) DEFAULT NULL,
  PRIMARY KEY (`id_perilaku_kerja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_perilaku_kerja
-- ----------------------------

-- ----------------------------
-- Table structure for tb_periode
-- ----------------------------
DROP TABLE IF EXISTS `tb_periode`;
CREATE TABLE `tb_periode` (
  `id_periode` int(30) NOT NULL AUTO_INCREMENT,
  `tahun` int(10) DEFAULT NULL,
  `bulan` varchar(15) DEFAULT NULL,
  `jumlah_hari_kerja` int(2) DEFAULT NULL,
  PRIMARY KEY (`id_periode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_periode
-- ----------------------------

-- ----------------------------
-- Table structure for tb_tpp
-- ----------------------------
DROP TABLE IF EXISTS `tb_tpp`;
CREATE TABLE `tb_tpp` (
  `id_tpp` int(30) NOT NULL AUTO_INCREMENT,
  `id_periode` int(30) DEFAULT NULL,
  `id_pegawai` int(30) DEFAULT NULL,
  `tpp_beban_kerja` int(20) DEFAULT NULL,
  `tpp_prestasi_kerja` int(20) DEFAULT NULL,
  `tpp_kondisi_kerja` int(20) DEFAULT NULL,
  `tpp_kelangkaan_profesi` int(20) DEFAULT NULL,
  `total_tpp` int(20) DEFAULT NULL,
  `nilai_disiplin_kerja` int(5) DEFAULT NULL,
  `nilai_produktivitas_kerja` int(5) DEFAULT NULL,
  `tambahan_tpp` int(20) DEFAULT NULL,
  `pengurangan_tpp` int(11) DEFAULT NULL,
  `jumlah_tpp_diterima` int(11) DEFAULT NULL,
  `id_approval` int(30) DEFAULT NULL,
  PRIMARY KEY (`id_tpp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_tpp
-- ----------------------------
SET FOREIGN_KEY_CHECKS=1;
