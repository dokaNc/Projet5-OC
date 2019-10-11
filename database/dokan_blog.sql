-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 11 oct. 2019 à 02:28
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dokan_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `author` varchar(45) NOT NULL,
  `content` text NOT NULL,
  `add_date` datetime NOT NULL,
  `validation` tinyint(3) UNSIGNED NOT NULL,
  `posts_id` smallint(5) UNSIGNED NOT NULL,
  `users_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(50) NOT NULL,
  `add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `headline`, `content`, `author`, `add_date`) VALUES
(1, 'Article 1', 'Voici Article 1', 'Ecrivez ce que vous voulez dans le content !', 'Dogukan Cirpan', '2019-10-03 14:21:53'),
(2, 'Article 2', 'Voici l\'article 2', 'Ecrivez ce que vous voulez dans le content de l\'article 2', 'Dogukan Cirpan', '2019-09-25 15:00:00'),
(3, 'Article 3', 'Voici l\'article 3', 'Ecrivez ce que vous voulez dans le content de l\'article 3', 'Dogukan Cirpan', '2019-09-25 15:00:00'),
(4, 'Article 4', 'Voici l\'article 4', 'Ecrivez ce que vous voulez dans le content de l\'article 4', 'Dogukan Cirpan', '2019-09-25 15:00:00'),
(5, 'Article 5', 'Voici l\'article 5', 'Ecrivez ce que vous voulez dans le content de l\'article 5', 'Dogukan Cirpan', '2019-09-25 15:00:00'),
(6, 'Article 6', 'Voici l\'article 6', 'Ecrivez ce que vous voulez dans le content de l\'article 6', 'Dogukan Cirpan', '2019-09-25 15:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `status`) VALUES
(1, 'Administrateur', 'Blog', 'Admin', 'admin@blog.com', '$2y$10$nIIaqZi4/XIM.wWSDxi9JOUlVWHAUZoE32ciRDuhYqTYadVbz8V7i', 'admin'),
(3, 'Dogukan', 'CIRPAN', 'admin', 'cirpan.dogukan5959@gmail.com', '$2y$10$nIIaqZi4/XIM.wWSDxi9JOUlVWHAUZoE32ciRDuhYqTYadVbz8V7i', 'normal'),
(6, 'Dogukan', 'CIRPAN', 'azd654465', 'cirpan.dogukan5944@gmail.com', '$2y$10$LLv..p4kGDxV5TgKACE6busGEQoxRf9hz6j5O5UI1UrgE9cGnXKpW', 'new');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`,`posts_id`,`users_id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_comment_post1_idx` (`posts_id`),
  ADD KEY `fk_comments_users1_idx` (`users_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `mail_UNIQUE` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment_post1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comments_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
