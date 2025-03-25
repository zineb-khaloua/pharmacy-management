-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 17 mars 2025 à 02:19
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pharmacy_management`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `name`, `description`) VALUES
(1, 'doliprane', ' les bactéries'),
(9, 'cerave', 'skincare');

-- --------------------------------------------------------

--
-- Structure de la table `medicament`
--

CREATE TABLE `medicament` (
  `medicament_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `reference_code` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity_in_stock` int(11) NOT NULL,
  `laboratory` varchar(50) DEFAULT NULL,
  `Reimbursable` enum('YES','NO') NOT NULL,
  `prescription` enum('YES','NO') NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medicament`
--

INSERT INTO `medicament` (`medicament_id`, `name`, `reference_code`, `price`, `quantity_in_stock`, `laboratory`, `Reimbursable`, `prescription`, `supplier_id`, `category_id`) VALUES
(10, 'doliprane', 'FA00000001', 4.00, 2, 'PHARMA', 'YES', 'YES', NULL, 1),
(11, 'doliprane', 'FA00000002', 1.00, 2, 'PHARMA', 'NO', 'YES', 3, 1),
(14, 'doliprane', 'FA00000004', 2.00, 10, 'PHARMA', 'NO', 'NO', 3, 1),
(16, 'zineb khaloua', 'FA00000005', 3.00, 2, 'PHARMA', 'YES', 'NO', 3, 1),
(17, 'doliprane', 'FA00000006', 2.00, 2, 'PHARMA', 'YES', 'NO', 3, 1),
(18, 'doliprane', 'FA00000007', 2.00, 2, 'PHARMA', 'YES', 'YES', 3, 1),
(19, 'doliprane', 'FA00000008', 2.00, 2, 'PHARMA', 'NO', 'YES', 3, 1),
(20, 'aspejic', 'FA00000009', 2.00, 2, 'PHARMA', 'YES', 'NO', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `urgent` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `deadline` date NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`order_id`, `order_date`, `delivery_date`, `total_amount`, `urgent`, `deadline`, `status`, `supplier_id`, `user_id`) VALUES
(1, '2024-12-03', '2024-12-31', 8.00, 'NO', '2024-12-31', 'completed', NULL, 1),
(25, '2025-01-25', '2025-01-25', 50.00, 'NO', '2025-01-24', 'completed', 3, 1),
(26, '2025-01-25', '2025-01-25', 6.00, 'YES', '2025-01-17', 'completed', 3, 1),
(27, '2025-01-25', '2025-01-25', 12.00, 'YES', '2025-01-10', 'pending', 3, 1),
(70, '2025-03-03', '2025-03-03', 12.00, 'YES', '2025-03-03', 'completed', 3, 1),
(71, '2025-03-06', '2025-03-06', 2.00, 'YES', '2025-03-06', 'pending', 3, NULL),
(72, '2025-03-06', '2025-03-06', 12.00, 'YES', '2025-03-06', 'pending', 3, NULL),
(73, '2025-03-10', '2025-03-10', 8.00, 'YES', '2025-03-10', 'pending', 3, 1),
(74, '2025-03-10', '2025-03-10', 8.00, 'YES', '2025-03-10', 'pending', 3, 1),
(75, '2025-03-10', '2025-03-10', 2.00, 'YES', '2025-03-10', 'pending', 3, 1),
(76, '2025-03-10', '2025-03-10', 8.00, 'YES', '2025-03-10', 'pending', 3, 1),
(77, '2025-03-10', '2025-03-10', 4.00, 'YES', '2025-03-10', 'pending', 3, 1),
(78, '2025-03-10', '2025-03-10', 4.00, 'YES', '2025-03-10', 'pending', 3, 1),
(79, '2025-03-10', '2025-03-10', 4.00, 'YES', '2025-03-10', 'pending', 3, 1),
(80, '2025-03-10', '2025-03-10', 2.00, 'YES', '2025-03-10', 'pending', 3, 1),
(81, '2025-03-10', '2025-03-10', 2.00, 'YES', '2025-03-10', 'pending', 3, 1),
(82, '2025-03-10', '2025-03-10', 2.00, 'YES', '2025-03-10', 'pending', 3, 1),
(83, '2025-03-10', '2025-03-10', 8.00, 'YES', '2025-03-10', 'pending', 3, 1),
(84, '2025-03-10', '2025-03-10', 8.00, 'YES', '2025-03-10', 'pending', 3, 1),
(85, '2025-03-10', '2025-03-10', 8.00, 'YES', '2025-03-10', 'pending', 3, 1),
(86, '2025-03-10', '2025-03-10', 3.00, 'YES', '2025-03-10', 'pending', 3, 1),
(87, '2025-03-10', '2025-03-10', 0.00, 'YES', '2025-03-10', 'pending', 3, 1),
(88, '2025-03-10', '2025-03-10', 0.00, 'YES', '2025-03-10', 'pending', 3, 1),
(89, '2025-03-10', '2025-03-10', 0.00, 'YES', '2025-03-10', 'pending', 3, 1),
(90, '2025-03-10', '2025-03-10', 0.00, 'YES', '2025-03-10', 'pending', 3, 1),
(91, '2025-03-10', '2025-03-10', 0.00, 'YES', '2025-03-10', 'pending', 3, 1),
(92, '2025-03-11', '2025-03-11', 0.00, 'YES', '2025-03-11', 'pending', 3, 1),
(93, '2025-03-11', '2025-03-11', 0.00, 'YES', '2025-03-11', 'pending', 3, 1),
(94, '2025-03-11', '2025-03-11', 0.00, 'YES', '2025-03-11', 'pending', 3, 1),
(95, '2025-03-11', '2025-03-11', 0.00, 'YES', '2025-03-11', 'pending', 3, 1),
(96, '2025-03-11', '2025-03-11', 0.00, 'YES', '2025-03-11', 'pending', 3, 1),
(97, '2025-03-11', '2025-03-11', 0.00, 'YES', '2025-03-11', 'pending', 3, 1),
(98, '2025-03-11', '2025-03-11', 0.00, 'YES', '2025-03-11', 'pending', 3, 1),
(99, '2025-03-11', '2025-03-11', 2.00, 'YES', '2025-03-11', 'pending', 3, 1),
(100, '2025-03-15', '2025-03-15', 8.00, 'NO', '2025-03-15', 'pending', 3, 1),
(101, '2025-03-16', '2025-03-16', 0.00, 'YES', '2025-03-16', 'pending', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_id` int(11) NOT NULL,
  `medicament_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`item_id`, `quantity`, `price`, `total`, `order_id`, `medicament_id`) VALUES
