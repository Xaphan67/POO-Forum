-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum
CREATE DATABASE IF NOT EXISTS `forum` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum`;

-- Listage de la structure de table forum. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(150) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.categorie : ~2 rows (environ)
INSERT INTO `categorie` (`id_categorie`, `nomCategorie`) VALUES
	(1, 'Catégorie A'),
	(2, 'Catégorie B');

-- Listage de la structure de table forum. message
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `texteMessage` text NOT NULL,
  `dateCreationMessage` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visiteur_id` int NOT NULL,
  `sujet_id` int NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `message_fk1` (`sujet_id`),
  KEY `message_fk2` (`visiteur_id`),
  CONSTRAINT `message_fk1` FOREIGN KEY (`sujet_id`) REFERENCES `sujet` (`id_sujet`) ON DELETE CASCADE,
  CONSTRAINT `message_fk2` FOREIGN KEY (`visiteur_id`) REFERENCES `visiteur` (`id_visiteur`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.message : ~7 rows (environ)
INSERT INTO `message` (`id_message`, `texteMessage`, `dateCreationMessage`, `visiteur_id`, `sujet_id`) VALUES
	(3, 'Test en tant que cédric', '2023-08-30 16:36:15', 3, 5),
	(4, 'Pas mal, je peux même me répondre à moi-même !', '2023-08-30 16:37:59', 3, 5),
	(5, 'Juste pour... tester', '2023-08-30 16:44:26', 3, 6),
	(6, 'Je réponds au mon propre message', '2023-08-30 16:44:43', 3, 6),
	(7, 'Ah, on peut pas éditer.', '2023-08-30 16:44:59', 3, 6),
	(10, ':)', '2023-08-30 16:46:14', 3, 9),
	(11, 'Je réponds avec un autre utilisateur', '2023-08-30 16:47:32', 4, 9);

-- Listage de la structure de table forum. sujet
CREATE TABLE IF NOT EXISTS `sujet` (
  `id_sujet` int NOT NULL AUTO_INCREMENT,
  `titreSujet` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateCreationSujet` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verouilleSujet` tinyint(1) NOT NULL DEFAULT '0',
  `visiteur_id` int NOT NULL,
  `categorie_id` int NOT NULL,
  PRIMARY KEY (`id_sujet`),
  KEY `sujet_fk1` (`visiteur_id`),
  KEY `sujet_fk2` (`categorie_id`),
  CONSTRAINT `sujet_fk1` FOREIGN KEY (`visiteur_id`) REFERENCES `visiteur` (`id_visiteur`),
  CONSTRAINT `sujet_fk2` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.sujet : ~3 rows (environ)
INSERT INTO `sujet` (`id_sujet`, `titreSujet`, `dateCreationSujet`, `verouilleSujet`, `visiteur_id`, `categorie_id`) VALUES
	(5, 'test', '2023-08-30 16:36:15', 1, 3, 1),
	(6, 'Autre test', '2023-08-30 16:44:25', 0, 3, 1),
	(9, 'Une autre catégorie !', '2023-08-30 16:46:14', 0, 3, 2);

-- Listage de la structure de table forum. visiteur
CREATE TABLE IF NOT EXISTS `visiteur` (
  `id_visiteur` int NOT NULL AUTO_INCREMENT,
  `pseudoVisiteur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mdpVisiteur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateInscriptionVisiteur` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emailVisiteur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `roleVisiteur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ROLE_MEMBER',
  PRIMARY KEY (`id_visiteur`) USING BTREE,
  UNIQUE KEY `pseudoVisiteur` (`pseudoVisiteur`),
  UNIQUE KEY `emailVisiteur` (`emailVisiteur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.visiteur : ~2 rows (environ)
INSERT INTO `visiteur` (`id_visiteur`, `pseudoVisiteur`, `mdpVisiteur`, `dateInscriptionVisiteur`, `emailVisiteur`, `roleVisiteur`) VALUES
	(3, 'Cedric', '$2y$10$0wFOMcDZPiuoPpUcKRGbP.w25ArEZSndE9vuGiX23bA.wyDL72a86', '2023-08-30 16:17:38', 'cedric.falda@gmail.com', 'Membre'),
	(4, 'Aliev', '$2y$10$9iKWfSdOxCKSPlwMGS4pLu4RnRXGIs1ttwKinRqWdT0LRKlI/eeMG', '2023-08-30 16:46:50', 'aliev@jesaispas.com', 'ROLE_MEMBER');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
