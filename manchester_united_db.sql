-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jun 09, 2024 at 10:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manchester_united_db`
--
CREATE DATABASE IF NOT EXISTS `manchester_united_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `manchester_united_db`;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE IF NOT EXISTS `korisnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnicko_ime` varchar(50) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `razina_dozvole` enum('korisnik','administrator') DEFAULT 'korisnik',
  PRIMARY KEY (`id`),
  UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnicko_ime`, `lozinka`, `ime`, `prezime`, `razina_dozvole`) VALUES
(1, 'admin', '$2y$10$CgzaISWGJP9/Wu420gMr3eWM3B/45If1lIW6RVDI/GYHbAj6UaQnq', 'ADMIN', 'ADMIN', 'administrator'),
(2, 'karlo2000', '$2y$10$ovS8Y.dpgzNpSTdLajD5HeDNhaSWjoK86bBQp5nzBX0NjhxDlM6qy', 'Karlo', 'Šiljevinac', 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE IF NOT EXISTS `vijesti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(255) NOT NULL,
  `kratki_sadrzaj` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(255) DEFAULT NULL,
  `datum` datetime NOT NULL DEFAULT current_timestamp(),
  `kategorija` varchar(255) NOT NULL,
  `arhiva` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `naslov`, `kratki_sadrzaj`, `tekst`, `slika`, `datum`, `kategorija`, `arhiva`) VALUES
(43, 'Ten Hag i Ratcliffe planiraju budućnost Uniteda', 'Ten Hag i Ratcliffe razgovaraju o budućnosti kluba.', 'Erik ten Hag i Sir Jim Ratcliffe razgovaraju o budućnosti Manchester Uniteda i planovima za sljedeću sezonu. Klub želi ojačati ekipu i osigurati stabilnost u vrhu Premier lige.', 'images/0_Untitled-1.webp', '2024-06-09 10:00:00', 'Vijesti', 1),
(44, 'Manchester United Foundation donira za lokalnu zajednicu', 'Foundation pomaže lokalnim zajednicama donacijama.', 'Foundation je nedavno objavila značajnu donaciju lokalnim zajednicama, fokusirajući se na obrazovanje, zdravstvo i sportske programe za mlade.', 'images/images (1).jpg', '2024-06-09 11:00:00', 'Vijesti', 1),
(45, 'Transfer novosti: Osimhen, Grealish, Casemiro', 'Transfer vijesti uživo: Osimhen i Grealish u fokusu.', 'Transfer vijesti uživo donose najnovije informacije o potencijalnim dolascima i odlascima igrača poput Victora Osimhena, Jacka Grealisha i Casemira. Klubovi širom Europe rade na pojačanjima.', 'images/RR-transfer-news-live-blog-6JUNE-comp_3864bd.webp', '2024-06-09 12:00:00', 'Transferi', 1),
(46, 'Man United igrači motivirani za novu sezonu', 'United igrači spremni za novu Premier League sezonu.', 'Manchester United igrači, uključujući mlade talente i iskusne veterane, pokazuju veliku motivaciju i entuzijazam pred početak nove sezone, nadajući se boljem plasmanu u Premier ligi.', 'images/Man United POTY 2024.webp', '2024-06-09 13:00:00', 'Vijesti', 1),
(47, 'Sevilla napadač prelazi u Manchester United', 'Youssef En-Nesyri prelazi u Manchester United.', 'Napadač Seville, Youssef En-Nesyri, blizu je prelaska u Manchester United. Ovaj transfer bi trebao ojačati napadačke opcije kluba.', 'images/c.webp', '2024-06-09 14:00:00', 'Transferi', 1),
(48, 'Manchester United Ženski tim slavi pobjedu', 'Ženski tim Uniteda slavi posljednju pobjedu.', 'Manchester United Ženski tim slavi pobjedu u posljednjoj utakmici, demonstrirajući snagu i jedinstvo ekipe koja se bori za vrh ligaške tablice.', 'images/download (2).jpg', '2024-06-09 15:00:00', 'Utakmice', 1),
(49, 'Man United zastava ponosno vijori na stadionu', 'Man United zastava simbolizira klupski ponos.', 'Zastava Manchester Uniteda ponosno se vijori na stadionu, simbolizirajući bogatu povijest i tradiciju kluba koji je sinonim za uspjeh u engleskom nogometu.', 'images/download (1).jpg', '2024-06-09 16:00:00', 'Vijesti', 1),
(50, 'Thomas Tuchel cilja na povratak u Premier ligu', 'Tuchel želi povratak u englesku Premier ligu.', 'Bivši menadžer Chelseaja, Thomas Tuchel, izražava želju za povratkom u Premier ligu. Njegovo iskustvo i uspjesi u Engleskoj čine ga poželjnim kandidatom za mnoge klubove.', 'images/download.jpg', '2024-06-09 17:00:00', 'Vijesti', 1),
(51, 'Jonny Evans predvodi Sjevernu Irsku protiv Španjolske', 'Evans predvodi Sjevernu Irsku u ključnoj utakmici.', 'Iskusni defanzivac Manchester Uniteda i reprezentacije Sjeverne Irske, Jonny Evans, predvodi svoju reprezentaciju u važnoj utakmici protiv Španjolske.', 'images/GPjlNswWcAAeqK1.jpg', '2024-06-09 18:00:00', 'Utakmice', 1),
(52, 'United Jersey 2023/24: Najnoviji dizajn otkriven', 'United otkrio novi dres za sezonu 2023/24.', 'Manchester United otkrio je najnoviji dizajn dresa za sezonu 2023/24. Dres kombinira tradicionalne klupske boje s modernim elementima, privlačeći pažnju navijača širom svijeta.', 'images/Manchester_United_23-24_Home_Jersey_Red_IP1726_HM1.avif', '2024-06-09 19:00:00', 'Vijesti', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