(24, 10, 1.00, 10.00, 25, 11),
(25, 9, 4.00, 36.00, 25, 10),
(26, 6, 1.00, 6.00, 26, 20),
(31, 4, 1.00, 4.00, 27, 20),
(74, 2, 1.00, 2.00, 1, 11),
(76, 2, 4.00, 8.00, 70, 10),
(77, 2, 1.00, 2.00, 71, 11),
(78, 3, 4.00, 12.00, 72, 10),
(79, 2, 4.00, 8.00, 73, 10),
(80, 2, 4.00, 8.00, 74, 10),
(81, 2, 1.00, 2.00, 75, 11),
(84, 2, 2.00, 4.00, 78, 17),
(85, 2, 2.00, 4.00, 79, 17),
(86, 2, 1.00, 2.00, 80, 11),
(87, 2, 1.00, 2.00, 81, 11),
(88, 2, 1.00, 2.00, 82, 11),
(89, 2, 4.00, 8.00, 83, 10),
(90, 2, 4.00, 8.00, 84, 10),
(91, 2, 4.00, 8.00, 85, 10),
(92, 3, 1.00, 3.00, 86, 11),
(93, 2, 1.00, 2.00, 99, 11),
(94, 2, 2.00, 4.00, 100, 14),
(95, 2, 2.00, 4.00, 70, 19),
(96, 2, 2.00, 4.00, 25, 14),
(97, 2, 1.00, 2.00, 27, 11),
(98, 2, 3.00, 6.00, 27, 16);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `National_ID` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`patient_id`, `name`, `National_ID`, `dob`, `address`, `phone_number`, `email`) VALUES
(1, 'zineb khaloua', '54500', '2024-12-07', 'Oujda, Marokko', '0600336900', 'khalouazineb@gmail.com'),
(5, 'zineb khaloua', '5454', '2024-12-26', 'Oujda, Marokko', '0600336913', 'khalouazineb@gmail.com'),
(11, 'zineb khaloua', 'fk00999999', '2025-03-09', 'Oujda, Marokko', '0600336913', 'khalouazineb@gmail.com'),
(12, 'zineb khaloua', 'f009', '2025-03-09', ' Oujda, Marokko', '0600336913', 'khalouazineb@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `pharmacy_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `opening_hours` varchar(50) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pharmacy`
--

INSERT INTO `pharmacy` (`pharmacy_id`, `name`, `address`, `phone_number`, `email`, `opening_hours`, `logo`) VALUES
(1, 'pharmacy', '123 Pharmacy St, country 1, city 2', '0600336016', 'pharmacy@gmail.com', '09:00 - 18:00', 'logo/1742085193_2024.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

CREATE TABLE `profile` (
  `profile_id` int(11) NOT NULL,
  `registration_number` varchar(50) DEFAULT 'NOT NULL',
  `name` varchar(20) DEFAULT 'NOT NULL',
  `phone_number` varchar(20) DEFAULT 'NOT NULL',
  `email` varchar(50) DEFAULT 'NOT NULL',
  `salary` decimal(10,2) NOT NULL,
  `hire_date` date NOT NULL,
  `date_birth` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `profile`
--

INSERT INTO `profile` (`profile_id`, `registration_number`, `name`, `phone_number`, `email`, `salary`, `hire_date`, `date_birth`, `user_id`) VALUES
(3, 'kl111111123', 'zineb khaloua', '0600336913', 'admin@gmail.com', 12544.22, '2025-02-15', '2025-02-15', 1),
(23, 'kl111111123', 'zineb khaloua', '0600336913', 'zineb@gmail.com', 12544.22, '2025-03-06', '2025-03-06', 39),
(24, 'kl111111123', 'zineb khaloua', '0600336913', 'khalouazineb@gmail.com', 12544.22, '2025-03-06', '2025-03-06', 40);

-- --------------------------------------------------------

--
-- Structure de la table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `sale_date` datetime DEFAULT NULL,
  `credit` decimal(10,2) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sales`
--

INSERT INTO `sales` (`sales_id`, `total_price`, `sale_date`, `credit`, `patient_id`, `user_id`) VALUES
(31, 12.00, '2025-03-28 17:57:00', 6.00, 5, 1),
(75, 8.00, '2025-03-09 00:00:00', 2.00, NULL, 1),
(76, 3.00, '2025-03-11 00:00:00', 3.00, NULL, 1),
(77, 3.00, '2025-03-11 00:00:00', 3.00, NULL, 1),
(78, 0.00, '2025-03-11 00:00:00', 0.00, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sale_items`
--

CREATE TABLE `sale_items` (
  `item_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `medicament_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `prescription` enum('Yes','No') NOT NULL DEFAULT 'No',
  `price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sale_items`
--

INSERT INTO `sale_items` (`item_id`, `sale_id`, `medicament_id`, `quantity`, `prescription`, `price`, `total`) VALUES
(31, 31, 20, 2, 'Yes', 4.00, 8),
(69, 31, 11, 6, 'No', 1.00, 6),
(71, 75, 10, 2, 'Yes', 4.00, 8),
(72, 76, 11, 3, 'Yes', 1.00, 3),
(73, 77, 11, 3, 'Yes', 1.00, 3),
(80, 31, 17, 2, 'Yes', 2.00, 4);

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `entity` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `phone_number`, `address`, `email`, `entity`) VALUES
(3, 'zineb ', '0600336913', 'Oujda, Marokko', 'khalouazineb@gmail.com', 'homify');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `user_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password_hash`, `role`, `user_picture`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$Q4iTHHZH1poqUEjzDVorD.g1W5pSi9rR1sXiJiLqcJ3YNI0nt5DZi', 'admin', 'uploads/1740757144_Capturedcran2025-02-14161637.png'),
(39, 'zineb', 'zineb@gmail.com', '$2y$10$es5wwq98WZDjCLPOpG3NGeojlZv9EWW.UJeDsGuv1pn9Kr8d/8FdC', 'assistent', 'uploads/1741295456_Ramadan.jpeg'),
(40, 'adminbb', 'khalouazineb@gmail.com', '$2y$10$eODtLEZ0lBH46Z7L7x5hkOfyBHGE099ETuE4Mticby9F03JUGUAh6', 'assistent', 'uploads/1741295480_2024.jpeg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Index pour la table `medicament`
--
ALTER TABLE `medicament`
  ADD PRIMARY KEY (`medicament_id`),
  ADD UNIQUE KEY `reference_code` (`reference_code`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `fk_order_user` (`user_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `medicament_id` (`medicament_id`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Index pour la table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`pharmacy_id`);

--
-- Index pour la table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `fk_admin_user_new` (`user_id`);

--
-- Index pour la table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `fk_sales_user` (`user_id`);

--
-- Index pour la table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_sale` (`sale_id`),
  ADD KEY `fk_medicament` (`medicament_id`);

--
-- Index pour la table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `medicament`
--
ALTER TABLE `medicament`
  MODIFY `medicament_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `pharmacy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT pour la table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `medicament`
--
ALTER TABLE `medicament`
  ADD CONSTRAINT `fk_medic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_medic_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `medicament_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `medicament_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`medicament_id`) REFERENCES `medicament` (`medicament_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_admin_user_new` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sales_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `fk_medicament` FOREIGN KEY (`medicament_id`) REFERENCES `medicament` (`medicament_id`),
  ADD CONSTRAINT `fk_sale` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sales_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
