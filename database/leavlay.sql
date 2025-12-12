-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Des 2025 pada 05.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leavlay`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'pantai'),
(2, 'gunung'),
(3, 'sejarah'),
(4, 'budaya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id_rating` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `nilai_rating` int(1) NOT NULL CHECK (`nilai_rating` between 1 and 5),
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`id_rating`, `id_user`, `id_wisata`, `nilai_rating`, `tanggal`) VALUES
(1, 19, 14, 4, '2025-11-19 02:10:14'),
(2, 19, 13, 5, '2025-11-19 03:54:54'),
(3, 18, 14, 4, '2025-11-17 04:39:28'),
(5, 18, 1, 4, '2025-11-17 04:46:02'),
(6, 18, 2, 4, '2025-11-17 04:46:04'),
(7, 18, 3, 5, '2025-11-17 04:46:06'),
(8, 18, 7, 5, '2025-11-17 04:46:11'),
(9, 18, 5, 5, '2025-11-17 04:46:13'),
(10, 18, 4, 5, '2025-11-17 04:46:15'),
(11, 18, 8, 5, '2025-11-17 04:46:18'),
(12, 18, 9, 4, '2025-11-17 04:46:20'),
(13, 18, 10, 5, '2025-11-17 04:46:22'),
(14, 18, 12, 4, '2025-11-17 04:46:26'),
(15, 18, 6, 4, '2025-11-17 04:53:12'),
(16, 18, 13, 4, '2025-11-17 04:53:19'),
(17, 18, 11, 4, '2025-11-17 04:55:56'),
(19, 19, 4, 3, '2025-11-19 04:46:44'),
(20, 19, 5, 3, '2025-11-19 04:46:51'),
(21, 17, 14, 4, '2025-11-19 05:36:55'),
(22, 17, 13, 4, '2025-11-19 05:37:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `nama_lengkap` varchar(200) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `role`, `nama_lengkap`, `email`, `password`, `foto`) VALUES
(17, 'afrilia', 'admin', 'afrilia', 'afrilia@gmail.com', '4224bb5d8f506267f1d06945fffdd629', 'admin.jpg'),
(18, 'fatih', 'user', 'fatih', 'fatih@gmail.com', 'b4b643cb1547b52057fdd15336581ca8', 'user2.jpg'),
(19, 'ayu', 'user', 'Putri Ayu', 'putriayu@gmail.com', '29c65f781a1068a41f735e1b092546de', 'user3.jpg'),
(20, 'rifka', 'user', 'rifka', 'rifka@gmail.com', '7642cc8b570d5aa995acfb1a14267499', 'rifka.jpg'),
(21, 'udin', 'user', 'udin', 'udin@gmail.com', '6bec9c852847242e384a4d5ac0962ba0', 'user5.jpg'),
(23, 'loafjr', 'admin', 'loa', 'loaf@gmail.com', 'c602c949788bd3e2a6a9e6f509b6adf6', ''),
(24, 'afi', 'user', 'afi', 'afi@gmail.com', 'fc2f6178abeec3a91654adc3f22419fd', ''),
(29, 'fatih1', 'user', 'kanjeng fatih', 'fatihsan@gmail.com', 'b4b643cb1547b52057fdd15336581ca8', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata`
--

CREATE TABLE `wisata` (
  `id_wisata` int(11) NOT NULL,
  `nama_wisata` varchar(100) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `gambar` varchar(2555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wisata`
--

INSERT INTO `wisata` (`id_wisata`, `nama_wisata`, `deskripsi`, `lokasi`, `id_kategori`, `gambar`) VALUES
(1, 'Pantai Air Manis', 'Pantai Carocok berjarak ±78km dari kota Padang atau dibutuhkan waktu sekitar dua jam perjalanan darat menggunakan kendaraan bermotor. Selama perjalanan kita disuguhi dengan pemandangan tebing gunung dan jurang lautan dengan jalan berkelok-kelok.  Sedangkan dari pusat kota Painan, Pantai Carocok berjarak ±1km.,ibu kota kabupaten pesisir selatan..\r\n\r\nDipantai Carocok banyak sekali tempat wisata yang menarik yang tidak bisa pengunjung kunjungi dalam waktu semalam, mulai dari wisata alam yang menarik, atraksi laut, ,kuliner,, bahkan dilengkapi dengan tempat bersejarah.', 'Padang', 1, 'pantaimanis.png'),
(2, 'Pantai Carocok', 'Pantai Carocok berjarak ±78km dari kota Padang atau dibutuhkan waktu sekitar dua jam perjalanan darat menggunakan kendaraan bermotor. Selama perjalanan kita disuguhi dengan pemandangan tebing gunung dan jurang lautan dengan jalan berkelok-kelok.  Sedangkan dari pusat kota Painan, Pantai Carocok berjarak ±1km.,ibu kota kabupaten pesisir selatan..\r\n\r\nDipantai Carocok banyak sekali tempat wisata yang menarik yang tidak bisa pengunjung kunjungi dalam waktu semalam, mulai dari wisata alam yang menarik, atraksi laut, ,kuliner,, bahkan dilengkapi dengan tempat bersejarah.', 'Painan, Pesisir Selatan', 1, 'pantairocok.png'),
(3, 'Pantai Gandoriah', 'Pantai dekat pusat Kota Pariaman dengan pemandangan sunset yang indah.', 'Pariaman', 1, 'pantaigorin.png'),
(4, 'Pantai Padang', 'Pantai kota yang ramai dikunjungi wisatawan lokal dengan banyak kafe di tepi laut.', 'Padang', 1, 'pantai_padang.jpg'),
(5, 'Gunung Marapi', 'Gunung berapi aktif yang menjadi favorit pendaki karena pemandangan yang menawan.', 'Agam & Tanah Datar', 2, 'gunungmarapi.jpg'),
(6, 'Gunung Singgalang', 'Gunung dengan suasana hutan tropis dan danau kecil di puncaknya.', 'Bukittinggi', 2, 'gunungsinggalang.png'),
(7, 'Gunung Talang', 'Gunung di Solok yang terkenal dengan dua danau di kakinya, Danau Diatas dan Danau Dibawah.', 'Solok', 2, 'gunungtalang.png'),
(8, 'Jam Gadang', 'Ikon kota Bukittinggi dengan sejarah sejak masa penjajahan Belanda.', 'Bukittinggi', 3, 'jamgadang.png'),
(9, 'Istana Pagaruyung', 'Istana megah kebanggaan masyarakat Minangkabau yang menjadi pusat sejarah kerajaan.', 'Batusangkar', 3, 'istanapaga.png'),
(10, 'Benteng Fort de Kock', 'Benteng peninggalan kolonial Belanda yang kini menjadi destinasi edukatif.', 'Bukittinggi', 3, 'benteng.png'),
(11, 'Lobang Jepang', 'Terowongan bawah tanah peninggalan Jepang pada masa Perang Dunia II.', 'Bukittinggi', 3, 'lobang_jepang.jpg'),
(12, 'Nagari Pariangan', 'Desa adat tertua di Minangkabau yang masih menjaga tradisi leluhur.', 'Tanah Datar', 4, 'nagari_pariangan.jpg'),
(13, 'Festival Tabuik', 'Perayaan tradisional masyarakat Pariaman untuk memperingati Asyura.', 'Pariaman', 4, 'festival_tabuik.jpg'),
(14, 'Desa Adat Balimbing', 'Desa yang mempertahankan arsitektur rumah gadang khas Minangkabau.', 'Tanah Datar', 4, 'desa_balimbing.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata_favorit`
--

CREATE TABLE `wisata_favorit` (
  `id_favorit` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `tanggal_favorit` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wisata_favorit`
--

INSERT INTO `wisata_favorit` (`id_favorit`, `id_user`, `id_wisata`, `tanggal_favorit`) VALUES
(1, 18, 14, '2025-11-17 05:02:52'),
(3, 19, 12, '2025-11-19 02:10:23'),
(6, 19, 1, '2025-11-19 05:19:18'),
(7, 19, 2, '2025-11-19 05:19:24'),
(8, 19, 14, '2025-11-19 05:20:01'),
(9, 17, 5, '2025-11-19 05:33:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisata_rating`
--

CREATE TABLE `wisata_rating` (
  `id_rating` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `nilai_rating` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wisata_rating`
--

INSERT INTO `wisata_rating` (`id_rating`, `id_user`, `id_wisata`, `nilai_rating`, `tanggal`, `id_kategori`) VALUES
(1, 18, 5, 4, '2025-11-13 05:37:02', NULL),
(2, 18, 6, 5, '2025-11-13 05:37:11', NULL),
(3, 19, 9, 5, '2025-11-17 03:15:08', NULL),
(4, 19, 13, 5, '2025-11-17 03:36:50', NULL),
(5, 19, 10, 4, '2025-11-17 04:04:47', NULL),
(6, 19, 1, 5, '2025-11-17 04:10:54', NULL),
(7, 19, 15, 5, '2025-11-17 04:18:33', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_wisata` (`id_wisata`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `wisata`
--
ALTER TABLE `wisata`
  ADD PRIMARY KEY (`id_wisata`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `wisata_favorit`
--
ALTER TABLE `wisata_favorit`
  ADD PRIMARY KEY (`id_favorit`),
  ADD KEY `fk_favorit_user` (`id_user`),
  ADD KEY `fk_favorit_wisata` (`id_wisata`);

--
-- Indeks untuk tabel `wisata_rating`
--
ALTER TABLE `wisata_rating`
  ADD PRIMARY KEY (`id_rating`),
  ADD UNIQUE KEY `unique_user_wisata` (`id_user`,`id_wisata`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `wisata`
--
ALTER TABLE `wisata`
  MODIFY `id_wisata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `wisata_favorit`
--
ALTER TABLE `wisata_favorit`
  MODIFY `id_favorit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `wisata_rating`
--
ALTER TABLE `wisata_rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wisata`
--
ALTER TABLE `wisata`
  ADD CONSTRAINT `wisata_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `wisata_favorit`
--
ALTER TABLE `wisata_favorit`
  ADD CONSTRAINT `fk_favorit_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_favorit_wisata` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wisata_rating`
--
ALTER TABLE `wisata_rating`
  ADD CONSTRAINT `wisata_rating_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
