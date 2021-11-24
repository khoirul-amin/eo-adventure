-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 24, 2021 at 06:57 AM
-- Server version: 8.0.26
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` int NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `telpon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `role`, `last_login`, `avatar`, `telpon`) VALUES
(1, 'admin', 'admin@gmail.com', '$2a$12$I7XSod1b/jNTLsEp.KgVX.KFqhw4Zhm97ayMSo4wlYfjBM1X3deCC', 1, '2021-11-22 16:54:22', 'http://localhost:8000/avatar/avatar-779619139568cf06.jpg', '085967176070'),
(2, 'Khoirul Amin', 'misbahmis529@gmail.com', '$2y$10$06VFgze7vm2I8rLTXeD5S.VlczzX6jNzO11t/ax7AiX250x9Y20Xe', 2, NULL, 'http://localhost:8000/avatar/avatar-9386191397d07605.jpg', '085967176079');

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` int NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `event_id` int NOT NULL,
  `destinasi_id` int NOT NULL,
  `waktu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `keterangan`, `event_id`, `destinasi_id`, `waktu`) VALUES
(1, '- Makan nasi sepuasnya terserah anda. \n- Jam berikutnya enak enak.', 1, 4, 'Hari Pertama\r\n'),
(2, 'Senam pagi dilapangan bersama tim senam.', 1, 4, 'Hari Kedua'),
(3, '- Pulang', 1, 4, 'Hari Ketiga'),
(5, '- asfsbdfsfdosdf\r\n- asfsggsdgsdg', 2, 4, 'Hari Pertama'),
(6, '- fsdggfdfgdfgdg\r\n- sdsdgsdgsdg', 2, 4, 'Hari Kedua'),
(9, 'Eksplore Sumba Barat : • Weekuri Lagoon • Pantai Mandorak • Desa Adat Prai Ijing • Air Terjun Lapopu', 2, 4, 'Hari Kedua <br> Jam : 08:00 - 15:00');

-- --------------------------------------------------------

--
-- Table structure for table `destinasi`
--

