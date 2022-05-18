-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Bulan Mei 2022 pada 03.31
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_larakuy`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akomodasi`
--

CREATE TABLE `akomodasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_akomodasi` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `nama_pemilik` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `kontak` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `jumlah_kamar` int(11) NOT NULL,
  `harga_kamar` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `akomodasi_kategori_id` int(10) UNSIGNED NOT NULL,
  `wisata_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `akomodasi`
--

INSERT INTO `akomodasi` (`id`, `nama_akomodasi`, `nama_pemilik`, `alamat`, `kontak`, `jumlah_kamar`, `harga_kamar`, `akomodasi_kategori_id`, `wisata_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Makanan', 'rafli', 'mergan', '12233433', 12, '100000', 1, 7, '2022-05-09 09:10:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akomodasi_kategori`
--

CREATE TABLE `akomodasi_kategori` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `akomodasi_kategori`
--

INSERT INTO `akomodasi_kategori` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Akomodasi Pertama', '2022-05-09 09:10:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanja`
--

CREATE TABLE `belanja` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `total_belanja` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `tipe_belanja` enum('nusantara','mancanegara') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'nusantara',
  `kategori_belanja` enum('kuliner','oleholeh','transportasi','paketwisata') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'kuliner',
  `wisata_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanja_foto`
--

CREATE TABLE `belanja_foto` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_foto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_foto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `belanja_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanja_wisata_paket`
--

