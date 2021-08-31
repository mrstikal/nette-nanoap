-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Úte 31. srp 2021, 21:33
-- Verze serveru: 10.3.14-MariaDB
-- Verze PHP: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `nette_nanoapp`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_name` (`user_name`),
  KEY `role` (`role`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id`, `user_name`, `password_hash`, `role`, `status`) VALUES
(1, 'alex', '$2y$10$ZhdPqYe5HWfhH6CwbT1cvebhg43BHZMxSbnx2x5/4OhUwWX6oWjgW', 'admin', 'enabled'),
(2, 'jindra', '$2y$10$vZQ0nsCcNqa5waTW0NI89.Hm5iSKoYbq/fQ6kitvHxORgUUNJ/p5S', 'user', 'enabled'),
(3, 'franta', '$2y$10$NenxboL70815dt4m3QRwlODpf.xzLgL8nFE4wOAra10TT41UA.XJy', 'user', 'disabled'),
(4, 'pepa', '$2y$10$ob20YVassIPbYoCUGuji6e0sXPSp76LYZZ7pz4M72b4xaKNzU2Jzq', 'user', 'enabled'),
(5, 'olda', '$2y$10$eIajW6Fd5aezcH.El.Sdx./7BQcP6GB9AuGivextHk/y2WQEwL1JO', 'user', 'disabled'),
(6, 'jirina', '$2y$10$It3Xzd2KfhK08pVrqrwQ8.9XW99Zb4swTKjebye67wLinECqFpyJm', 'admin', 'enabled'),
(7, 'jana', '$2y$10$zGeHzjTyVMnG40q3GPJei.eCK4CaU0kAvdsjEMVVDEyWOx9AwsxGm', 'user', 'enabled'),
(8, 'stana', '$2y$10$z4quPAa/EWqGLpvnFLhFYe6iEH5roCzLS3i5z3qURhB8NWtIuRA5K', 'user', 'enabled');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
