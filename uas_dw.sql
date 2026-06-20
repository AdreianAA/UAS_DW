-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 19 Jun 2026 pada 14.31
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `uas_dw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dim_pelanggan`
--

CREATE TABLE `dim_pelanggan` (
  `id_pelanggan` int NOT NULL,
  `kode_pelanggan` varchar(20) DEFAULT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dim_pelanggan`
--

INSERT INTO `dim_pelanggan` (`id_pelanggan`, `kode_pelanggan`, `nama_pelanggan`, `jenis_kelamin`, `kota`) VALUES
(1, 'PL001', 'Budi Santoso', 'L', 'Surabaya'),
(2, 'PL002', 'Siti Aisyah', 'P', 'Malang'),
(3, 'PL003', 'Agus Wijaya', 'L', 'Sidoarjo'),
(4, 'PL004', 'Rina Putri', 'P', 'Gresik'),
(5, 'PL005', 'Dedi Kurniawan', 'L', 'Mojokerto');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dim_produk`
--

CREATE TABLE `dim_produk` (
  `id_produk` int NOT NULL,
  `kode_produk` varchar(20) DEFAULT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `dim_produk`
--

INSERT INTO `dim_produk` (`id_produk`, `kode_produk`, `nama_produk`, `kategori`, `harga`) VALUES
(1, 'PR001', 'Laptop Asus', 'Elektronik', 8500000.00),
(2, 'PR002', 'Mouse Logitech', 'Elektronik', 250000.00),
(3, 'PR003', 'Keyboard Gaming', 'Elektronik', 750000.00),
(4, 'PR004', 'Kaos Polos', 'Pakaian', 120000.00),
(5, 'PR005', 'Tas Ransel', 'Aksesoris', 350000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dim_waktu`
--

CREATE TABLE `dim_waktu` (
  `id_waktu` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `bulan` int DEFAULT NULL,
  `bulan_nama` varchar(20) DEFAULT NULL,
  `kuartal` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `dim_waktu`
--

INSERT INTO `dim_waktu` (`id_waktu`, `tanggal`, `tahun`, `bulan`, `bulan_nama`, `kuartal`) VALUES
(1, '2025-01-15', 2025, 1, 'Januari', 1),
(2, '2025-02-20', 2025, 2, 'Februari', 1),
(3, '2025-03-10', 2025, 3, 'Maret', 1),
(4, '2025-04-05', 2025, 4, 'April', 2),
(5, '2025-05-18', 2025, 5, 'Mei', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `fact_penjualan`
--

CREATE TABLE `fact_penjualan` (
  `id_penjualan` int NOT NULL,
  `id_produk` int DEFAULT NULL,
  `id_pelanggan` int DEFAULT NULL,
  `id_waktu` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `harga_satuan` decimal(10,2) DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=COLLATE=utf8mb4_0900_ai_ci; 

--
-- Dumping data untuk tabel `fact_penjualan`
--

INSERT INTO `fact_penjualan` (`id_penjualan`, `id_produk`, `id_pelanggan`, `id_waktu`, `jumlah`, `harga_satuan`, `total_harga`) VALUES
(1, 1, 1, 1, 1, 8500000.00, 8500000.00),
(2, 2, 2, 2, 2, 250000.00, 500000.00),
(3, 3, 3, 3, 1, 750000.00, 750000.00),
(4, 4, 4, 4, 3, 120000.00, 360000.00),
(5, 5, 5, 5, 2, 350000.00, 700000.00),
(6, 1, 2, 2, 1, 8500000.00, 8500000.00),
(7, 2, 3, 3, 4, 250000.00, 1000000.00),
(8, 3, 4, 4, 2, 750000.00, 1500000.00),
(9, 4, 5, 5, 5, 120000.00, 600000.00),
(10, 5, 1, 1, 3, 350000.00, 1050000.00);

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `dim_pelanggan`
--
ALTER TABLE `dim_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `dim_produk`
--
ALTER TABLE `dim_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `dim_waktu`
--
ALTER TABLE `dim_waktu`
  ADD PRIMARY KEY (`id_waktu`);

--
-- Indeks untuk tabel `fact_penjualan`
--
ALTER TABLE `fact_penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_waktu` (`id_waktu`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dim_pelanggan`
--
ALTER TABLE `dim_pelanggan`
  MODIFY `id_pelanggan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `dim_produk`
--
ALTER TABLE `dim_produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `dim_waktu`
--
ALTER TABLE `dim_waktu`
  MODIFY `id_waktu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `fact_penjualan`
--
ALTER TABLE `fact_penjualan`
  MODIFY `id_penjualan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `fact_penjualan`
--
ALTER TABLE `fact_penjualan`
  ADD CONSTRAINT `fact_penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `dim_produk` (`id_produk`),
  ADD CONSTRAINT `fact_penjualan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `dim_pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `fact_penjualan_ibfk_3` FOREIGN KEY (`id_waktu`) REFERENCES `dim_waktu` (`id_waktu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