CREATE TABLE `belanja_wisata_paket` (
  `id` int(10) UNSIGNED NOT NULL,
  `belanja_id` int(10) UNSIGNED NOT NULL,
  `wisata_paket_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas_umum`
--

CREATE TABLE `fasilitas_umum` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `wisata_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas_umum_foto`
--

CREATE TABLE `fasilitas_umum_foto` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_foto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_foto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fasilitas_umum_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel`
--

CREATE TABLE `hotel` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_hotel` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alamat_hotel` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `kontak_hotel` varchar(13) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0831',
  `email_hotel` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `jenis_hotel` enum('bintang','nonbintang') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'bintang',
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `hotel`
--

INSERT INTO `hotel` (`id`, `nama_hotel`, `alamat_hotel`, `kontak_hotel`, `email_hotel`, `jenis_hotel`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(31, 'Hotel Sari', 'Jalan parangtritis', '', 'raflesh89@gmail.com', 'bintang', 35, '2022-05-06 23:37:45', '2022-05-06 23:37:45', NULL),
(32, 'sdfsdfdsfsd', 'Karang, Sumberagung, Moyudan, Sleman', '', 'qweqwe@sd.ds', 'nonbintang', 48, '2022-05-07 20:00:13', '2022-05-07 20:00:13', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel_belanja`
--

CREATE TABLE `hotel_belanja` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `total_belanja` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `tipe_belanja` enum('nusantara','mancanegara') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'nusantara',
  `kategori_belanja` enum('kuliner','oleholeh','transportasi','paketwisata') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'kuliner',
  `hotel_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel_belanja_foto`
--

CREATE TABLE `hotel_belanja_foto` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_foto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_foto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hotel_belanja_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel_belanja_paket_wisata`
--

CREATE TABLE `hotel_belanja_paket_wisata` (
  `id` int(10) UNSIGNED NOT NULL,
  `hotel_belanja_id` int(10) UNSIGNED NOT NULL,
  `hotel_paket_wisata_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel_fasilitas`
--

CREATE TABLE `hotel_fasilitas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `hotel_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel_fasilitas_foto`
--

CREATE TABLE `hotel_fasilitas_foto` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_foto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_foto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hotel_fasilitas_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel_kamar`
--

CREATE TABLE `hotel_kamar` (
  `id` int(10) UNSIGNED NOT NULL,
  `jenis_kamar` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `harga_permalam` int(11) NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci NOT NULL,
  `hotel_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel_menginap`
--

CREATE TABLE `hotel_menginap` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `lama_menginap` int(11) NOT NULL DEFAULT 1,
  `jumlah_menginap` int(11) NOT NULL DEFAULT 1,
  `tipe_menginap` enum('nusantara','mancanegara') COLLATE utf8_unicode_ci NOT NULL,
  `harga_perkamar` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hotel_kamar_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel_paket_wisata`
--

CREATE TABLE `hotel_paket_wisata` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL DEFAULT 0,
  `hotel_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Bambanglipuro', NULL, NULL),
(2, 'Banguntapan', NULL, NULL),
(3, 'Bantul', NULL, NULL),
(4, 'Dlingo', NULL, NULL),
(5, 'Imogiri', NULL, NULL),
(6, 'Jetis', NULL, NULL),
(7, 'Kasihan', NULL, NULL),
(8, 'Kretek', NULL, NULL),
(9, 'Pajangan', NULL, NULL),
(10, 'Pandak', NULL, NULL),
(11, 'Piyungan', NULL, NULL),
(12, 'Pleret', NULL, NULL),
(13, 'Pundong', NULL, NULL),
(14, 'Sanden', NULL, NULL),
(15, 'Sedayu', NULL, NULL),
(16, 'Sewon', NULL, NULL),
(17, 'Srandakan', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `kecamatan_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `kelurahan`
--

INSERT INTO `kelurahan` (`id`, `nama`, `kecamatan_id`, `created_at`, `updated_at`) VALUES
(1, 'Sidomulyo', 1, NULL, NULL),
(2, 'Mulyodadi', 1, NULL, NULL),
(3, 'Sumbermulyo', 1, NULL, NULL),
(4, 'Baturetno', 2, NULL, NULL),
(5, 'Banguntapan', 2, NULL, NULL),
(6, 'Jagalan', 2, NULL, NULL),
(7, 'Singosaren', 2, NULL, NULL),
(8, 'Jambidan', 2, NULL, NULL),
(9, 'Potorono', 2, NULL, NULL),
(10, 'Tamanan', 2, NULL, NULL),
(11, 'Wirokerten', 2, NULL, NULL),
(12, 'Palbapang', 3, NULL, NULL),
(13, 'Trirenggo', 3, NULL, NULL),
(14, 'Bantul', 3, NULL, NULL),
(15, 'Sabdodadi', 3, NULL, NULL),
(16, 'Ringinharjo', 3, NULL, NULL),
(17, 'Mangunan', 4, NULL, NULL),
(18, 'Muntuk', 4, NULL, NULL),
(19, 'Dlingo', 4, NULL, NULL),
(20, 'Temuwuh', 4, NULL, NULL),
(21, 'Terong', 4, NULL, NULL),
(22, 'Jatimulyo', 4, NULL, NULL),
(23, 'Selopamioro', 5, NULL, NULL),
(24, 'Sriharjo', 5, NULL, NULL),
(25, 'Wukirsari', 5, NULL, NULL),
(26, 'Kebonagung', 5, NULL, NULL),
(27, 'Karangtengah', 5, NULL, NULL),
(28, 'Girirejo', 5, NULL, NULL),
(29, 'Karangtalun', 5, NULL, NULL),
(30, 'Imogiri', 5, NULL, NULL),
(31, 'Patalan', 6, NULL, NULL),
(32, 'Canden', 6, NULL, NULL),
(33, 'Sumberagung', 6, NULL, NULL),
(34, 'Trimulyo', 6, NULL, NULL),
(35, 'Bangunjiwo', 7, NULL, NULL),
(36, 'Tirtonirmolo', 7, NULL, NULL),
(37, 'Tamantirto', 7, NULL, NULL),
(38, 'Ngestiharjo', 7, NULL, NULL),
(39, 'Tirtomulyo', 8, NULL, NULL),
(40, 'Parangtritis', 8, NULL, NULL),
(41, 'Donotirto', 8, NULL, NULL),
(42, 'Tirtosari', 8, NULL, NULL),
(43, 'Tirtohargo', 8, NULL, NULL),
(44, 'Sendangsari', 9, NULL, NULL),
(45, 'Triwidadi', 9, NULL, NULL),
(46, 'Guwosari', 9, NULL, NULL),
(47, 'Gilangharjo', 10, NULL, NULL),
(48, 'Triharjo', 10, NULL, NULL),
(49, 'Caturharjo', 10, NULL, NULL),
(50, 'Wijirejo', 10, NULL, NULL),
(51, 'Sitimulyo', 11, NULL, NULL),
(52, 'Srimulyo', 11, NULL, NULL),
(53, 'Srimartani', 11, NULL, NULL),
(54, 'Pleret', 12, NULL, NULL),
(55, 'Segoroyoso', 12, NULL, NULL),
(56, 'Bawuran', 12, NULL, NULL),
(57, 'Wonolelo', 12, NULL, NULL),
(58, 'Wonokromo', 12, NULL, NULL),
(59, 'Seloharjo', 13, NULL, NULL),
(60, 'Srihandono', 13, NULL, NULL),
(61, 'Panjangrejo', 13, NULL, NULL),
(62, 'Gadingsari', 14, NULL, NULL),
(63, 'Gadingharjo', 14, NULL, NULL),
(64, 'Srigading', 14, NULL, NULL),
(65, 'Murtigading', 14, NULL, NULL),
(66, 'Argodadi', 15, NULL, NULL),
(67, 'Argorejo', 15, NULL, NULL),
(68, 'Argosari', 15, NULL, NULL),
(69, 'Argomulyo', 15, NULL, NULL),
(70, 'Pendowoharjo', 16, NULL, NULL),
(71, 'Timbulharjo', 16, NULL, NULL),
(72, 'Bangunharjo', 16, NULL, NULL),
(73, 'Panggungharjo', 16, NULL, NULL),
(74, 'Poncosari', 17, NULL, NULL),
(75, 'Trimurti', 17, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menginap`
--

CREATE TABLE `menginap` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `asal_kota_wisatawan` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `lama_menginap` int(11) NOT NULL,
  `jumlah_menginap` int(11) NOT NULL DEFAULT 1,
  `foto` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `tipe_menginap` enum('nusantara','mancanegara') COLLATE utf8_unicode_ci NOT NULL,
  `akomodasi_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menginap_foto`
--

CREATE TABLE `menginap_foto` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_foto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_foto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `menginap_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_10_23_070945_create_kecamatan_table', 1),
(4, '2019_10_23_071041_create_kelurahan_table', 1),
(5, '2019_10_23_123020_entrust_setup_tables', 1),
(6, '2019_10_23_133734_create_wisata_table', 1),
(7, '2019_10_23_134208_create_akomodasi_kategori_table', 1),
(8, '2019_10_23_135755_create_akomodasi_table', 1),
(9, '2019_10_26_161330_create_pengelola_table', 1),
(10, '2019_10_27_101054_create_wisata_kunjungan_table', 1),
(11, '2019_10_27_124425_create_menginap_table', 1),
(12, '2019_10_28_073530_create_belanja_table', 1),
(13, '2019_10_28_125940_create_fasilitas_umum_table', 1),
(14, '2019_10_28_131702_create_wisata_paket_table', 1),
(15, '2019_11_08_074035_create_wisata_photos_table', 1),
(16, '2019_11_08_093427_create_wisata_kunjungan_foto_table', 1),
(17, '2019_11_08_093506_create_belanja_foto_table', 1),
(18, '2019_11_08_093520_create_fasilitas_umum_foto_table', 1),
(19, '2019_11_08_093534_create_menginap_foto_table', 1),
(20, '2019_11_15_222439_create_hotel_table', 1),
(21, '2019_11_15_222853_create_hotel_kamar_table', 1),
(22, '2019_11_15_234923_create_hotel_menginap_table', 1),
(23, '2019_11_22_084743_create_belanja_paket_wisata_table', 1),
(24, '2019_11_26_044457_create_hotel_fasilitas_table', 1),
(25, '2019_11_26_044650_create_hotel_fasilitas_foto_table', 1),
(26, '2019_11_26_104404_create_hotel_belanja_table', 1),
(27, '2019_11_26_104546_create_hotel_belanja_foto_table', 1),
(28, '2019_11_26_104557_create_hotel_paket_wisata_table', 1),
(29, '2019_11_26_112927_create_hotel_belanja_paket_wisata_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('raflesh89@gmail.com', '$2y$10$em6Vf2MbOos8ymzFVuM8zOJAtrtQTxTuniCeUe3bGKrq4E7XB54DO', '2022-05-09 07:07:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_destinasi`
--

CREATE TABLE `pengajuan_destinasi` (
  `id_pengajuan` int(11) NOT NULL,
  `path_file_susunan_pengurus` varchar(255) NOT NULL,
  `path_file_permohonan_registrasi` varchar(255) NOT NULL,
  `path_file_foto_deskripsi` varchar(255) NOT NULL,
  `tanggal_pengajuan` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `id_hotel` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengajuan_destinasi`
--

INSERT INTO `pengajuan_destinasi` (`id_pengajuan`, `path_file_susunan_pengurus`, `path_file_permohonan_registrasi`, `path_file_foto_deskripsi`, `tanggal_pengajuan`, `status`, `id_hotel`, `id_wisata`, `updated_at`, `created_at`, `deleted_at`) VALUES
(27, 'path_file_a', 'path_file_b', 'path_file_c', '2022-05-07 06:37:45', 1, 31, 0, '2022-05-07 06:38:52', '2022-05-07 06:37:45', '0000-00-00 00:00:00'),
(28, 'path_file_susunan_pengurus', 'path_file_permohonan_registrasi', 'path_file_foto_deskripsi', '2022-05-08 02:26:26', 0, 0, 3, '2022-05-08 02:26:26', '2022-05-08 02:26:26', '0000-00-00 00:00:00'),
(29, 'uploads/doc_registrasi/jambidan/jambidansusunan_pengurus1651977607.docx', 'path_file_permohonan_registrasi', 'path_file_foto_deskripsi', '2022-05-08 02:40:07', 0, 0, 4, '2022-05-08 02:40:07', '2022-05-08 02:40:07', '0000-00-00 00:00:00'),
(30, 'uploads/doc_registrasi/mangunan/mangunan_susunan_pengurus_1651979306.docx', 'path_file_permohonan_registrasi', 'path_file_foto_deskripsi', '2022-05-08 03:08:26', 0, 0, 6, '2022-05-08 03:08:26', '2022-05-08 03:08:26', '0000-00-00 00:00:00'),
(31, 'uploads/doc_registrasi/karang_user/karang_user_susunan_pengurus_1651990142.docx', 'path_file_permohonan_registrasi', 'path_file_foto_deskripsi', '2022-05-08 06:09:02', 1, 0, 7, '2022-05-08 09:24:48', '2022-05-08 06:09:02', '0000-00-00 00:00:00'),
(32, 'uploads/doc_registrasi/batu_user/batu_user_susunan_pengurus_1652090340.docx', 'path_file_permohonan_registrasi', 'path_file_foto_deskripsi', '2022-05-09 16:59:00', 0, 0, 8, '2022-05-09 16:59:00', '2022-05-09 16:59:00', '0000-00-00 00:00:00'),
(33, 'uploads/doc_registrasi/ringinharjo/ringinharjo_susunan_pengurus_1652346211.docx', 'uploads/doc_registrasi/ringinharjo/ringinharjo_permohonan_1652346211.docx', 'uploads/doc_registrasi/ringinharjo/ringinharjo_foto_deskripsi_1652346211.docx', '2022-05-12 16:03:31', 0, 0, 11, '2022-05-12 16:03:31', '2022-05-12 16:03:31', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengelola`
--

CREATE TABLE `pengelola` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `wisata_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `pengelola`
--

INSERT INTO `pengelola` (`id`, `user_id`, `wisata_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 50, 7, '2022-05-09 08:40:31', NULL, NULL),
(2, 51, 8, '2022-05-09 09:59:00', '2022-05-09 09:59:00', NULL),
(3, 52, 11, '2022-05-12 09:03:31', '2022-05-12 09:03:31', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'superadmin', NULL, '2022-05-01 04:39:16', NULL),
(2, 'operator_hotel', 'operator_hotel', NULL, '2022-05-01 05:45:05', NULL),
(3, 'operator', 'operator', 'operator', '2022-05-07 06:55:59', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(35, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 3),
(51, 3),
(52, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `no_hp` varchar(13) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0831',
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_counter` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `no_hp`, `email`, `password`, `deskripsi`, `status`, `remember_token`, `login_counter`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'raflesh', 'Muhammad Rafli', '0831', 'frisse.indonesia@gmail.com', '$2y$10$m6qYiHtHhgwRr18LkHICo.k0K.yHMqHZTy3qdulqHCyQ0oFjooBVS', NULL, 1, 'MaPpDNpNek4WJ5oLjLAs4CtLgUKMtsjfuSdE7xmwlfJjnZDpkaw4bCg9a5zU', 0, NULL, '2022-05-12 12:01:02', NULL),
(35, 'hotel_sari', 'hotel_sari', '', 'raflesh89asd@gmail.com', '$2y$10$MuQY3R2NUv4agbozhKFXKOms59Uo7tGXqcL30Is8.gdRMEar/sMJK', '', 1, '7TpQaZ9BzzxrnyEeKoZwt5gwdxppMcrwVuaHQf4Tv8LR5mjnnS2qfh6nBKXA', 0, '2022-05-06 23:37:45', '2022-05-06 23:38:52', NULL),
(45, 'jambidan', 'jambidan', '', 'jambidan@mail.com', '$2y$10$wch0eFWDbG8fCc/roUCqw.oDYJQTwTeVzRRB3TA6B0LLmjHN6t192', '', 0, NULL, 0, '2022-05-07 19:40:07', '2022-05-09 08:20:35', NULL),
(46, 'dfgdfgdfgfdgfd', 'rewredsadasds', '', 'sdfsdf@SDfds.fdfasde', '$2y$10$nNkU.VaO1pSyI7HmNrNDqOJQd4JQrIT6UbokKBpTcbGhGbl8PicXa', '', 0, NULL, 0, '2022-05-07 19:56:36', '2022-05-07 19:56:36', NULL),
(47, 'dfgdfgfdgfdgfdfd', 'rewredsadasds', '', 'sdfsdf@SDfds.fdfasdesd', '$2y$10$OspO/XTjEFvvftfh90VBkuUOXXVwKF5kUnrHywa64dXgFa4RzmCO.', '', 0, NULL, 0, '2022-05-07 19:59:17', '2022-05-07 19:59:17', NULL),
(48, 'ewdgfdbvvcxv', 'wwqesdfddf', '', 'qweqwe@sd.ds', '$2y$10$CcA41.Eo9otFvMLijsWM3.0ItEyT1wyL8VH2S60LPG.W.kQrivLhi', '', 0, NULL, 0, '2022-05-07 20:00:13', '2022-05-07 20:00:13', NULL),
(49, 'mangunan12', 'mangunan', '', 'mangunan@mail.com', '$2y$10$Tc3I8Hw.54A.RNAvAhVxsOcFiXMBtg14ZmFBnbVVti6fBB6YBT/SW', '', 0, NULL, 0, '2022-05-07 20:08:26', '2022-05-07 20:08:26', NULL),
(50, 'karang_user', 'karang_user', '', 'raflesh89@gmail.com', '$2y$10$g7ouoET5UClZDxMyiYUpcOgzqlIyvle05GheJcXPQm6vV5MpQc./m', '', 1, '7YJW2qRwbGi10ObqBFy6KjT672VN47FHubXIA1iBA716I7SRtxChuicLTbde', 0, '2022-05-07 23:09:02', '2022-05-09 08:28:31', NULL),
(51, 'batu_user', 'batu_user', '', 'batu@mail.com', '$2y$10$2yjaybzRjtP.Gq2NxlQzv.HCgaWkDKByWYv/YRTWnSIjx9bGDQA5K', '', 0, NULL, 0, '2022-05-09 09:59:00', '2022-05-09 09:59:00', NULL),
(52, 'ringinharjo', 'ringinharjo', '', 'ringinharjo@mail.com', '$2y$10$D63Jtr82snmIorXZH/Tsku6dBbXsJ6NPojjOY.6tdLNX4IQ0yGpPy', '', 0, NULL, 0, '2022-05-12 09:03:31', '2022-05-12 09:03:31', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata`
--

CREATE TABLE `wisata` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `kelurahan_id` int(10) UNSIGNED NOT NULL,
  `tipe_wisata` enum('obyek','desa') COLLATE utf8_unicode_ci NOT NULL,
  `user_id_wisata` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `wisata`
--

INSERT INTO `wisata` (`id`, `nama`, `alamat`, `foto`, `jam_buka`, `jam_tutup`, `kelurahan_id`, `tipe_wisata`, `user_id_wisata`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sriharjo', 'Sriharjo', '', '06:53:02', '23:53:02', 32, 'obyek', 0, NULL, NULL, NULL),
(3, 'sdfsdfdsf', 'dsfdsfdfd', '', NULL, NULL, 5, 'obyek', 44, '2022-05-07 19:26:26', '2022-05-07 19:26:26', NULL),
(4, 'Jambidan lovers', 'jambidan', '', NULL, NULL, 8, 'obyek', 45, '2022-05-07 19:40:07', '2022-05-07 19:40:07', NULL),
(5, 'asdsdfdsf', 'Karang, Sumberagung, Moyudan, Sleman', '', NULL, NULL, 17, 'obyek', 46, '2022-05-07 19:56:36', '2022-05-07 19:56:36', NULL),
(6, 'mangunan', 'mangunan', '', NULL, NULL, 17, 'obyek', 49, '2022-05-07 20:08:26', '2022-05-07 20:08:26', NULL),
(7, 'desa karang', 'Karang, Sumberagung, Moyudan, Sleman', '', NULL, NULL, 21, 'obyek', 50, '2022-05-07 23:09:02', '2022-05-07 23:09:02', NULL),
(8, 'desa_batu', 'batu_user', '', NULL, NULL, 13, 'obyek', 51, '2022-05-09 09:59:00', '2022-05-09 09:59:00', NULL),
(9, 'Muhammad Rafli Shalehudin', 'dqwdqwdw', 'uploads/default.jpg', '07:30:00', NULL, 70, 'obyek', 0, '2022-05-12 08:56:48', '2022-05-12 08:56:48', NULL),
(10, 'test12345', 'qwertyu', 'uploads/default.jpg', '08:30:00', NULL, 62, 'obyek', 0, '2022-05-12 08:57:29', '2022-05-12 12:04:09', '2022-05-12 12:04:09'),
(11, 'desa ringinharjo', 'ringinharjo', '', NULL, NULL, 16, 'obyek', 52, '2022-05-12 09:03:31', '2022-05-12 09:03:31', NULL),
(12, 'qwewqqwe', 'qweqwewq', 'uploads/default.jpg', '19:30:00', NULL, 62, 'obyek', 0, '2022-05-12 09:14:44', '2022-05-12 12:04:17', '2022-05-12 12:04:17'),
(13, 'qweqweqw', 'asdqwdqwdw', 'uploads/default.jpg', '20:30:00', NULL, 12, 'obyek', 0, '2022-05-12 09:17:00', '2022-05-12 09:17:00', NULL),
(14, 'qweqweqw', 'asdqwdqwdw', 'uploads/default.jpg', '20:30:00', NULL, 12, 'obyek', 0, '2022-05-12 09:18:01', '2022-05-12 09:18:01', NULL),
(15, 'qwewqeqw', 'wfeeef', 'uploads/default.jpg', '19:30:00', NULL, 70, 'obyek', 0, '2022-05-12 09:29:40', '2022-05-12 09:29:40', NULL),
(16, 'qwewqeqw', 'wfeeef', 'uploads/default.jpg', '19:30:00', NULL, 62, 'obyek', 0, '2022-05-12 09:29:57', '2022-05-12 09:29:57', NULL),
(17, 'asdasdas', 'ververrev', 'uploads/default.jpg', '08:30:00', NULL, 62, 'obyek', 0, '2022-05-12 12:03:49', '2022-05-12 12:03:49', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata_foto`
--

CREATE TABLE `wisata_foto` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_foto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_foto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `wisata_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `wisata_foto`
--

INSERT INTO `wisata_foto` (`id`, `nama_foto`, `url_foto`, `wisata_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', 'uploads/obyek_wisata/1652345849/1652345849bandit.json', 10, '2022-05-12 08:57:29', '2022-05-12 08:57:29', NULL),
(2, NULL, 'uploads/obyek_wisata/1652346884/1652346884Pengajuan_Lamp_B.docx', 12, '2022-05-12 09:14:44', '2022-05-12 09:14:44', NULL),
(3, NULL, 'uploads/obyek_wisata/1652347797/1652347797background-2.jpg', 16, '2022-05-12 09:29:57', '2022-05-12 09:29:57', NULL),
(4, NULL, 'uploads/obyek_wisata/1652347797/1652347797background-3.jpg', 16, '2022-05-12 09:29:57', '2022-05-12 09:29:57', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata_kunjungan`
--

CREATE TABLE `wisata_kunjungan` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_wisatawan` int(11) NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `tipe_kunjungan` enum('nusantara','mancanegara') COLLATE utf8_unicode_ci NOT NULL,
  `wisata_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `wisata_kunjungan`
--

INSERT INTO `wisata_kunjungan` (`id`, `tanggal`, `jumlah_wisatawan`, `keterangan`, `foto`, `tipe_kunjungan`, `wisata_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2022-05-02', 12, NULL, '', 'nusantara', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata_kunjungan_foto`
--

CREATE TABLE `wisata_kunjungan_foto` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_foto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_foto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `wisata_kunjungan_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata_paket`
--

CREATE TABLE `wisata_paket` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL DEFAULT 0,
  `wisata_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akomodasi`
--
ALTER TABLE `akomodasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `akomodasi_akomodasi_kategori_id_foreign` (`akomodasi_kategori_id`),
  ADD KEY `akomodasi_wisata_id_foreign` (`wisata_id`);

--
-- Indeks untuk tabel `akomodasi_kategori`
--
ALTER TABLE `akomodasi_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `belanja`
--
ALTER TABLE `belanja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `belanja_wisata_id_foreign` (`wisata_id`);

--
-- Indeks untuk tabel `belanja_foto`
--
ALTER TABLE `belanja_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `belanja_foto_belanja_id_foreign` (`belanja_id`);

--
-- Indeks untuk tabel `belanja_wisata_paket`
--
ALTER TABLE `belanja_wisata_paket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `belanja_wisata_paket_belanja_id_foreign` (`belanja_id`),
  ADD KEY `belanja_wisata_paket_wisata_paket_id_foreign` (`wisata_paket_id`);

--
-- Indeks untuk tabel `fasilitas_umum`
--
ALTER TABLE `fasilitas_umum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fasilitas_umum_wisata_id_foreign` (`wisata_id`);

--
-- Indeks untuk tabel `fasilitas_umum_foto`
--
ALTER TABLE `fasilitas_umum_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fasilitas_umum_foto_fasilitas_umum_id_foreign` (`fasilitas_umum_id`);

--
-- Indeks untuk tabel `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hotel_email_hotel_unique` (`email_hotel`),
  ADD KEY `hotel_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `hotel_belanja`
--
ALTER TABLE `hotel_belanja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_belanja_hotel_id_foreign` (`hotel_id`);

--
-- Indeks untuk tabel `hotel_belanja_foto`
--
ALTER TABLE `hotel_belanja_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_belanja_foto_hotel_belanja_id_foreign` (`hotel_belanja_id`);

--
-- Indeks untuk tabel `hotel_belanja_paket_wisata`
--
ALTER TABLE `hotel_belanja_paket_wisata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_belanja_paket_wisata_hotel_belanja_id_foreign` (`hotel_belanja_id`),
  ADD KEY `hotel_belanja_paket_wisata_hotel_paket_wisata_id_foreign` (`hotel_paket_wisata_id`);

--
-- Indeks untuk tabel `hotel_fasilitas`
--
ALTER TABLE `hotel_fasilitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_fasilitas_hotel_id_foreign` (`hotel_id`);

--
-- Indeks untuk tabel `hotel_fasilitas_foto`
--
ALTER TABLE `hotel_fasilitas_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_fasilitas_foto_hotel_fasilitas_id_foreign` (`hotel_fasilitas_id`);

--
-- Indeks untuk tabel `hotel_kamar`
--
ALTER TABLE `hotel_kamar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_kamar_hotel_id_foreign` (`hotel_id`);

--
-- Indeks untuk tabel `hotel_menginap`
--
ALTER TABLE `hotel_menginap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_menginap_hotel_kamar_id_foreign` (`hotel_kamar_id`);

--
-- Indeks untuk tabel `hotel_paket_wisata`
--
ALTER TABLE `hotel_paket_wisata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_paket_wisata_hotel_id_foreign` (`hotel_id`);

--
-- Indeks untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelurahan_kecamatan_id_foreign` (`kecamatan_id`) USING BTREE;

--
-- Indeks untuk tabel `menginap`
--
ALTER TABLE `menginap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menginap_akomodasi_id_foreign` (`akomodasi_id`);

--
-- Indeks untuk tabel `menginap_foto`
--
ALTER TABLE `menginap_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menginap_foto_menginap_id_foreign` (`menginap_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pengajuan_destinasi`
--
ALTER TABLE `pengajuan_destinasi`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indeks untuk tabel `pengelola`
--
ALTER TABLE `pengelola`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengelola_user_id_foreign` (`user_id`),
  ADD KEY `pengelola_wisata_id_foreign` (`wisata_id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indeks untuk tabel `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indeks untuk tabel `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `wisata`
--
ALTER TABLE `wisata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wisata_kelurahan_id_foreign` (`kelurahan_id`);

--
-- Indeks untuk tabel `wisata_foto`
--
ALTER TABLE `wisata_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wisata_foto_wisata_id_foreign` (`wisata_id`);

--
-- Indeks untuk tabel `wisata_kunjungan`
--
ALTER TABLE `wisata_kunjungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wisata_kunjungan_wisata_id_foreign` (`wisata_id`);

--
-- Indeks untuk tabel `wisata_kunjungan_foto`
--
ALTER TABLE `wisata_kunjungan_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wisata_kunjungan_foto_wisata_kunjungan_id_foreign` (`wisata_kunjungan_id`);

--
-- Indeks untuk tabel `wisata_paket`
--
ALTER TABLE `wisata_paket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wisata_paket_wisata_id_foreign` (`wisata_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akomodasi`
--
ALTER TABLE `akomodasi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `akomodasi_kategori`
--
ALTER TABLE `akomodasi_kategori`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `belanja`
--
ALTER TABLE `belanja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `belanja_foto`
--
ALTER TABLE `belanja_foto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `belanja_wisata_paket`
--
ALTER TABLE `belanja_wisata_paket`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `fasilitas_umum`
--
ALTER TABLE `fasilitas_umum`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `fasilitas_umum_foto`
--
ALTER TABLE `fasilitas_umum_foto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `hotel_belanja`
--
ALTER TABLE `hotel_belanja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hotel_belanja_foto`
--
ALTER TABLE `hotel_belanja_foto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hotel_belanja_paket_wisata`
--
ALTER TABLE `hotel_belanja_paket_wisata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hotel_fasilitas`
--
ALTER TABLE `hotel_fasilitas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hotel_fasilitas_foto`
--
ALTER TABLE `hotel_fasilitas_foto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hotel_kamar`
--
ALTER TABLE `hotel_kamar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hotel_menginap`
--
ALTER TABLE `hotel_menginap`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hotel_paket_wisata`
--
ALTER TABLE `hotel_paket_wisata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `menginap`
--
ALTER TABLE `menginap`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menginap_foto`
--
ALTER TABLE `menginap_foto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_destinasi`
--
ALTER TABLE `pengajuan_destinasi`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `pengelola`
--
ALTER TABLE `pengelola`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `wisata`
--
ALTER TABLE `wisata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `wisata_foto`
--
ALTER TABLE `wisata_foto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `wisata_kunjungan`
--
ALTER TABLE `wisata_kunjungan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `wisata_kunjungan_foto`
--
ALTER TABLE `wisata_kunjungan_foto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wisata_paket`
--
ALTER TABLE `wisata_paket`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akomodasi`
--
ALTER TABLE `akomodasi`
  ADD CONSTRAINT `akomodasi_akomodasi_kategori_id_foreign` FOREIGN KEY (`akomodasi_kategori_id`) REFERENCES `akomodasi_kategori` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `akomodasi_wisata_id_foreign` FOREIGN KEY (`wisata_id`) REFERENCES `wisata` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `belanja`
--
ALTER TABLE `belanja`
  ADD CONSTRAINT `belanja_wisata_id_foreign` FOREIGN KEY (`wisata_id`) REFERENCES `wisata` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `belanja_foto`
--
ALTER TABLE `belanja_foto`
  ADD CONSTRAINT `belanja_foto_belanja_id_foreign` FOREIGN KEY (`belanja_id`) REFERENCES `belanja` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `belanja_wisata_paket`
--
ALTER TABLE `belanja_wisata_paket`
  ADD CONSTRAINT `belanja_wisata_paket_belanja_id_foreign` FOREIGN KEY (`belanja_id`) REFERENCES `belanja` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `belanja_wisata_paket_wisata_paket_id_foreign` FOREIGN KEY (`wisata_paket_id`) REFERENCES `wisata_paket` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `fasilitas_umum`
--
ALTER TABLE `fasilitas_umum`
  ADD CONSTRAINT `fasilitas_umum_wisata_id_foreign` FOREIGN KEY (`wisata_id`) REFERENCES `wisata` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `fasilitas_umum_foto`
--
ALTER TABLE `fasilitas_umum_foto`
  ADD CONSTRAINT `fasilitas_umum_foto_fasilitas_umum_id_foreign` FOREIGN KEY (`fasilitas_umum_id`) REFERENCES `fasilitas_umum` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `hotel_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hotel_belanja`
--
ALTER TABLE `hotel_belanja`
  ADD CONSTRAINT `hotel_belanja_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hotel_belanja_foto`
--
ALTER TABLE `hotel_belanja_foto`
  ADD CONSTRAINT `hotel_belanja_foto_hotel_belanja_id_foreign` FOREIGN KEY (`hotel_belanja_id`) REFERENCES `hotel_belanja` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hotel_belanja_paket_wisata`
--
ALTER TABLE `hotel_belanja_paket_wisata`
  ADD CONSTRAINT `hotel_belanja_paket_wisata_hotel_belanja_id_foreign` FOREIGN KEY (`hotel_belanja_id`) REFERENCES `hotel_belanja` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hotel_belanja_paket_wisata_hotel_paket_wisata_id_foreign` FOREIGN KEY (`hotel_paket_wisata_id`) REFERENCES `hotel_paket_wisata` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hotel_fasilitas`
--
ALTER TABLE `hotel_fasilitas`
  ADD CONSTRAINT `hotel_fasilitas_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hotel_fasilitas_foto`
--
ALTER TABLE `hotel_fasilitas_foto`
  ADD CONSTRAINT `hotel_fasilitas_foto_hotel_fasilitas_id_foreign` FOREIGN KEY (`hotel_fasilitas_id`) REFERENCES `hotel_fasilitas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hotel_kamar`
--
ALTER TABLE `hotel_kamar`
  ADD CONSTRAINT `hotel_kamar_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hotel_menginap`
--
ALTER TABLE `hotel_menginap`
  ADD CONSTRAINT `hotel_menginap_hotel_kamar_id_foreign` FOREIGN KEY (`hotel_kamar_id`) REFERENCES `hotel_kamar` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hotel_paket_wisata`
--
ALTER TABLE `hotel_paket_wisata`
  ADD CONSTRAINT `hotel_paket_wisata_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD CONSTRAINT `kelurahan_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menginap`
--
ALTER TABLE `menginap`
  ADD CONSTRAINT `menginap_akomodasi_id_foreign` FOREIGN KEY (`akomodasi_id`) REFERENCES `akomodasi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menginap_foto`
--
ALTER TABLE `menginap_foto`
  ADD CONSTRAINT `menginap_foto_menginap_id_foreign` FOREIGN KEY (`menginap_id`) REFERENCES `menginap` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengelola`
--
ALTER TABLE `pengelola`
  ADD CONSTRAINT `pengelola_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengelola_wisata_id_foreign` FOREIGN KEY (`wisata_id`) REFERENCES `wisata` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wisata`
--
ALTER TABLE `wisata`
  ADD CONSTRAINT `wisata_kelurahan_id_foreign` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wisata_foto`
--
ALTER TABLE `wisata_foto`
  ADD CONSTRAINT `wisata_foto_wisata_id_foreign` FOREIGN KEY (`wisata_id`) REFERENCES `wisata` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wisata_kunjungan`
--
ALTER TABLE `wisata_kunjungan`
  ADD CONSTRAINT `wisata_kunjungan_wisata_id_foreign` FOREIGN KEY (`wisata_id`) REFERENCES `wisata` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wisata_kunjungan_foto`
--
ALTER TABLE `wisata_kunjungan_foto`
  ADD CONSTRAINT `wisata_kunjungan_foto_wisata_kunjungan_id_foreign` FOREIGN KEY (`wisata_kunjungan_id`) REFERENCES `wisata_kunjungan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wisata_paket`
--
ALTER TABLE `wisata_paket`
  ADD CONSTRAINT `wisata_paket_wisata_id_foreign` FOREIGN KEY (`wisata_id`) REFERENCES `wisata` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
