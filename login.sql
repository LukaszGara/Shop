-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Paź 2021, 17:54
-- Wersja serwera: 10.4.20-MariaDB
-- Wersja PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `login`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211007102433', '2021-10-07 12:24:41', 224),
('DoctrineMigrations\\Version20211008155825', '2021-10-08 17:58:35', 556),
('DoctrineMigrations\\Version20211008160247', '2021-10-08 18:02:49', 124),
('DoctrineMigrations\\Version20211009150609', '2021-10-09 17:06:17', 1176),
('DoctrineMigrations\\Version20211009163028', '2021-10-09 18:30:35', 1904),
('DoctrineMigrations\\Version20211011094429', '2021-10-11 11:44:35', 378),
('DoctrineMigrations\\Version20211012162102', '2021-10-12 18:21:09', 494),
('DoctrineMigrations\\Version20211012162545', '2021-10-12 18:25:51', 1444),
('DoctrineMigrations\\Version20211014150908', '2021-10-14 17:09:21', 2903),
('DoctrineMigrations\\Version20211014163036', '2021-10-14 18:30:39', 3781);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seller_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`id`, `name`, `amount`, `price`, `category`, `image`, `description`, `seller_id`) VALUES
(1, 'Computer', '65', '2000,00$', 'Electronic', 'laptop1.jpg', 'really good laptop with super mega graphic card and many other extra things', 1),
(2, 'Lamp', '150', '250,00$', 'office', 'bc866c470e998bc50c02cca80510dfb0.jpg', 'Very good lamp wtih high brightness', 1),
(3, 'Lamp2', '90', '200,00$', 'office', '658e8292a57a45fea3977ea103c46053.jpg', 'better lamp wtih higher brightness', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nick` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `nick`, `name`, `surname`, `avatar`) VALUES
(1, 1, 'hermanterossssss', 'Lukaszzz123aaaaa', 'Gara', 'pikachu.jpg'),
(3, 3, 'hermanter', 'Lukaszzz567', 'hermanter', 'e57fdc245c456692fcea257b35b4245b.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `purchase`
--

INSERT INTO `purchase` (`id`, `user_id`, `product_id`) VALUES
(15, 1, 1),
(16, 1, 2),
(17, 3, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shopping_cart_products`
--

CREATE TABLE `shopping_cart_products` (
  `shopping_cart_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`) VALUES
(1, 'hermanter@wp.pl', '[\"ROLE_ADMIN\"]', '$2y$13$m/oQCKITFA24hwnEXeCcWuok.GSXV7kfPk0dC5I9nPXTDDAveExZK', 1),
(3, 'lukaszgara4@wp.pl', '[]', '$2y$13$bLb2K41LwfznTd.3HIEZuOkeLByOYZgMuQYEGO4fTCijh4VontKXe', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B3BA5A5A8DE820D9` (`seller_id`);

--
-- Indeksy dla tabeli `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8157AA0FA76ED395` (`user_id`);

--
-- Indeksy dla tabeli `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6117D13B4584665A` (`product_id`),
  ADD KEY `IDX_6117D13BA76ED395` (`user_id`);

--
-- Indeksy dla tabeli `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_72AAD4F6CCFA12B8` (`profile_id`);

--
-- Indeksy dla tabeli `shopping_cart_products`
--
ALTER TABLE `shopping_cart_products`
  ADD PRIMARY KEY (`shopping_cart_id`,`products_id`),
  ADD KEY `IDX_5FF0FD2645F80CD` (`shopping_cart_id`),
  ADD KEY `IDX_5FF0FD266C8A81A9` (`products_id`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_B3BA5A5A8DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `profile` (`id`);

--
-- Ograniczenia dla tabeli `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `FK_8157AA0FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `FK_6117D13B4584665A` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `FK_6117D13B9D86650F` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `FK_72AAD4F6CCFA12B8` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);

--
-- Ograniczenia dla tabeli `shopping_cart_products`
--
ALTER TABLE `shopping_cart_products`
  ADD CONSTRAINT `FK_5FF0FD2645F80CD` FOREIGN KEY (`shopping_cart_id`) REFERENCES `shopping_cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5FF0FD266C8A81A9` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
