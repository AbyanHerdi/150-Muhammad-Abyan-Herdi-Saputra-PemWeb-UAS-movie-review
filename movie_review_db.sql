-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Nov 2025 pada 07.24
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_review_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `original_title` varchar(200) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'durasi dalam menit',
  `genre` varchar(100) DEFAULT NULL,
  `director` varchar(100) DEFAULT NULL,
  `cast` text DEFAULT NULL COMMENT 'JSON array atau comma separated',
  `synopsis` text DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `average_rating` decimal(2,1) DEFAULT 0.0,
  `total_reviews` int(11) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `movies`
--

INSERT INTO `movies` (`id`, `title`, `original_title`, `release_year`, `duration`, `genre`, `director`, `cast`, `synopsis`, `poster`, `trailer_url`, `average_rating`, `total_reviews`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Sore', 'Sore', 2025, 120, 'Drama Romantis-Fantasi Ilmiah', 'Unknown', NULL, 'Cerita cinta yang melampaui dimensi', 'uploads/posters/1763650145_1763647992_download.jpeg', '', 4.6, 1, 1, '2025-11-16 16:37:15', '2025-11-22 19:22:50'),
(2, 'Petaka Gunung Gede', 'Petaka Gunung Gede', 2025, 110, 'Horor-Petualangan', 'Unknown', NULL, 'Petualangan menakutkan di gunung misteri', 'uploads/posters/1763610205_1763609215_Poster_Petaka_Gunung_Gede.jpg', NULL, 4.6, 1, 1, '2025-11-16 16:37:15', '2025-11-20 16:06:40'),
(3, 'Dilan 1990', 'Dilan 1990', 2018, 110, 'Documentary, Drama', 'Fajar Bustomi', NULL, 'Kisah cinta legendaris di era 90-an', 'uploads/posters/1763606451_250px-Dilan_1990_(poster).jpg', '', 5.0, 28, 1, '2025-11-16 16:37:15', '2025-11-22 19:23:12'),
(4, 'Rest Area', 'Rest Area', 2025, 95, 'Horor', 'Unknown', NULL, 'Malam mencekam di rest area terisolasi', 'uploads/posters/1763649700_15RARA.jpg', NULL, 5.0, 1, 1, '2025-11-16 16:37:15', '2025-11-22 03:04:26'),
(5, 'Tukar Takdir', 'Tukar Takdir', 2025, 110, 'Drama', 'Unknown', NULL, 'Aplikasi yang bisa menukar nasib', 'uploads/posters/1763774958_15TTAR.jpg', '', 4.8, 1, 1, '2025-11-16 16:37:15', '2025-11-22 03:04:26'),
(6, 'Rangga & Cinta', 'Rangga & Cinta', 2025, 120, 'Drama, Romantis', 'Unknown', NULL, 'Kisah cinta Rangga dan Cinta', 'uploads/posters/1763775018_image_870x_68af78dbc0cab (1).webp', '', 5.0, 1, 1, '2025-11-16 16:37:15', '2025-11-22 03:04:26'),
(7, 'QQ', NULL, 2025, 122, 'Horor', 'Fernando', NULL, '222', 'uploads/posters/1763778648_WhatsApp_Image_2025-11-04_at_19.35.05_a909b587.jpg', 'https://youtu.be/IZ72D_NKBNQ?si=d_NDZe2SHXm-cEi7', 0.0, 0, NULL, '2025-11-22 02:30:48', '2025-11-22 02:35:05'),
(8, 'JJ', NULL, 2025, 99, 'Horor, Petualangan', 'ssss', NULL, 'JJ', 'uploads/posters/1763778967_images.jpeg', 'https://youtu.be/IZ72D_NKBNQ?si=d_NDZe2SHXm-cEi7', 0.0, 0, NULL, '2025-11-22 02:36:07', '2025-11-22 03:02:51'),
(13, 'tess', NULL, 2025, 120, 'Drama Romantis, Fantasi Ilmiah', 'Fajar Bustomi', NULL, 'aaaaaaaa', 'uploads/posters/1764043395_1763681189_Screenshot (137).png', 'https://youtu.be/XZNM4jn41BQ?si=K-3D9ewOYdX7_DAW', 0.0, 0, NULL, '2025-11-25 04:03:15', '2025-11-25 04:03:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `movies_backup`
--

CREATE TABLE `movies_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `title` varchar(200) NOT NULL,
  `original_title` varchar(200) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'durasi dalam menit',
  `genre` varchar(100) DEFAULT NULL,
  `director` varchar(100) DEFAULT NULL,
  `cast` text DEFAULT NULL COMMENT 'JSON array atau comma separated',
  `synopsis` text DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `average_rating` decimal(3,1) DEFAULT 0.0,
  `total_reviews` int(11) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `movies_backup`
--

INSERT INTO `movies_backup` (`id`, `title`, `original_title`, `release_year`, `duration`, `genre`, `director`, `cast`, `synopsis`, `poster`, `trailer_url`, `average_rating`, `total_reviews`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Inception', 'Inception', 2010, 148, 'Sci-Fi, Thriller', 'Christopher Nolan', NULL, 'A thief who steals corporate secrets through the use of dream-sharing technology.', NULL, NULL, 5.0, 1, 1, '2025-11-13 16:21:35', '2025-11-16 16:07:41'),
(2, 'The Shawshank Redemption', 'The Shawshank Redemption', 1994, 142, 'Drama', 'Frank Darabont', NULL, 'Two imprisoned men bond over years, finding solace and redemption.', NULL, NULL, 4.3, 6, 1, '2025-11-13 16:21:35', '2025-11-16 16:07:41'),
(4, 'Pulp Fiction', 'Pulp Fiction', 1994, 154, 'Crime, Drama', 'Quentin Tarantino', NULL, 'Various interconnected stories of crime in Los Angeles.', NULL, NULL, 0.0, 0, 1, '2025-11-13 16:21:35', '2025-11-13 16:21:35'),
(5, 'Parasite', '기생충', 2019, 132, 'Drama, Thriller', 'Bong Joon-ho', NULL, 'A poor family schemes to become employed by a wealthy family.', NULL, NULL, 4.5, 2, 1, '2025-11-13 16:21:35', '2025-11-16 16:07:41'),
(6, 'film rawr', NULL, 2025, NULL, 'hantu', NULL, NULL, 'rawrrrrrr', NULL, NULL, 0.0, 0, 1, '2025-11-13 18:11:42', '2025-11-13 18:11:42'),
(7, 'film rawr', NULL, 2023, NULL, 'hantu', NULL, NULL, 'horor', NULL, NULL, 0.0, 0, 1, '2025-11-13 18:27:35', '2025-11-13 18:27:35'),
(8, 'pp', NULL, 2022, NULL, 'horor', NULL, NULL, 'hororrrr', NULL, NULL, 0.0, 0, 1, '2025-11-13 18:43:33', '2025-11-13 18:43:33'),
(9, 'coba tes', 'rawrrrr', 2025, 0, 'Horor', 'Fernando', NULL, 'wkwkwkwkwk', 'uploads/posters/1763124520_2.png', 'https://youtu.be/IZ72D_NKBNQ?si=d_NDZe2SHXm-cEi7', 0.0, 0, NULL, '2025-11-14 12:48:40', '2025-11-14 12:48:40'),
(10, 'AYAM NASI', 'gorengan', 2025, 123, 'AKSI', 'NANDO', NULL, 'AYAM BERTEMU NASI', 'uploads/posters/1763219481_1944250.png', 'https://youtu.be/wCZXOpqNUqA?si=SEoyXA2_UrcoQUTk', 0.0, 0, NULL, '2025-11-15 15:11:21', '2025-11-15 15:11:21'),
(11, 'Sore', 'Sore', 2025, 120, 'Drama Romantis, Fantasi Ilmiah', 'TBA', NULL, 'Sebuah cerita tentang cinta yang melampaui dimensi. Film ini mengisahkan perjalanan cinta yang tidak terbatas oleh ruang dan waktu.', 'uploads/posters/sore.jpg', '', 0.0, 0, NULL, '2025-11-16 11:38:42', '2025-11-16 16:07:41'),
(12, 'Petaka Gunung Gede', 'Petaka Gunung Gede', 2025, 110, 'Horor, Petualangan', 'TBA', NULL, 'Petualangan menakutkan di gunung yang penuh misteri. Sekelompok pendaki menghadapi teror supernatural di Gunung Gede yang angker.', 'uploads/posters/petaka-gunung-gede.jpg', '', 0.0, 0, NULL, '2025-11-16 11:38:42', '2025-11-16 16:07:41'),
(13, 'Dilan 1990', 'Dilan 1990', 2018, 110, 'Documentary, Drama', 'Fajar Bustomi, Pidi Baiq', NULL, 'Kisah cinta legendaris di era 90-an. Dilan, seorang siswa SMA yang karismatik, jatuh cinta pada Milea yang baru pindah ke Bandung.', 'uploads/posters/dilan-1990.jpg', '', 0.0, 0, NULL, '2025-11-16 11:38:42', '2025-11-16 16:07:41'),
(14, 'Rest Area', 'Rest Area', 2025, 95, 'Horor', 'TBA', NULL, 'Malam mencekam di rest area yang terisolasi. Sebuah keluarga terjebak di rest area tol yang menyimpan rahasia kelam dan teror mengerikan.', 'uploads/posters/rest-area.jpg', '', 0.0, 0, NULL, '2025-11-16 11:38:42', '2025-11-16 16:07:41'),
(15, 'Tukar Takdir', 'Tukar Takdir', 2025, 105, 'Drama', 'TBA', NULL, 'Ketika sebuah aplikasi bisa menukar nasib hidupmu. Film tentang konsekuensi dari keinginan untuk mengubah takdir.', 'uploads/posters/tukar-takdir.jpg', '', 0.0, 0, NULL, '2025-11-16 11:38:42', '2025-11-16 16:07:41'),
(16, 'Rangga & Cinta', 'Rangga & Cinta', 2025, 115, 'Drama, Romantis', 'TBA', NULL, 'Adaptasi dari kisah Rangga dan Cinta. Sebuah kisah cinta yang penuh dengan konflik dan pengorbanan antara dua insan yang saling mencintai.', 'uploads/posters/rangga-cinta.jpg', '', 0.0, 0, NULL, '2025-11-16 11:38:42', '2025-11-16 16:07:41'),
(17, 'Sore', 'Sore', 2025, 120, 'Drama Romantis, Fantasi Ilmiah', 'TBA', NULL, 'Sebuah cerita tentang cinta yang melampaui dimensi. Film ini mengisahkan perjalanan cinta yang tidak terbatas oleh ruang dan waktu.', 'uploads/posters/sore.jpg', '', 0.0, 0, NULL, '2025-11-16 11:50:59', '2025-11-16 16:07:41'),
(18, 'Petaka Gunung Gede', 'Petaka Gunung Gede', 2025, 110, 'Horor, Petualangan', 'TBA', NULL, 'Petualangan menakutkan di gunung yang penuh misteri. Sekelompok pendaki menghadapi teror supernatural di Gunung Gede yang angker.', 'uploads/posters/petaka-gunung-gede.jpg', '', 0.0, 0, NULL, '2025-11-16 11:50:59', '2025-11-16 16:07:41'),
(19, 'Dilan 1990', 'Dilan 1990', 2018, 110, 'Documentary, Drama', 'Fajar Bustomi, Pidi Baiq', NULL, 'Kisah cinta legendaris di era 90-an. Dilan, seorang siswa SMA yang karismatik, jatuh cinta pada Milea yang baru pindah ke Bandung.', 'uploads/posters/dilan-1990.jpg', '', 0.0, 0, NULL, '2025-11-16 11:50:59', '2025-11-16 16:07:41'),
(20, 'Rest Area', 'Rest Area', 2025, 95, 'Horor', 'TBA', NULL, 'Malam mencekam di rest area yang terisolasi. Sebuah keluarga terjebak di rest area tol yang menyimpan rahasia kelam dan teror mengerikan.', 'uploads/posters/rest-area.jpg', '', 0.0, 0, NULL, '2025-11-16 11:50:59', '2025-11-16 16:07:41'),
(21, 'Tukar Takdir', 'Tukar Takdir', 2025, 105, 'Drama', 'TBA', NULL, 'Ketika sebuah aplikasi bisa menukar nasib hidupmu. Film tentang konsekuensi dari keinginan untuk mengubah takdir.', 'uploads/posters/tukar-takdir.jpg', '', 0.0, 0, NULL, '2025-11-16 11:50:59', '2025-11-16 16:07:41'),
(22, 'Rangga & Cinta', 'Rangga & Cinta', 2025, 115, 'Drama, Romantis', 'TBA', NULL, 'Adaptasi dari kisah Rangga dan Cinta. Sebuah kisah cinta yang penuh dengan konflik dan pengorbanan antara dua insan yang saling mencintai.', 'uploads/posters/rangga-cinta.jpg', '', 0.0, 0, NULL, '2025-11-16 11:50:59', '2025-11-16 16:07:41'),
(23, 'Rangga & Cinta', 'Rangga & Cinta', 2025, 120, 'Drama, Romantis', 'Unknown', NULL, 'Kisah cinta Rangga dan Cinta yang penuh drama', 'uploads/posters/rangga-cinta.jpg', NULL, 0.0, 0, 1, '2025-11-16 16:07:10', '2025-11-16 16:07:10'),
(24, 'Tukar Takdir', 'Tukar Takdir', 2025, 110, 'Drama', 'Unknown', NULL, 'Sebuah aplikasi yang bisa menukar nasib hidupmu', 'uploads/posters/tukar-takdir.jpg', NULL, 0.0, 0, 1, '2025-11-16 16:07:10', '2025-11-16 16:07:10'),
(25, 'Rest Area', 'Rest Area', 2025, 95, 'Horor', 'Unknown', NULL, 'Malam mencekam di rest area yang terisolasi', 'uploads/posters/rest-area.jpg', NULL, 0.0, 0, 1, '2025-11-16 16:07:10', '2025-11-16 16:07:10'),
(26, 'Dilan 1990', 'Dilan 1990', 2018, 110, 'Documentary, Drama', 'Fajar Bustomi', NULL, 'Kisah cinta legendaris di era 90-an', 'uploads/posters/dilan-1990.jpg', NULL, 0.0, 0, 1, '2018-01-24 17:00:00', '2025-11-16 16:07:10'),
(27, 'pengabdi', 'setan', 2025, 0, 'horor', 'aku dewe', NULL, 'hantuuuu', 'uploads/posters/1763309692_2..png', 'https://youtu.be/IZ72D_NKBNQ?si=d_NDZe2SHXm-cEi7', 5.0, 0, NULL, '2025-11-16 16:14:52', '2025-11-16 16:14:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL CHECK (`rating` >= 0 and `rating` <= 5),
  `review_text` text DEFAULT NULL,
  `user_name` varchar(100) DEFAULT 'Anonymous',
  `is_spoiler` tinyint(1) DEFAULT 0,
  `helpful_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `movie_id`, `user_id`, `rating`, `review_text`, `user_name`, `is_spoiler`, `helpful_count`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5.0, 'Film yang sangat bagus! Ceritanya menyentuh hati.', 'Anonymous', 0, 0, '2025-11-16 16:37:15', '2025-11-16 16:40:17'),
(7, 2, 8, 5.0, 'Ketegangan yang luar biasa! Joko Anwar tidak pernah mengecewakan.', 'Anonymous', 0, 0, '2025-11-16 16:38:25', '2025-11-16 16:38:25'),
(8, 2, 9, 4.0, 'Visual alam yang indah berpadu sempurna dengan adegan horor yang mencekam.', 'Anonymous', 0, 0, '2025-11-16 16:38:25', '2025-11-16 16:38:25'),
(9, 2, 10, 5.0, 'Akting Adipati dan Aghniny sangat meyakinkan. Wajib ditonton!', 'Anonymous', 0, 0, '2025-11-16 16:38:25', '2025-11-16 16:38:25'),
(10, 2, 11, 3.0, 'Terlalu banyak *jump scare* klise, tapi konsepnya menarik.', 'Anonymous', 0, 0, '2025-11-16 16:38:25', '2025-11-16 16:38:25'),
(11, 2, 12, 4.0, 'Sebuah film horor Indonesia yang berani dan menyegarkan.', 'Anonymous', 0, 0, '2025-11-16 16:38:26', '2025-11-16 16:38:26'),
(12, 5, 13, 5.0, 'Kisah fantasi yang mengharukan dan penuh pelajaran hidup.', 'Anonymous', 0, 0, '2025-11-16 16:38:26', '2025-11-16 16:38:26'),
(13, 5, 14, 4.0, 'Konsep penukaran takdirnya dieksekusi dengan baik, akting pemainnya top.', 'Anonymous', 0, 0, '2025-11-16 16:38:26', '2025-11-16 16:38:26'),
(14, 5, 10, 5.0, 'Jalan cerita yang unik, membuat saya merenung setelah menontonnya.', 'Anonymous', 0, 0, '2025-11-16 16:38:26', '2025-11-16 16:38:26'),
(15, 3, 10, 5.0, 'oba', 'Anonymous', 0, 0, '2025-11-16 17:49:22', '2025-11-16 17:49:22'),
(16, 1, 10, 5.0, 'coba', 'Anonymous', 0, 0, '2025-11-16 18:12:35', '2025-11-16 18:12:35'),
(26, 3, 16, 5.0, 'Test review dari test_review.html', 'Anonymous', 0, 0, '2025-11-16 21:05:51', '2025-11-16 21:05:51'),
(29, 3, 16, 5.0, 'Test review dari test_review.html', 'Anonymous', 0, 0, '2025-11-17 16:28:21', '2025-11-17 16:28:21'),
(30, 3, 16, 5.0, 'Test review dari test_review.html', 'Anonymous', 0, 0, '2025-11-17 20:28:06', '2025-11-17 20:28:06'),
(31, 3, 1, 5.0, '335', 'Anonymous', 0, 0, '2025-11-19 16:17:23', '2025-11-19 16:17:23'),
(32, 3, 1, 5.0, 'Test review dari test_connection.php', 'Anonymous', 0, 0, '2025-11-18 07:10:40', '2025-11-18 07:10:40'),
(33, 3, 1, 5.0, 'Test review dari test_connection.php', 'Anonymous', 0, 0, '2025-11-18 07:49:08', '2025-11-18 07:49:08'),
(34, 3, 17, 5.0, 'jj', 'Anonymous', 0, 0, '2025-11-18 08:10:59', '2025-11-18 08:10:59'),
(35, 3, 18, 5.0, ',,', 'Anonymous', 0, 0, '2025-11-18 12:38:08', '2025-11-18 12:38:08'),
(36, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:07:22', '2025-11-18 21:07:22'),
(37, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:07:33', '2025-11-18 21:07:33'),
(38, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:07:34', '2025-11-18 21:07:34'),
(39, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:13:49', '2025-11-18 21:13:49'),
(40, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:13:50', '2025-11-18 21:13:50'),
(41, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:13:58', '2025-11-18 21:13:58'),
(42, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:15:24', '2025-11-18 21:15:24'),
(43, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:15:25', '2025-11-18 21:15:25'),
(44, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:17:00', '2025-11-18 21:17:00'),
(45, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:18:45', '2025-11-18 21:18:45'),
(46, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-18 21:25:32', '2025-11-18 21:25:32'),
(47, 3, 16, 5.0, 'Film yang sangat bagus! Milea, kamu cantik.', 'Anonymous', 0, 0, '2025-11-18 21:45:50', '2025-11-18 21:45:50'),
(48, 3, 16, 5.0, 'Film yang sangat bagus! Milea, kamu cantik.', 'Anonymous', 0, 0, '2025-11-18 21:49:02', '2025-11-18 21:49:02'),
(49, 3, 16, 5.0, 'Film yang sangat bagus! Milea, kamu cantik.', 'Anonymous', 0, 0, '2025-11-18 21:49:10', '2025-11-18 21:49:10'),
(50, 3, 19, 5.0, 'Test review dari path detector', 'Anonymous', 0, 0, '2025-11-19 06:36:09', '2025-11-19 06:36:09'),
(51, 3, 2, 5.0, 'qq', 'Anonymous', 0, 0, '2025-11-19 06:37:54', '2025-11-19 06:37:54'),
(52, 3, 20, 5.0, 'll', 'Anonymous', 0, 0, '2025-11-19 06:44:15', '2025-11-19 06:44:15'),
(53, 3, 20, 5.0, ',,', 'Anonymous', 0, 0, '2025-11-19 06:44:25', '2025-11-19 06:44:25'),
(55, 3, 1, 5.0, ',,', 'Anonymous', 0, 0, '2025-11-19 16:25:18', '2025-11-19 16:25:18'),
(56, 3, 1, 5.0, 'rawrrr', 'Anonymous', 0, 0, '2025-11-19 16:25:37', '2025-11-19 16:25:37'),
(57, 3, 1, 5.0, 'jjjjjjjj', 'Anonymous', 0, 0, '2025-11-19 16:27:06', '2025-11-19 16:27:06'),
(58, 2, 1, 5.0, 'mm', 'Anonymous', 0, 0, '2025-11-20 03:25:49', '2025-11-20 03:25:49'),
(59, 3, 1, 5.0, 'rawr', 'Anonymous', 0, 0, '2025-11-20 15:15:06', '2025-11-20 15:15:06'),
(60, 2, 1, 5.0, 'rawr', 'Anonymous', 0, 0, '2025-11-20 15:15:32', '2025-11-20 15:15:32'),
(61, 2, 1, 5.0, 'w', 'Anonymous', 0, 0, '2025-11-20 15:25:09', '2025-11-20 15:25:09'),
(62, 3, 1, 5.0, 'ppp', 'Anonymous', 0, 0, '2025-11-20 15:56:28', '2025-11-20 15:56:28'),
(63, 2, 1, 5.0, 'q', 'Anonymous', 0, 0, '2025-11-20 16:06:40', '2025-11-20 16:06:40'),
(64, 3, 1, 5.0, 'Film yang sangat bagus! Sangat menghibur.', 'Administrator CineScope', 0, 0, '2025-11-20 16:27:18', '2025-11-20 16:27:18'),
(65, 3, 1, 5.0, 'mm', 'Administrator', 0, 0, '2025-11-20 16:27:58', '2025-11-20 16:27:58'),
(66, 3, 18, 5.0, 'Test review dari diagnostic tool - 2025-11-20 17:34:07', '.', 0, 0, '2025-11-20 16:34:07', '2025-11-20 16:34:07'),
(67, 3, 1, 5.0, 'aa', 'Administrator', 0, 0, '2025-11-20 16:35:11', '2025-11-20 16:35:11'),
(68, 3, 1, 5.0, 'rawr', 'Administrator', 0, 0, '2025-11-20 22:32:18', '2025-11-20 22:32:18'),
(69, 3, 1, 5.0, 'tes', 'Administrator', 0, 0, '2025-11-20 22:32:58', '2025-11-20 22:32:58'),
(70, 3, 1, 5.0, 'rawr', 'Administrator', 0, 0, '2025-11-20 23:54:18', '2025-11-20 23:54:18'),
(71, 1, 1, 5.0, 'woi', 'Anonymous', 0, 0, '2025-11-20 23:54:29', '2025-11-20 23:54:29'),
(72, 2, 1, 5.0, 'q', 'Anonymous', 0, 0, '2025-11-20 23:54:39', '2025-11-20 23:54:39'),
(73, 4, 1, 5.0, 'e', 'Anonymous', 0, 0, '2025-11-20 23:54:49', '2025-11-20 23:54:49'),
(74, 5, 1, 5.0, 'f', 'Anonymous', 0, 0, '2025-11-20 23:54:58', '2025-11-20 23:54:58'),
(75, 6, 1, 5.0, 'c', 'Anonymous', 0, 0, '2025-11-20 23:55:08', '2025-11-20 23:55:08'),
(77, 3, 33, 5.0, 'shwf,de/', 'Anonymous', 0, 0, '2025-11-22 19:11:47', '2025-11-22 19:11:47'),
(78, 6, 33, 5.0, 'aa', 'Anonymous', 0, 0, '2025-11-22 19:33:35', '2025-11-22 19:33:35'),
(79, 6, 33, 5.0, 'tes', 'Anonymous', 0, 0, '2025-11-22 19:33:41', '2025-11-22 19:33:41'),
(80, 6, 33, 5.0, 'coba', 'Anonymous', 0, 0, '2025-11-22 19:33:46', '2025-11-22 19:33:46'),
(81, 6, 33, 5.0, 'rawr', 'Anonymous', 0, 0, '2025-11-22 19:33:51', '2025-11-22 19:33:51'),
(82, 6, 33, 5.0, 'eror ga', 'Anonymous', 0, 0, '2025-11-22 19:33:57', '2025-11-22 19:33:57'),
(83, 4, 32, 5.0, 'w', 'Anonymous', 0, 0, '2025-11-23 15:13:47', '2025-11-23 15:13:47'),
(84, 4, 32, 5.0, 'w', 'Anonymous', 0, 0, '2025-11-23 15:14:18', '2025-11-23 15:14:18'),
(85, 1, 32, 5.0, 'rawr lagi', 'Anonymous', 0, 0, '2025-11-24 16:24:34', '2025-11-24 16:24:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews_backup`
--

CREATE TABLE `reviews_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `movie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL CHECK (`rating` >= 0 and `rating` <= 10),
  `review_text` text DEFAULT NULL,
  `is_spoiler` tinyint(1) DEFAULT 0,
  `helpful_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reviews_backup`
--

INSERT INTO `reviews_backup` (`id`, `movie_id`, `user_id`, `rating`, `review_text`, `is_spoiler`, `helpful_count`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 5.0, 'Ketegangan yang luar biasa! Joko Anwar tidak pernah mengecewakan.', 1, 0, '2025-11-16 12:02:30', '2025-11-16 12:02:30'),
(7, 2, 8, 5.0, 'Ketegangan yang luar biasa! Joko Anwar tidak pernah mengecewakan.', 0, 0, '2025-11-16 12:11:23', '2025-11-16 12:36:05'),
(8, 2, 9, 4.0, 'Visual alam yang indah berpadu sempurna dengan adegan horor yang mencekam.', 0, 0, '2025-11-16 12:11:24', '2025-11-16 12:36:05'),
(9, 2, 10, 5.0, 'Akting Adipati dan Aghniny sangat meyakinkan. Wajib ditonton!', 0, 0, '2025-11-16 12:11:24', '2025-11-16 12:36:05'),
(10, 2, 11, 3.0, 'Terlalu banyak *jump scare* klise, tapi konsepnya menarik.', 0, 0, '2025-11-16 12:11:24', '2025-11-16 12:36:05'),
(11, 2, 12, 4.0, 'Sebuah film horor Indonesia yang berani dan menyegarkan.', 0, 0, '2025-11-16 12:11:24', '2025-11-16 12:36:05'),
(13, 5, 14, 4.0, 'Konsep penukaran takdirnya dieksekusi dengan baik, akting pemainnya top.', 0, 0, '2025-11-16 12:11:25', '2025-11-16 12:36:05'),
(14, 5, 10, 5.0, 'Jalan cerita yang unik, membuat saya merenung setelah menontonnya.', 0, 0, '2025-11-16 12:11:25', '2025-11-16 12:36:05'),
(15, 1, 10, 5.0, 'rawr', 0, 0, '2025-11-16 13:17:38', '2025-11-16 13:17:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `review_helpful`
--

CREATE TABLE `review_helpful` (
  `id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `token`, `expires_at`, `created_at`) VALUES
(1, 1, 'ab693560f5b9242a07ce16a64252c97a6fadbae102a3c39eb6bf40c6bf064512', '2025-12-13 19:02:53', '2025-11-13 18:02:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `profile_picture`, `bio`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@moviereview.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', NULL, NULL, 'admin', '2025-11-13 16:21:35', '2025-11-13 16:21:35'),
(2, 'Anonymous', 'Anonymous@guest.com', '$2y$10$yionfJStg/MDCTYhI5dX8uEPCq3rj3oarbVVtEHmGUJYnkmZZhHGq', 'Anonymous', NULL, NULL, 'user', '2025-11-16 12:02:30', '2025-11-16 12:02:30'),
(8, 'HorrorFanatic', 'horrorfanatic@guest.com', '$2y$10$zURx6RKkiWBHpeRYG8iWhO7ywDu6x1AKZrbZw/Q2lqpdua3M95xQa', 'HorrorFanatic', NULL, NULL, 'user', '2025-11-16 12:11:23', '2025-11-16 12:11:23'),
(9, 'PendakiGede', 'pendakigede@guest.com', '$2y$10$uMNr2cJ/JFsfoRPKXK/iE.Yp8nUkxq2L4hPgstTV5U2RB17j.EXDm', 'PendakiGede', NULL, NULL, 'user', '2025-11-16 12:11:24', '2025-11-16 12:11:24'),
(10, 'Pengguna CineScope Baru', 'penggunacinescopebaru@guest.com', '$2y$10$TYFX2mog9AbMq8BSpP8Nj..xHGicXyVlP5JHA/bUp/1P2vhj8GyNa', 'Pengguna CineScope Baru', NULL, NULL, 'user', '2025-11-16 12:11:24', '2025-11-16 12:11:24'),
(11, 'KritikusFilm', 'kritikusfilm@guest.com', '$2y$10$5T5aebLVfS9DmPvdqg2tI.U4.a7ioCFoaAte9m3JupzYHLIaRZhlW', 'KritikusFilm', NULL, NULL, 'user', '2025-11-16 12:11:24', '2025-11-16 12:11:24'),
(12, 'PenggunaLama', 'penggunalama@guest.com', '$2y$10$ElopIAM5Qgw5lXbPvEMpkefwYhuEaRx087JhD12oRqoz2YxWiqiTK', 'PenggunaLama', NULL, NULL, 'user', '2025-11-16 12:11:24', '2025-11-16 12:11:24'),
(13, 'Pecinta Drama', 'pecintadrama@guest.com', '$2y$10$WR/TScRXINoeJHADQ68Beu0ADfrg81kxfD5JL82UXCBOwXLeshIJm', 'Pecinta Drama', NULL, NULL, 'user', '2025-11-16 12:11:25', '2025-11-16 12:11:25'),
(14, 'Pengulas Cine', 'pengulascine@guest.com', '$2y$10$hfD6QlM0pCyszcYH1hk72.J5shOOBx4VtL9Az5tKT8pOGhBmryCRa', 'Pengulas Cine', NULL, NULL, 'user', '2025-11-16 12:11:25', '2025-11-16 12:11:25'),
(16, 'Test User', 'test_user@cinescope.com', '', 'Test User', NULL, NULL, 'user', '2025-11-16 21:05:51', '2025-11-16 21:05:51'),
(17, 'l', 'l@user.local', '', 'l', NULL, NULL, 'user', '2025-11-18 08:10:59', '2025-11-18 08:10:59'),
(18, '.', '.@user.local', '', '.', NULL, NULL, 'user', '2025-11-18 12:38:08', '2025-11-18 12:38:08'),
(19, 'Path Tester', 'path_tester@user.local', '', 'Path Tester', NULL, NULL, 'user', '2025-11-18 21:07:22', '2025-11-18 21:07:22'),
(20, 'Guest User', 'guest_user@cinescope.local', '', 'Guest User', NULL, NULL, 'user', '2025-11-19 06:44:15', '2025-11-19 06:44:15'),
(21, 'cc', 'cc@cinescope.local', '', 'cc', NULL, NULL, 'user', '2025-11-19 06:46:08', '2025-11-19 06:46:08'),
(26, 'ga', 'gagaga@gmail.com', '$2y$10$8jzpDaLamMacf7E0pzzaTOU20rxC7UHBjYnmtGmA2MTKkRY0RUYCu', NULL, NULL, NULL, 'user', '2025-11-22 15:23:33', '2025-11-22 15:23:33'),
(27, 'perrrr', 'abc@gmail.com', '$2y$10$QO1kfMPjRN7Hj3y.KDPrxOR4Mt7f0ne7C0PXgdtybjvUQfhD4Wqzq', NULL, NULL, NULL, 'user', '2025-11-22 15:38:23', '2025-11-22 15:38:23'),
(32, 'Fernando  Kinansyah', 'ggg@gmail.com', '$2y$10$C46mIIznVoTrCtoSnpg6LOmiblGkU/qg1A2t119iAes.lQxdN2GM.', NULL, NULL, NULL, 'user', '2025-11-22 15:50:31', '2025-11-22 15:50:31'),
(33, 'BAGOL', 'BAGOL@GMAIL.COM', '$2y$10$43HYcEfPpwf6r79IV.h/../3DEd3E9..C6X0Z/QE3LQ4QovP.ZROC', NULL, NULL, NULL, 'user', '2025-11-22 19:10:45', '2025-11-22 19:10:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `watchlist`
--

CREATE TABLE `watchlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_title` (`title`),
  ADD KEY `idx_genre` (`genre`),
  ADD KEY `idx_year` (`release_year`),
  ADD KEY `idx_movie_title` (`title`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_movie` (`movie_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_rating` (`rating`),
  ADD KEY `idx_review_movie` (`movie_id`),
  ADD KEY `idx_review_created` (`created_at`);

--
-- Indeks untuk tabel `review_helpful`
--
ALTER TABLE `review_helpful`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_review` (`user_id`,`review_id`),
  ADD KEY `review_id` (`review_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_movie` (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT untuk tabel `review_helpful`
--
ALTER TABLE `review_helpful`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `review_helpful`
--
ALTER TABLE `review_helpful`
  ADD CONSTRAINT `review_helpful_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_helpful_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
