-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Feb 2024 pada 13.56
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku_besar`
--

CREATE TABLE `buku_besar` (
  `id_buku_besar` int(10) NOT NULL,
  `id_jurnal` int(10) NOT NULL,
  `id_jurnal_detail` int(10) NOT NULL,
  `saldo` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_akun`
--

CREATE TABLE `daftar_akun` (
  `id` char(7) NOT NULL,
  `nama_akun` varchar(255) NOT NULL,
  `pos_saldo` varchar(255) DEFAULT NULL,
  `pos_laporan` varchar(255) DEFAULT NULL,
  `saldo_debit_awal` int(16) DEFAULT NULL,
  `saldo_kredit_awal` int(16) DEFAULT NULL,
  `lvl` int(10) DEFAULT NULL,
  `lvl_diatas` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_akun`
--

INSERT INTO `daftar_akun` (`id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal`, `lvl`, `lvl_diatas`) VALUES
('1-0000', 'AKTIVA', '', 'NRC', NULL, NULL, 1, ''),
('1-1000', 'AKTIVA LANCAR', NULL, 'NRC', 0, 0, 2, '1-0000'),
('1-1100', 'KAS', NULL, 'NRC', 0, 0, 3, '1-1000'),
('1-1110', 'Kas Operasional', 'Db', 'NRC', 3876800, 0, 4, '1-1100'),
('1-1200', 'Bank', NULL, 'NRC', 0, 0, 3, '1-1000'),
('1-1210', 'LPD AAN', 'Db', 'NRC', 0, 0, 4, '1-1200'),
('1-1211', 'BNI 46', 'Db', 'NRC', 0, 0, 4, '1-1200'),
('1-1300', 'PIUTANG', NULL, 'NRC', 0, 0, 3, '1-1000'),
('1-1310', 'Piutang Dagang', 'Db', 'NRC', 0, 0, 4, '1-1300'),
('1-1315', 'Piutang Lain-Lain', 'Db', 'NRC', 0, 0, 4, '1-1300'),
('1-1320', 'Piutang….', 'Db', 'NRC', 0, 0, 0, '0'),
('1-1400', 'BIAYA DIBAYAR DIMUKA', NULL, 'NRC', 0, 0, 3, '1-1000'),
('1-1410', 'Uang Muka Pembelian Barang', 'Db', 'NRC', 0, 0, 4, '1-1400'),
('1-1411', 'Sewa Dibayar Dimuka ', 'Db', 'NRC', 0, 0, 4, '1-1400'),
('1-1500', 'PERSEDIAAN', 'Db', 'NRC', 0, 0, 3, '1-1000'),
('1-1510', 'Persediaan Barang Dagangan', 'Db', 'NRC', 1338955, 0, 4, '1-1500'),
('1-1511', 'Persediaan...', 'Db', 'NRC', 0, 0, 4, '1-1500'),
('1-2000', 'AKTIVA TETAP', 'Db', 'NRC', 0, 0, 4, '1-2000'),
('1-2010', 'Perlengapan', 'Db', 'NRC', 0, 0, 4, '1-2000'),
('1-2011', 'Akum. Peny. Perlengkapan', 'Db', 'NRC', 0, 0, 4, '1-2000'),
('1-2012', 'Peralatan ', 'Db', 'NRC', 0, 0, 4, '1-2000'),
('1-2013', 'Akum. Peny. Peralatan', 'Db', 'NRC', 0, 0, 4, '1-2000'),
('1-2014', 'Bangunan', 'Db', 'NRC', 0, 0, 4, '1-2000'),
('1-2015', 'Akum. Peny. Bangunan', 'Db', 'NRC', 0, 0, 4, '1-2000'),
('2-0000', 'KEWAJIBAN', NULL, 'NRC', 0, 0, 1, ''),
('2-1000', 'HUTANG LANCAR', NULL, 'NRC', 0, 0, 2, '2-0000'),
('2-1100', 'Hutang Dagang', 'Kr', 'NRC', 0, 0, 3, '2-1000'),
('2-1200', 'Hutang Lancar Lainnya', 'Kr', 'NRC', 0, 0, 3, '2-1000'),
('2-1500', 'HUTANG JANGKA PANJANG', NULL, 'NRC', 0, 0, 2, '2-0000'),
('2-1510', 'Hutang Sewa Tanah', 'Kr', 'NRC', 0, 0, 3, '2-1510'),
('2-1511', 'Hutang……', 'Kr', 'NRC', 0, 0, 3, '2-1511'),
('3-0000', 'EKUITAS', NULL, 'NRC', 0, 0, 2, '3-0000'),
('3-1000', 'Modal', 'Kr', 'NRC', 0, 2737192, 2, '3-0000'),
('3-2000', 'Laba (Rugi) Ditahan', 'Kr', 'NRC', 0, 4971958, 2, '3-0000'),
('3-3000', 'Laba (Rugi) Tahun Berjalan', 'Kr', 'NRC', 0, -1793395, 2, '3-0000'),
('3-4000', 'Prive', 'Kr', 'NRC', 0, 0, 2, '3-0000'),
('4-0000', 'PENDAPATAN', 'Kr', 'LR', 0, 0, 1, ''),
('4-1000', 'PENDAPATAN USAHA', NULL, '0', 0, 0, 3, '4-1000'),
('4-1015', 'USAHA WARUNG', 'Kr', 'LR', 0, 0, 3, '4-1000'),
('4-1020', 'USAHA TUBING', 'Kr', 'LR', 0, 0, 3, '4-1000'),
('4-1025', 'USAHA EDUKASI KELE', 'Kr', 'LR', 0, 0, 3, '4-1000'),
('5-0000', 'BIAYA', NULL, '0', 0, 0, 1, ''),
('5-1000', 'HARGA POKOK PENJUALAN', NULL, '0', 0, 0, 3, '5-1000'),
('5-1010', 'HPP WARUNG', 'Db', 'LR', 0, 0, 3, '5-1000'),
('5-1011', 'HPP TUBING', 'Db', 'LR', 0, 0, 3, '5-1000'),
('5-1012', 'HPP EDUKASI KELE', 'Db', 'LR', 0, 0, 3, '5-1000'),
('5-5000', 'Laba (Rugi) Kotor', NULL, '0', 0, 0, 2, '5-0000'),
('6-0000', 'BIAYA OPERASIONAL', NULL, '0', 0, 0, 1, ''),
('6-0100', 'Biaya Administrasi', 'Db', 'LR', 0, 0, 3, '6-0000'),
('6-0110', 'Biaya Upah Oprs', 'Db', 'LR', 0, 0, 3, '6-0000'),
('6-0120', 'Biaya Perjalanan/transportasi', 'Db', 'LR', 0, 0, 3, '6-0000'),
('6-0130', 'Biaya Komunikasi, listrik, air', 'Db', 'LR', 0, 0, 3, '6-0000'),
('6-0140', 'Biaya Promosi', 'Db', 'LR', 0, 0, 3, '6-0000'),
('6-0150', 'Biaya Perizinan & sertifikasi', 'Db', 'LR', 0, 0, 3, '6-0000'),
('6-0160', 'Biaya Asuransi', 'Db', 'LR', 0, 0, 3, '6-0000'),
('6-0190', 'Biaya Operasional Lainnya', 'Db', 'LR', 0, 0, 3, '6-0000'),
('6-0200', 'Biaya Amortisasi', 'Db', 'LR', 0, 0, 3, '6-0000'),
('6-0210', 'Biaya Penyusutan', NULL, '0', 0, 0, 4, '6-0000'),
('6-0211', 'Biaya Penyusutan Perlengkapan', 'Db', 'LR', 0, 0, 4, '6-0210'),
('6-0212', 'Biaya Penyusutan Peralatan', 'Db', 'LR', 0, 0, 4, '6-0210'),
('6-0213', 'Biaya Penyusutan Bangunan', 'Db', 'LR', 0, 0, 4, '6-0210'),
('7-0000', 'PENDAPATAN LAIN-LAIN', NULL, '0', 0, 0, 1, ''),
('7-1000', 'DONASI MASUK', 'Kr', 'LR', 0, 0, 2, '7-0000'),
('7-2000', 'Pend. Non Oprs Lainnya', 'Kr', 'LR', 0, 0, 2, '7-0000'),
('8-0000', 'BIAYA LAIN-LAIN', NULL, '0', 0, 0, 1, ''),
('8-1000', 'DONASI KELUAR', 'Db', 'LR', 0, 0, 2, '8-0000'),
('8-2000', 'Biaya Non Oprs Lainnya', 'Db', 'LR', 0, 0, 2, '8-0000'),
('8-8000', 'Pajak Penghasilan', 'Db', 'LR', 0, 0, 2, '8-0000'),
('8-9000', 'Laba (Rugi) Bulan ini setelah Pajak', '', '', 0, 0, 2, '8-0000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_header_akun`
--

CREATE TABLE `daftar_header_akun` (
  `id_header` varchar(50) NOT NULL,
  `nama_header` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_header_akun`
--

INSERT INTO `daftar_header_akun` (`id_header`, `nama_header`) VALUES
('1-0000', 'AKTIVA'),
('2-0000', 'KEWAJIBAN'),
('3-0000', 'EKUITAS'),
('4-0000', 'PENDAPATAN'),
('5-0000', 'BIAYA'),
('6-0000', 'BIAYA OPERASIONAL'),
('7-0000', 'Pendapatan Lain-lain'),
('8-0000', 'Biaya Lain-lain');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_sub_akun`
--

CREATE TABLE `daftar_sub_akun` (
  `id_sub_akun` varchar(10) NOT NULL,
  `nama_sub_akun` varchar(50) NOT NULL,
  `id_header` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_sub_akun`
--

INSERT INTO `daftar_sub_akun` (`id_sub_akun`, `nama_sub_akun`, `id_header`) VALUES
('1-1000', 'AKTIVA LANCAR', 1),
('1-2000', 'AKTIVA TETAP', 1),
('2-1000', 'HUTANG LANCAR', 2),
('2-1500', 'HUTANG JANGKA PANJANG', 2),
('3-1000', 'Modal', 3),
('3-2000', 'Laba (Rugi) Ditahan', 3),
('3-3000', 'Laba (Rugi) Tahun Berjalan', 3),
('3-4000', 'Prive', 3),
('4-1000', 'Pendapatan Usaha', 4),
('5-1000', 'Harga Pokok Penjualan', 5),
('5-5000', 'Laba (Rugi) Kotor', 5),
('8-7000', 'Laba (Rugi) Sebelum Pajak', 8),
('8-8000', 'Pajak Penghasilan', 8),
('8-9000', 'Laba (Rugi) Bulan Ini Setelah Pajak', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `id_jurnal` int(10) NOT NULL,
  `nomor_bukti` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_detail`
--

CREATE TABLE `jurnal_detail` (
  `id_jurnal_detail` int(10) NOT NULL,
  `id_jurnal` int(10) NOT NULL,
  `id_akun` varchar(10) NOT NULL,
  `debit` int(16) NOT NULL,
  `kredit` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `neraca`
--

CREATE TABLE `neraca` (
  `id_neraca` int(10) NOT NULL,
  `id_buku_besar` int(10) NOT NULL,
  `id_akun` varchar(10) NOT NULL,
  `total_saldo` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku_besar`
--
ALTER TABLE `buku_besar`
  ADD PRIMARY KEY (`id_buku_besar`);

--
-- Indeks untuk tabel `daftar_akun`
--
ALTER TABLE `daftar_akun`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `daftar_header_akun`
--
ALTER TABLE `daftar_header_akun`
  ADD PRIMARY KEY (`id_header`);

--
-- Indeks untuk tabel `daftar_sub_akun`
--
ALTER TABLE `daftar_sub_akun`
  ADD PRIMARY KEY (`id_sub_akun`);

--
-- Indeks untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id_jurnal`);

--
-- Indeks untuk tabel `jurnal_detail`
--
ALTER TABLE `jurnal_detail`
  ADD PRIMARY KEY (`id_jurnal_detail`);

--
-- Indeks untuk tabel `neraca`
--
ALTER TABLE `neraca`
  ADD PRIMARY KEY (`id_neraca`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku_besar`
--
ALTER TABLE `buku_besar`
  MODIFY `id_buku_besar` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id_jurnal` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurnal_detail`
--
ALTER TABLE `jurnal_detail`
  MODIFY `id_jurnal_detail` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `neraca`
--
ALTER TABLE `neraca`
  MODIFY `id_neraca` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
