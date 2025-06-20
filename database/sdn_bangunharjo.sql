-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 10:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdn_bangunharjo`
--

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `public_id` varchar(255) DEFAULT NULL COMMENT 'Menyimpan path file lokal, bukan Cloudinary public_id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `image_url`, `public_id`, `created_at`, `updated_at`) VALUES
(1, 'Tari', 'images/tari.png', NULL, '2025-06-17 09:30:40', '2025-06-17 09:30:40'),
(2, 'Jalan', 'images/grakjalan.png', NULL, '2025-06-17 09:31:53', '2025-06-17 09:31:54'),
(3, 'Pramuka1', 'images/pramuka1.png', NULL, '2025-06-17 09:32:14', '2025-06-17 09:32:15'),
(4, 'Olahraga', 'images/olahraga.png', NULL, '2025-06-17 09:32:33', '2025-06-17 09:32:34'),
(5, 'Pramuka2', 'images/pramuka2.png', NULL, '2025-06-17 09:32:53', '2025-06-17 09:32:54'),
(6, 'Karawitan', 'images/karawitan.png', NULL, '2025-06-17 09:33:28', '2025-06-17 09:33:29'),
(7, 'Karawitan2', 'images/karawitan2.png', NULL, '2025-06-17 09:35:33', '2025-06-17 09:35:34'),
(8, 'Fotosd3', 'images/fotosd3.png', NULL, '2025-06-17 09:35:35', '2025-06-17 09:35:34'),
(9, 'Karate', 'images/karate.png', NULL, '2025-06-17 09:35:36', '2025-06-17 09:35:36'),
(10, 'Ziarah', 'images/ziarah.png', NULL, '2025-06-17 09:35:37', '2025-06-17 09:35:37');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2023_06_10_000000_create_galleries_table', 1),
(4, '2023_07_15_000000_create_news_table', 1),
(5, '2023_08_01_000000_create_teachers_table', 1),
(6, '2025_06_16_212153_modify_gallery_table_for_local_storage', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `public_id` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image_url`, `public_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Perayaan HUT dan Peringatan Hari Sumpah Pemuda', 'Bangunharjo, 28 Oktober 2024 — SD Negeri Bangunharjo menggelar upacara bendera dalam rangka memperingati Hari Sumpah Pemuda ke-96. Upacara berlangsung dengan khidmat di halaman sekolah, diikuti oleh seluruh siswa, guru, dan staf sekolah.', 'images/upc2.png', NULL, 'published', '2025-06-17 08:56:37', '2025-06-17 08:56:38'),
(2, 'SDN Bangunharjo Raih Juara 2 Lomba Gerak Jalan Tingkat SD se-Kota Semarang', 'Semarang, 12 Agustus 2024 — SD Negeri Bangunharjo kembali menorehkan prestasi membanggakan. Dalam ajang Lomba Gerak Jalan Tingkat Sekolah Dasar se-Kota Semarang yang digelar dalam rangka memperingati Hari Kemerdekaan Republik Indonesia ke-79, tim gerak jalan SDN Bangunharjo berhasil meraih Juara 2.', 'http://127.0.0.1:8000/storage/news/1750138522_sdn-bangunharjo-raih-juara-2-lomba-gerak-jalan-tingkat-sd-se-kota-semarang.jpg', 'news/1750138522_sdn-bangunharjo-raih-juara-2-lomba-gerak-jalan-tingkat-sd-se-kota-semarang.jpg', 'published', '2025-06-17 09:19:13', '2025-06-16 22:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `photo`, `created_at`, `updated_at`) VALUES
(2, 'Marsianta, S.Pd', '../images/kepalasekolah.jpeg', '2025-06-17 08:46:58', '2025-06-17 08:47:00'),
(6, 'Putri Adibah', 'teachers/1750138650_putri-adibah.jpg', '2025-06-16 22:37:30', '2025-06-16 22:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
