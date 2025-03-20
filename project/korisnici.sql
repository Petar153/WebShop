-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 03:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `korisnici`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `uloga` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `username`, `lozinka`, `email`, `uloga`) VALUES
(1, 'P', 'B', 'bs2', 'gm123', 'p.b@gm.com', 'kupac'),
(2, 'Ad', 'Min', 'admin', 'admin', 'admin@etgm.com', 'admin'),
(3, 'Mod', 'Erator', 'mod', 'mod', 'mod@etgm.com', 'mod');

-- --------------------------------------------------------

--
-- Table structure for table `kosarica`
--

CREATE TABLE `kosarica` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `proizvod_id` int(11) NOT NULL,
  `kolicina` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kosarica`
--

INSERT INTO `kosarica` (`id`, `user_id`, `proizvod_id`, `kolicina`) VALUES
(29, 1, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `narudzba_proizvodi`
--

CREATE TABLE `narudzba_proizvodi` (
  `id` int(11) NOT NULL,
  `narudzba_id` int(11) NOT NULL,
  `proizvod_id` int(11) NOT NULL,
  `kolicina` int(11) NOT NULL,
  `cijena` decimal(10,2) NOT NULL,
  `ukupna_cijena` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `narudzba_proizvodi`
--

INSERT INTO `narudzba_proizvodi` (`id`, `narudzba_id`, `proizvod_id`, `kolicina`, `cijena`, `ukupna_cijena`) VALUES
(5, 8, 4, 1, 129.99, 129.99),
(6, 8, 5, 3, 179.99, 539.97),
(7, 8, 6, 1, 79.99, 79.99);

-- --------------------------------------------------------

--
-- Table structure for table `narudzbe`
--

CREATE TABLE `narudzbe` (
  `id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `datum` datetime DEFAULT current_timestamp(),
  `ukupna_cijena` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Na cekanju',
  `metoda_dostave` varchar(50) NOT NULL,
  `ime_prezime` varchar(255) NOT NULL,
  `adresa` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `narudzbe`
--

INSERT INTO `narudzbe` (`id`, `korisnik_id`, `datum`, `ukupna_cijena`, `status`, `metoda_dostave`, `ime_prezime`, `adresa`, `email`, `telefon`) VALUES
(8, 2, '2025-01-14 15:17:48', 749.95, 'Na cekanju', 'Standardna', 'dsa', 'ds', 's@s', '3');

-- --------------------------------------------------------

--
-- Table structure for table `proizvodi`
--

CREATE TABLE `proizvodi` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `proizvodac` varchar(255) NOT NULL,
  `cijena` decimal(10,2) NOT NULL,
  `slika` varchar(255) DEFAULT NULL,
  `opis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proizvodi`
--

INSERT INTO `proizvodi` (`id`, `naziv`, `proizvodac`, `cijena`, `slika`, `opis`) VALUES
(1, 'Logitech MX Keys', 'Logitech', 99.99, 'https://gfx3.senetic.com/akeneo-catalog/5/7/8/4/5784142fd770b4405ac5b17cd47bc60ea096773a_1717772_920_010498_image1.jpg', 'Bezicna tipkovnica visokih performansi.'),
(2, 'Corsair K95 RGB Platinum', 'Corsair', 199.99, 'https://www.mall.hr/i/41707660/550/550', 'Mehanicka tipkovnica s RGB osvjetljenjem.'),
(3, 'Razer BlackWidow V3', 'Razer', 129.99, 'https://cdn.ozone.hr/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/8/1/bc4cf409725f7a98c87293a191df4ae8/mehanicka-tipkovnica-razer---blackwidow-v3-tenkeyless--green--rgb--crna-30.jpg', 'Gaming tipkovnica s prilagodljivim tipkama.'),
(4, 'Logitech G Pro', 'Logitech', 129.99, 'https://resource.logitech.com/content/dam/gaming/en/products/pro-keyboard/pro-keyboard-gallery/uk-pro-gaming-keyboard-gallery-topdown.png', 'Kompaktna gaming tipkovnica.'),
(5, 'Corsair K70 RGB MK.2', 'Corsair', 179.99, 'https://external-preview.redd.it/JRC8zntuR_8qhHMGRJc52iI-nTFjr6Mis5AMMKFIzlU.jpg?width=1080&crop=smart&auto=webp&s=8922c83759cfddb851126784c7a77b84ebc370b1', 'Napredna mehanicka tipkovnica.'),
(6, 'Razer Cynosa Chroma', 'Razer', 79.99, 'https://www.mall.hr/i/42895822/550/550', 'Povoljna gaming tipkovnica s RGB osvjetljenjem.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kosarica`
--
ALTER TABLE `kosarica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `proizvod_id` (`proizvod_id`);

--
-- Indexes for table `narudzba_proizvodi`
--
ALTER TABLE `narudzba_proizvodi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `narudzba_id` (`narudzba_id`),
  ADD KEY `proizvod_id` (`proizvod_id`);

--
-- Indexes for table `narudzbe`
--
ALTER TABLE `narudzbe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `korisnik_id` (`korisnik_id`);

--
-- Indexes for table `proizvodi`
--
ALTER TABLE `proizvodi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kosarica`
--
ALTER TABLE `kosarica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `narudzba_proizvodi`
--
ALTER TABLE `narudzba_proizvodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `narudzbe`
--
ALTER TABLE `narudzbe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `proizvodi`
--
ALTER TABLE `proizvodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kosarica`
--
ALTER TABLE `kosarica`
  ADD CONSTRAINT `kosarica_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kosarica_ibfk_2` FOREIGN KEY (`proizvod_id`) REFERENCES `proizvodi` (`id`);

--
-- Constraints for table `narudzba_proizvodi`
--
ALTER TABLE `narudzba_proizvodi`
  ADD CONSTRAINT `narudzba_proizvodi_ibfk_1` FOREIGN KEY (`narudzba_id`) REFERENCES `narudzbe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `narudzba_proizvodi_ibfk_2` FOREIGN KEY (`proizvod_id`) REFERENCES `proizvodi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `narudzbe`
--
ALTER TABLE `narudzbe`
  ADD CONSTRAINT `narudzbe_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
