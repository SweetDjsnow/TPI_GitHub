-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 17 Mars 2021 à 08:24
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_pre_tpi`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_bikes`
--

CREATE TABLE `t_bikes` (
  `idBike` int(11) NOT NULL,
  `bikeFoundDate` date NOT NULL,
  `bikFoundLocation` varchar(100) NOT NULL,
  `bikBrand` varchar(50) NOT NULL,
  `bikColor` varchar(50) NOT NULL,
  `bikSerialNumber` varchar(50) NOT NULL,
  `bikHeight` varchar(50) NOT NULL,
  `bikIsElectric` tinyint(4) NOT NULL,
  `bikHasBeenRetrieved` tinyint(4) NOT NULL,
  `bikRetrieveDate` date DEFAULT NULL,
  `idCity` int(11) NOT NULL,
  `idReceiver` int(11) DEFAULT NULL,
  `idGiver` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_bikes`
--

INSERT INTO `t_bikes` (`idBike`, `bikeFoundDate`, `bikFoundLocation`, `bikBrand`, `bikColor`, `bikSerialNumber`, `bikHeight`, `bikIsElectric`, `bikHasBeenRetrieved`, `bikRetrieveDate`, `idCity`, `idReceiver`, `idGiver`) VALUES
(5, '2021-03-04', 'Morges', 'Brompton', 'Noir', '875-563-567-732', '140', 1, 1, '2020-06-11', 1, 1, 1),
(6, '2021-03-17', 'Morges', 'Norco', 'Vert', '875-5632-6849-3213', '14', 0, 0, NULL, 20, NULL, NULL),
(7, '2020-11-14', 'Sion', 'Norco', 'Bleu', '444-333-222-111', '190', 1, 1, '2021-03-12', 17, 10, 1),
(8, '2021-03-03', 'fs', 'Norco', 'Gris', '111-222-333-444', '170', 1, 0, NULL, 1, NULL, NULL),
(9, '2021-03-01', 'Morges', 'Pinnacle', 'Jaune', '111-222-333-444', '90', 0, 0, NULL, 1, NULL, NULL),
(10, '2021-03-03', 'Lausanne', 'Norco', 'Rouge', '875-563-567-732', '120', 0, 0, NULL, 2, NULL, NULL),
(11, '2021-03-03', 'Lausanne', 'Norco', 'Rouge', '875-563-567-732', '120', 0, 0, NULL, 2, NULL, NULL),
(12, '2021-03-09', 'Morges', 'Norco', 'Brun', '875-563-567-732', '140', 1, 0, NULL, 17, NULL, NULL),
(13, '2021-03-02', 'Morges', 'Cube', 'Bleu', '111-222-333-444', '90', 1, 0, NULL, 1, NULL, NULL),
(14, '2021-03-01', 'Lausanne', 'Norco', 'Jaune', '444-333-222-111', '130', 1, 0, NULL, 1, NULL, NULL),
(15, '2021-03-10', 'Morges', 'Cube', 'Noir', '111-222-333-444', '90', 1, 0, NULL, 2, NULL, NULL),
(16, '2021-03-03', 'Morges', 'Norco', 'Gris', '111-222-333-444', '90', 1, 0, NULL, 1, NULL, NULL),
(17, '2021-03-02', 'Morges', 'Brompton', 'Rouge', '875-563-567-732', '170', 1, 0, NULL, 1, NULL, NULL),
(18, '2021-03-16', 'Lausanne', 'Cube', 'Gris', '111-222-333-444', '90', 0, 1, '2021-03-15', 20, 1, 1),
(19, '2021-03-09', '', 'Pinnacle', 'Noir', 'dfs', 'sdfsdf', 1, 0, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_brand`
--

CREATE TABLE `t_brand` (
  `idBrand` int(11) NOT NULL,
  `braName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_brand`
--

INSERT INTO `t_brand` (`idBrand`, `braName`) VALUES
(1, 'Cannondale'),
(2, 'Brompton'),
(3, 'Pinnacle'),
(4, 'Norco'),
(5, 'Cube');

-- --------------------------------------------------------

--
-- Structure de la table `t_city`
--

CREATE TABLE `t_city` (
  `idCity` int(11) NOT NULL,
  `citName` varchar(50) NOT NULL,
  `citNPA` varchar(10) NOT NULL,
  `citContactPhone` varchar(25) NOT NULL,
  `citContactEmail` varchar(100) NOT NULL,
  `citContactFirstName` varchar(50) NOT NULL,
  `citContactLastName` varchar(50) NOT NULL,
  `citOfficeLocation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_city`
--

INSERT INTO `t_city` (`idCity`, `citName`, `citNPA`, `citContactPhone`, `citContactEmail`, `citContactFirstName`, `citContactLastName`, `citOfficeLocation`) VALUES
(1, 'Morges', '1110', '0789069983', 'm.dsc@outlook.fr', 'Dos', 'Santos', 'Route de Lausanne 35B'),
(2, 'Lausanne', '1110', ' 33789069983', 'm.dsc@outlook.fr', 'Dos', 'Santos', 'Route de Lausanne 35B'),
(17, 'St-Prex', '1110', ' 33789069983', 'm.dsc@outlook.fr', 'ja', 'doe', 'Route de Lausanne 35B'),
(20, 'London', '1110', ' 33789069983', 'm.dsc@outlook.fr', 'Dos', 'Santos', 'Route de Lausanne 35B');

-- --------------------------------------------------------

--
-- Structure de la table `t_color`
--

CREATE TABLE `t_color` (
  `idColor` int(11) NOT NULL,
  `colName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_color`
--

INSERT INTO `t_color` (`idColor`, `colName`) VALUES
(1, 'Rouge'),
(2, 'Bleu'),
(3, 'Noir'),
(4, 'Gris'),
(5, 'Jaune'),
(6, 'Vert'),
(7, 'Violet'),
(8, 'Rose'),
(9, 'Brun'),
(10, 'Orange');

-- --------------------------------------------------------

--
-- Structure de la table `t_giver`
--

CREATE TABLE `t_giver` (
  `idGiver` int(11) NOT NULL,
  `givFirstName` varchar(100) NOT NULL,
  `givLastName` varchar(100) NOT NULL,
  `givEmail` varchar(150) DEFAULT NULL,
  `givPhoneNumber` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_giver`
--

INSERT INTO `t_giver` (`idGiver`, `givFirstName`, `givLastName`, `givEmail`, `givPhoneNumber`) VALUES
(1, 'Michel', 'Dos Santos Constantino', 'michel.dossantos@eduvaud.ch', '0789069983'),
(2, 'test', 'test', 'm.dsc@outlook.fr', '0789069983'),
(3, 'dwdw', 'dwdwdw', 'dwdwdwd', 'wdwdwdwd'),
(4, 'John', 'Doe', 'john.doe@gmail.com', '0789069983'),
(5, 'Johnny', 'Doeee', 'johnny.doe@gmail.com', '0789069983'),
(6, 'dasadasdasdasd', 'asdasdasdasd', 'asdasdasd', 'asdasdad'),
(7, 'dasas', 'sadasd', 'asdad', 'sadad'),
(8, '687678', 'test', 'm.dsc@outlook.fr', '0789069983');

-- --------------------------------------------------------

--
-- Structure de la table `t_photo`
--

CREATE TABLE `t_photo` (
  `idPhoto` int(11) NOT NULL,
  `phoPath` varchar(500) NOT NULL,
  `idBike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_photo`
--

INSERT INTO `t_photo` (`idPhoto`, `phoPath`, `idBike`) VALUES
(1, 'BNsm9FKRVp.png', 5),
(2, 'e1nXwpPi09.png', 5),
(3, '7MOf3p1mvd.png', 6),
(4, 'DdaKO46SU5.jpg', 6),
(5, 'rYFAwKcn0Z.jpg', 7),
(6, '8wL9k0oUhq.png', 8),
(7, 'h8OPFYeSiR.png', 9),
(8, 'Tv0RhkSKMW.png', 10),
(9, 'DdyFMbN1pm.png', 10),
(10, 'rb1EPCJdDR.png', 11),
(11, 'JV53Hs84aF.png', 11),
(12, 'GBU7xaZ0ez.jpg', 12),
(13, 'deptskhXjS.jpg', 13),
(14, 'C0DPZmva8z.jpg', 14),
(15, 'EgA6V5wrtb.jpg', 15),
(16, 'TJGYK4Q5XF.png', 16),
(17, 'mvz6rxbRiq.jpg', 17),
(18, 'JgNWfCrz1v.jpg', 17),
(19, 'YPSfcTZibv.jpg', 18),
(20, 'g1BT4JYnqL.jpg', 18),
(21, 'PEuZniUhwt.jpg', 18),
(22, 'f4gBRX7eWS.jpg', 19);

-- --------------------------------------------------------

--
-- Structure de la table `t_receiver`
--

CREATE TABLE `t_receiver` (
  `idReceiver` int(11) NOT NULL,
  `recFirstName` varchar(100) NOT NULL,
  `recLastName` varchar(100) NOT NULL,
  `recEmail` varchar(150) DEFAULT NULL,
  `recPhoneNumber` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_receiver`
--

INSERT INTO `t_receiver` (`idReceiver`, `recFirstName`, `recLastName`, `recEmail`, `recPhoneNumber`) VALUES
(1, 'Michel', 'Dos Santos', 'm.dsc@outlook.fr', '0789069983'),
(2, 'test', 'test', 'm.dsc@outlook.fr', '0789069983'),
(3, 'Rafael', 'Felix', 'r.felix@gmail.com', '0768975432'),
(4, 'Dos', 'Santos', 'm.dsc@outlook.fr', '0789069983'),
(5, 'efwwef', 'wefwef', 'wefwef', 'ewfwefwef'),
(6, 'efwwef', 'wefwef', 'wefwef', 'ewfwefwef'),
(7, 'fefwe', 'fwewefw', 'fwefwefwef', 'wefwefwf'),
(8, 'dasdasd', 'asdasd', 'asdasd', 'asdasd'),
(9, 'Johnny', 'Depp', 'm.dsc@outlook.fr', '0789069983'),
(10, 'ajajajaaj', 'ajhajajajaa', '', 'aajaja');

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE `t_user` (
  `idUser` int(11) NOT NULL,
  `useUsername` varchar(50) NOT NULL,
  `usePassword` varchar(300) NOT NULL,
  `useIsAdmin` tinyint(4) NOT NULL,
  `useIsSuperAdmin` tinyint(4) NOT NULL,
  `useFirstName` varchar(50) NOT NULL,
  `useLastName` varchar(100) NOT NULL,
  `usePhoneNumber` varchar(30) NOT NULL,
  `useEmail` varchar(50) NOT NULL,
  `idCity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t_user`
--

INSERT INTO `t_user` (`idUser`, `useUsername`, `usePassword`, `useIsAdmin`, `useIsSuperAdmin`, `useFirstName`, `useLastName`, `usePhoneNumber`, `useEmail`, `idCity`) VALUES
(2, 'super-admin', '$2y$10$es3FYyelyAw8QlUeEa56Le/khRr30av.9Tu6NAXnhgIZf/dvUkx2a', 1, 1, 'Michel', 'Dos Santos Constantino', '0789069983', 'michel.dossantos@eduvaud.ch', 1),
(4, 'do.santo', '$2y$10$9qp9zJgUbppi8KdHlwsLOusoO3sN7woQz2pH71OLIx2ngOtOB.QHC', 1, 0, 'Dos', 'Santos', ' 33789069983', 'm.dsc@outlook.fr', 2),
(6, 'jo.doe', '$2y$10$ud9QY4pwEh8TnC9xX.XxuOl36MQBST1BBQ77jGiKpDLn9oomofpjG', 0, 0, 'john', 'doe', ' 33789069983', 'm.dsc@outlook.fr', 2),
(7, 'ja.doe', '$2y$10$xh/LJ.2U3irpBUyp1pAQyOhRDm4.cBINoKvGqCSdNLidhTmOmSejG', 1, 0, 'ja', 'doe', ' 33789069983', 'm.dsc@outlook.fr', 17),
(8, 'ra.felix', '$2y$10$ZsSuHVeiOIkg7IU7LIroXuybvQmFIFB54lDW84QoqK5yVeY8n9jg2', 0, 0, 'Rafael', 'Felix', ' 33789069983', 'm.dsc@outlook.fr', 20);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_bikes`
--
ALTER TABLE `t_bikes`
  ADD PRIMARY KEY (`idBike`),
  ADD KEY `fkIdx_26` (`idCity`),
  ADD KEY `fkIdx_80` (`idReceiver`),
  ADD KEY `fkIdx_93` (`idGiver`);

--
-- Index pour la table `t_brand`
--
ALTER TABLE `t_brand`
  ADD PRIMARY KEY (`idBrand`);

--
-- Index pour la table `t_city`
--
ALTER TABLE `t_city`
  ADD PRIMARY KEY (`idCity`);

--
-- Index pour la table `t_color`
--
ALTER TABLE `t_color`
  ADD PRIMARY KEY (`idColor`);

--
-- Index pour la table `t_giver`
--
ALTER TABLE `t_giver`
  ADD PRIMARY KEY (`idGiver`);

--
-- Index pour la table `t_photo`
--
ALTER TABLE `t_photo`
  ADD PRIMARY KEY (`idPhoto`),
  ADD KEY `fkIdx_66` (`idBike`);

--
-- Index pour la table `t_receiver`
--
ALTER TABLE `t_receiver`
  ADD PRIMARY KEY (`idReceiver`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `fkIdx_32` (`idCity`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_bikes`
--
ALTER TABLE `t_bikes`
  MODIFY `idBike` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `t_brand`
--
ALTER TABLE `t_brand`
  MODIFY `idBrand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `t_city`
--
ALTER TABLE `t_city`
  MODIFY `idCity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `t_color`
--
ALTER TABLE `t_color`
  MODIFY `idColor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `t_giver`
--
ALTER TABLE `t_giver`
  MODIFY `idGiver` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `t_photo`
--
ALTER TABLE `t_photo`
  MODIFY `idPhoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `t_receiver`
--
ALTER TABLE `t_receiver`
  MODIFY `idReceiver` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_bikes`
--
ALTER TABLE `t_bikes`
  ADD CONSTRAINT `FK_25` FOREIGN KEY (`idCity`) REFERENCES `t_city` (`idCity`),
  ADD CONSTRAINT `FK_79` FOREIGN KEY (`idReceiver`) REFERENCES `t_receiver` (`idReceiver`),
  ADD CONSTRAINT `FK_92` FOREIGN KEY (`idGiver`) REFERENCES `t_giver` (`idGiver`);

--
-- Contraintes pour la table `t_photo`
--
ALTER TABLE `t_photo`
  ADD CONSTRAINT `FK_65` FOREIGN KEY (`idBike`) REFERENCES `t_bikes` (`idBike`);

--
-- Contraintes pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `FK_31` FOREIGN KEY (`idCity`) REFERENCES `t_city` (`idCity`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
