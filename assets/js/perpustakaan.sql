-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Des 2025 pada 08.09
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `penulis`, `penerbit`, `tahun`, `stok`, `deskripsi`, `cover`) VALUES
(1, 'Pemrograman Web PHP', 'Budi Santoso', 'Informatika', 2022, 12, 'Buku dasar pemrograman web menggunakan PHP dan MySQL.', 'php.jpg'),
(2, 'Basis Data MySQL', 'Andi Wijaya', 'Elex Media', 2021, 8, 'Pembahasan lengkap perancangan dan implementasi database MySQL.', 'mysql.jpg'),
(3, 'Algoritma & Struktur Data', 'Rina Kusuma', 'Gramedia', 2020, 5, 'Konsep algoritma, struktur data, dan contoh implementasi.', 'algoritma.jpg'),
(4, 'Pemrograman Java', 'Dewi Lestari', 'Andi Publisher', 2019, 0, 'Panduan pemrograman Java dari dasar sampai lanjut.', 'java.jpg'),
(5, 'Jaringan Komputer', 'Ahmad Fauzi', 'Deepublish', 2023, 10, 'Dasar-dasar jaringan komputer dan implementasinya.', 'jaringan.jpg'),
(6, 'Sistem Informasi', 'Siti Aminah', 'Salemba', 2021, 7, 'Konsep sistem informasi dan penerapannya di organisasi.', 'si.jpg'),
(7, 'Rekayasa Perangkat Lunak', 'Hendra Pratama', 'Informatika', 2022, 4, 'Metodologi pengembangan perangkat lunak modern.', 'rpl.jpg'),
(8, 'Keamanan Sistem Informasi', 'Rudi Hartono', 'Erlangga', 2020, 6, 'Pembahasan keamanan data dan sistem informasi.', 'keamanan.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ebook`
--

CREATE TABLE `ebook` (
  `id_ebook` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `tahun` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file` varchar(150) DEFAULT NULL,
  `cover` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ebook`
--

INSERT INTO `ebook` (`id_ebook`, `judul`, `penulis`, `tahun`, `deskripsi`, `file`, `cover`, `created_at`) VALUES
(1, 'Dasar Pemrograman PHP', 'Budi Santoso', 2022, 'E-Book pembelajaran PHP untuk pemula.', 'php.pdf', 'php.jpg', '2025-12-22 12:32:32'),
(2, 'Basis Data MySQL', 'Andi Wijaya', 2021, 'Panduan database MySQL lengkap.', 'mysql.pdf', 'mysql.jpg', '2025-12-22 12:32:32'),
(3, 'Rekayasa Perangkat Lunak', 'Hendra Pratama', 2022, 'Konsep dan metode RPL modern.', 'rpl.pdf', 'rpl.jpg', '2025-12-22 12:32:32'),
(4, 'Keamanan Sistem Informasi', 'Rudi Hartono', 2020, 'Pembahasan keamanan data & sistem.', 'keamanan.pdf', 'keamanan.jpg', '2025-12-22 12:32:32'),
(5, 'Algoritma dan Struktur Data', 'afrel', 2005, 'penjelasan mengenai data', '69495a5fad393_A.1. IMPLEMENTASI PENERAPAN SPIP.pdf', '69495a5fb1287_default.jpg', '2025-12-22 14:49:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`id`, `judul`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `status`, `created_at`) VALUES
(1, 'Pekan Literasi Digital', 'Diskon denda & baca e-book gratis selama acara berlangsung.', '2025-01-01', '2025-01-31', 'aktif', '2025-12-21 20:13:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL,
  `nama_peminjam` varchar(100) NOT NULL,
  `judul_buku` varchar(150) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','kembali','hilang') DEFAULT 'dipinjam',
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_pinjam`, `nama_peminjam`, `judul_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `denda`) VALUES
(1, 'Ahmad Fauzi', 'Pemrograman Web PHP', '2025-01-10', '2025-12-22', 'kembali', 339000),
(2, 'Siti Aminah', 'Basis Data MySQL', '2025-01-05', '2025-01-12', 'kembali', 0),
(3, 'Budi Santoso', 'Algoritma & Struktur Data', '2025-01-03', NULL, 'hilang', 50000),
(4, 'MUKHAMAD SHOLAHUDIN ALAYYUBI', 'algoritma', '2025-12-22', '2025-12-22', 'kembali', 0),
(5, 'khilwa Nur aini', 'algoritma', '2025-12-22', '2025-12-22', 'kembali', 0),
(6, 'Sella nur aviva sahira', 'buku tulis', '2025-12-22', '2025-12-22', 'kembali', 0),
(7, 'MUKHAMAD SHOLAHUDIN ALAYYUBI', 'Algoritma & Struktur Data', '2025-12-10', '2025-12-20', 'hilang', 50000),
(8, 'Muhammad ikhsan Fadli ', 'Sistem Informasi', '2025-12-22', '2025-12-22', 'kembali', 0),
(9, 'Muhammad ikhsan Fadli ', 'Pemrograman Web PHP', '2025-12-18', '2025-12-22', 'kembali', 0),
(10, 'MUKHAMAD SHOLAHUDIN ALAYYUBI', 'Jaringan Komputer', '2025-12-01', '2025-12-21', 'dipinjam', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin','superadmin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Super Admin', 'superadmin', 'f35364bc808b079853de5a1e343e7159', 'superadmin'),
(2, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'admin'),
(3, 'User', 'user', '6ad14ba9986e3615423dfca256d04e3f', 'user'),
(4, 'afrel', 'afrel', '2d4ca3623f260044e1e756917ced7f24', 'user'),
(5, 'adrian', 'adrian', 'e10adc3949ba59abbe56e057f20f883e', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `ebook`
--
ALTER TABLE `ebook`
  ADD PRIMARY KEY (`id_ebook`);

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `ebook`
--
ALTER TABLE `ebook`
  MODIFY `id_ebook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