CREATE TABLE `destinasi` (
  `id` int NOT NULL,
  `kode_destinasi` varchar(50) DEFAULT NULL,
  `nama_tujuan` varchar(255) NOT NULL,
  `provinsi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi_lokasi` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `destinasi`
--

INSERT INTO `destinasi` (`id`, `kode_destinasi`, `nama_tujuan`, `provinsi`, `deskripsi_lokasi`) VALUES
(4, 'DEST01', 'Kawah Ijen', 'Jawa Timurr', 'Gunung Ijen adalah sebuah gunung berapi yang terletak di perbatasan Kabupaten Banyuwangi dan Kabupaten Bondowoso, Jawa Timur, Indonesia. Gunung ini memiliki ketinggian 2.386 mdpl dan terletak berdampingan dengan Gunung Merapi. Gunung Ijen terakhir meletus pada tahun 1999. Salah satu fenomena alam yang paling terkenal dari Gunung Ijen adalah blue fire (api biru) di dalam kawah yang terletak di puncak gunung tersebut.');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int NOT NULL,
  `kode_event` varchar(10) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `biaya` int NOT NULL,
  `kuota` int DEFAULT NULL,
  `transportasi_id` int NOT NULL,
  `kategori_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `kode_event`, `judul`, `biaya`, `kuota`, `transportasi_id`, `kategori_id`) VALUES
(1, 'EVNT01', 'Open Trip Menjangan Ijen Baluran 2H1M', 900000, 10, 5, 2),
(2, 'EVNT02', 'Lorem Ipsum Dolor', 420000, 15, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `type`, `images`, `deskripsi`) VALUES
(5, 'DEST01', '/images/DEST01images1.png', 'images1'),
(6, 'DEST01', '/images/DEST01images2.png', 'images2'),
(7, 'DEST01', '/images/DEST01images3.jpg', 'images3'),
(8, 'DEST01', '/images/DEST01images4.jpg', 'images4'),
(13, 'TRANS01', '/images/TRANS01images1.jpg', 'images1'),
(14, 'TRANS01', '/images/TRANS01images2.jpg', 'images2'),
(15, 'TRANS01', '/images/TRANS01images3.jpg', 'images3'),
(16, 'TRANS01', '/images/TRANS01images4.png', 'images4'),
(17, 'EVNT02', '/images/EVNT02images1.jpg', 'images1'),
(18, 'EVNT02', '/images/EVNT02images2.png', 'images2'),
(19, 'EVNT02', '/images/EVNT02images3.png', 'images3'),
(20, 'EVNT02', '/images/EVNT02images4.jpg', 'images4'),
(25, 'EVNT01', '/images/EVNT01images1.png', 'images1'),
(26, 'EVNT01', '/images/EVNT01images2.png', 'images2'),
(27, 'EVNT01', '/images/EVNT01images3.jpg', 'images3'),
(28, 'EVNT01', '/images/EVNT01images4.jpg', 'images4');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_event`
--

CREATE TABLE `kategori_event` (
  `id` int NOT NULL,
  `kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_event`
--

INSERT INTO `kategori_event` (`id`, `kategori`) VALUES
(1, '3 Hari 2 Malam'),
(2, '2 Hari 1 Malam');

-- --------------------------------------------------------

--
-- Table structure for table `keterangan`
--

CREATE TABLE `keterangan` (
  `id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `judul_keterangan` varchar(100) DEFAULT NULL,
  `keterangan` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `keterangan`
--

INSERT INTO `keterangan` (`id`, `event_id`, `judul_keterangan`, `keterangan`) VALUES
(1, 2, 'Deskripsi', 'Paket wisata Menjangan Baluran Ijen merupakan wisata murah ala backpacker dengan konsep open trip Menjangan Baluran Ijen, dimana wisata ini digabung dengan peserta lain jika minimal quota keberangkatan Anda hanya kurang dari 10 orang. Mengapa di gabung? Ini beralasan untuk meminimalisir budget untuk memenuhi semua fasilitas di paket wisata Menjangan Baluran Ijen. Paket ini sangat cocok sekali bagi Anda yang berjiwa traveling backpacker dan mempunyai kuota peserta kurang dari sepuluh orang untuk mengikuti paket wisata Menjangan Baluran Ijen.'),
(2, 2, 'Fasilitas', 'Transportasi AC (Innova, Hiace, Elf) + BBM dan Driver.'),
(3, 2, 'Fasilitas', 'Penginapan AC.'),
(4, 2, 'Fasilitas', 'Kapal wisata.'),
(5, 2, 'Fasilitas', 'Makan 5 kali (2B, 2L, 1D).'),
(6, 2, 'Fasilitas', 'Guide local.'),
(7, 2, 'Tidak Termasuk', 'Tipping crew.'),
(8, 2, 'Tidak Termasuk', 'Pengeluaran pribadi.'),
(9, 2, 'Tidak Termasuk', 'Makan di luar program.'),
(10, 2, 'Tidak Termasuk', 'Sewa sepatu katak Rp 25.000/set.');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `paket` varchar(100) DEFAULT NULL,
  `harga` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id`, `event_id`, `paket`, `harga`) VALUES
(1, 1, '1 Orang', 100000),
(2, 1, '1 Orang', 100000),
(6, 1, '4 Orang', 100000),
(9, 2, '1 Orang', 420000),
(10, 2, '2 Orang', 450000),
(11, 2, '3 Orang', 500000),
(12, 2, '4 Orang', 550000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `dadeline_pembayaran` datetime NOT NULL,
  `status_transaksi` int NOT NULL DEFAULT '3' COMMENT '1 Disetujui, 2 Ditolak, 3 Menunggu',
  `keterangan` varchar(255) DEFAULT NULL,
  `admin_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transportasi`
--

CREATE TABLE `transportasi` (
  `id` int NOT NULL,
  `kode_transportasi` varchar(50) DEFAULT NULL,
  `transportasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `muatan` int DEFAULT NULL,
  `keterangan` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transportasi`
--

INSERT INTO `transportasi` (`id`, `kode_transportasi`, `transportasi`, `muatan`, `keterangan`) VALUES
(5, 'TRANS01', 'Elf Long', 20, 'Memperingati Kemerdekaan Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telpon` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `telpon`, `email`, `password`, `avatar`, `last_login`, `alamat`, `token`) VALUES
(1, 'coba', '085646534167', 'mail@mail.com', '$2y$10$Avf8SpkSrwb.NDn6zPv0Au6rJutfijjHAUhK5MSiXH6yNIlHclq8u', NULL, '2021-11-15 00:25:30', 'sdjhfjsvdfsdfsbdhfkksdbfksbdf', 'sgerh4w5hgdfvagf'),
(3, 'Amin', '085967176079', 'amin@gmail.com', '$2y$10$wi22Z49FtlBMC2N3n1tgyOf.a/pmyvqDRstLuemQCxIY1yMHZ81am', 'http://localhost:8000/avatar/avatar-72961917f935b395.jpg', '2021-11-18 17:20:58', 'Tebluru', '$2y$10$2lO5SinsAaZa2pM51ozJ2ew4TO.BheB1ehv/HF8/jK6evISEFcvlG'),
(4, 'asd', NULL, 'amin1@gmail.com', '$2y$10$6ypw6dQapS0sHa2qM5lPB.15rVHFD.F05nrHbAuJkJsHSYBAXxqMC', NULL, '2021-11-18 15:19:36', '', NULL),
(5, 'Khoirul Amin', NULL, 'khoirulamin@gmail.com', '$2y$10$jeCaFawpXARQ9F0PYsINl.SVXogBRaKbFruMp5boJXtRi0hnnIXWG', NULL, NULL, '', NULL),
(6, 'Amin', NULL, 'amin2@gmail.com', '$2y$10$d9QLDyRla9JR3jl/CvpILumRyH202rdnDFSkZSTUZcHXiEexXDmM6', NULL, '2021-11-18 18:05:53', '', '$2y$10$g9LOPMQtFYod0U7CazUB1uiKrwzs924./JjLEEtbwsu/en66gAUeK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `destinasi`
--
ALTER TABLE `destinasi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_event`
--
ALTER TABLE `kategori_event`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `keterangan`
--
ALTER TABLE `keterangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `transportasi`
--
ALTER TABLE `transportasi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `destinasi`
--
ALTER TABLE `destinasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `kategori_event`
--
ALTER TABLE `kategori_event`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `keterangan`
--
ALTER TABLE `keterangan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transportasi`
--
ALTER TABLE `transportasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
