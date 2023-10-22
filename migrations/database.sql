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


-- Listage de la structure de la base pour simplifiedplifiedprojetjdr
CREATE DATABASE IF NOT EXISTS `simplifiedplifiedprojetjdr` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `simplifiedplifiedprojetjdr`;

-- Listage de la structure de table simplifiedplifiedprojetjdr. action
CREATE TABLE IF NOT EXISTS `action` (
  `id` int NOT NULL AUTO_INCREMENT,
  `personnage_id` int NOT NULL,
  `caracteristique_id` int DEFAULT NULL,
  `competence_id` int DEFAULT NULL,
  `objet_id` int DEFAULT NULL,
  `dice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dice_score` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_47CC8C925E315342` (`personnage_id`),
  KEY `IDX_47CC8C921704EEB7` (`caracteristique_id`),
  KEY `IDX_47CC8C9215761DAB` (`competence_id`),
  KEY `IDX_47CC8C92F520CF5A` (`objet_id`),
  CONSTRAINT `FK_47CC8C9215761DAB` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`),
  CONSTRAINT `FK_47CC8C921704EEB7` FOREIGN KEY (`caracteristique_id`) REFERENCES `caracteristique` (`id`),
  CONSTRAINT `FK_47CC8C925E315342` FOREIGN KEY (`personnage_id`) REFERENCES `perso` (`id`),
  CONSTRAINT `FK_47CC8C92F520CF5A` FOREIGN KEY (`objet_id`) REFERENCES `objet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.action : ~0 rows (environ)
INSERT INTO `action` (`id`, `personnage_id`, `caracteristique_id`, `competence_id`, `objet_id`, `dice`, `dice_score`) VALUES
	(1, 3, 1, NULL, NULL, '20', 10),
	(2, 3, 2, 4, 1, '20', 14);

-- Listage de la structure de table simplifiedplifiedprojetjdr. caracteristique
CREATE TABLE IF NOT EXISTS `caracteristique` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.caracteristique : ~6 rows (environ)
INSERT INTO `caracteristique` (`id`, `nom`) VALUES
	(1, 'force'),
	(2, 'intelligence'),
	(3, 'chance'),
	(4, 'agilité'),
	(5, 'dextérité'),
	(6, 'charisme');

-- Listage de la structure de table simplifiedplifiedprojetjdr. caracteristique_perso
CREATE TABLE IF NOT EXISTS `caracteristique_perso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `caracteristique_id` int NOT NULL,
  `perso_id` int NOT NULL,
  `valeur` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A3E653BF1704EEB7` (`caracteristique_id`),
  KEY `IDX_A3E653BF1221E019` (`perso_id`),
  CONSTRAINT `FK_A3E653BF1221E019` FOREIGN KEY (`perso_id`) REFERENCES `perso` (`id`),
  CONSTRAINT `FK_A3E653BF1704EEB7` FOREIGN KEY (`caracteristique_id`) REFERENCES `caracteristique` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.caracteristique_perso : ~14 rows (environ)
INSERT INTO `caracteristique_perso` (`id`, `caracteristique_id`, `perso_id`, `valeur`) VALUES
	(1, 6, 1, 1),
	(2, 2, 1, 2),
	(3, 1, 1, 4),
	(4, 3, 2, 2),
	(5, 5, 2, 1),
	(6, 6, 2, 4),
	(7, 3, 3, 2),
	(8, 6, 3, 4),
	(9, 2, 3, 7),
	(10, 4, 4, 2),
	(11, 6, 4, 1),
	(12, 2, 4, 1),
	(13, 5, 4, 1),
	(14, 1, 4, 2);

-- Listage de la structure de table simplifiedplifiedprojetjdr. commentaire
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `perso_id` int NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BCA76ED395` (`user_id`),
  KEY `IDX_67F068BC1221E019` (`perso_id`),
  CONSTRAINT `FK_67F068BC1221E019` FOREIGN KEY (`perso_id`) REFERENCES `perso` (`id`),
  CONSTRAINT `FK_67F068BCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.commentaire : ~6 rows (environ)
INSERT INTO `commentaire` (`id`, `user_id`, `perso_id`, `contenu`, `created_at`) VALUES
	(1, 3, 4, 'test', '2023-10-22 20:58:16'),
	(2, 1, 4, 'quoi?', '2023-10-22 22:59:17'),
	(3, 1, 2, 'test', '2023-10-22 23:00:09'),
	(4, 1, 3, 'le goat', '2023-10-22 23:00:22'),
	(5, 2, 3, 'lui même', '2023-10-22 23:00:49'),
	(6, 3, 1, 'test', '2023-10-22 23:01:10');

-- Listage de la structure de table simplifiedplifiedprojetjdr. competence
CREATE TABLE IF NOT EXISTS `competence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.competence : ~4 rows (environ)
INSERT INTO `competence` (`id`, `nom`) VALUES
	(1, 'nage'),
	(2, 'combat à main nu'),
	(3, 'vol'),
	(4, 'pyromancie');

-- Listage de la structure de table simplifiedplifiedprojetjdr. competence_influe_carac
CREATE TABLE IF NOT EXISTS `competence_influe_carac` (
  `id` int NOT NULL AUTO_INCREMENT,
  `competence_id` int DEFAULT NULL,
  `caracteristique_id` int DEFAULT NULL,
  `valeur_bonus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_56A3445E15761DAB` (`competence_id`),
  KEY `IDX_56A3445E1704EEB7` (`caracteristique_id`),
  CONSTRAINT `FK_56A3445E15761DAB` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`),
  CONSTRAINT `FK_56A3445E1704EEB7` FOREIGN KEY (`caracteristique_id`) REFERENCES `caracteristique` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.competence_influe_carac : ~4 rows (environ)
INSERT INTO `competence_influe_carac` (`id`, `competence_id`, `caracteristique_id`, `valeur_bonus`) VALUES
	(1, 2, 1, '1'),
	(2, 1, 5, '1'),
	(3, 4, 2, '1'),
	(4, 3, 5, '1');

-- Listage de la structure de table simplifiedplifiedprojetjdr. competence_perso
CREATE TABLE IF NOT EXISTS `competence_perso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `competence_id` int NOT NULL,
  `perso_id` int NOT NULL,
  `valeur` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3740ABC715761DAB` (`competence_id`),
  KEY `IDX_3740ABC71221E019` (`perso_id`),
  CONSTRAINT `FK_3740ABC71221E019` FOREIGN KEY (`perso_id`) REFERENCES `perso` (`id`),
  CONSTRAINT `FK_3740ABC715761DAB` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.competence_perso : ~0 rows (environ)
INSERT INTO `competence_perso` (`id`, `competence_id`, `perso_id`, `valeur`) VALUES
	(1, 1, 1, 2),
	(2, 2, 1, 1),
	(3, 1, 2, 2),
	(4, 4, 3, 2),
	(5, 2, 4, 1);

-- Listage de la structure de table simplifiedplifiedprojetjdr. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20231022183255', '2023-10-22 18:33:19', 7107);

-- Listage de la structure de table simplifiedplifiedprojetjdr. inventaire
CREATE TABLE IF NOT EXISTS `inventaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `objets_id` int NOT NULL,
  `persos_id` int NOT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_338920E06C3A2500` (`objets_id`),
  KEY `IDX_338920E083083405` (`persos_id`),
  CONSTRAINT `FK_338920E06C3A2500` FOREIGN KEY (`objets_id`) REFERENCES `objet` (`id`),
  CONSTRAINT `FK_338920E083083405` FOREIGN KEY (`persos_id`) REFERENCES `perso` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.inventaire : ~4 rows (environ)
INSERT INTO `inventaire` (`id`, `objets_id`, `persos_id`, `quantite`) VALUES
	(1, 3, 2, 1),
	(2, 2, 3, 1),
	(3, 1, 3, 1),
	(4, 3, 4, 1);

-- Listage de la structure de table simplifiedplifiedprojetjdr. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table simplifiedplifiedprojetjdr. objet
CREATE TABLE IF NOT EXISTS `objet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.objet : ~3 rows (environ)
INSERT INTO `objet` (`id`, `nom`, `valeur`) VALUES
	(1, 'baguette de feu', '2d6+2'),
	(2, 'épée en fer', '2d6'),
	(3, 'épée en bois', '1d6+1');

-- Listage de la structure de table simplifiedplifiedprojetjdr. perso
CREATE TABLE IF NOT EXISTS `perso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `espece` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origine` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sante` int NOT NULL,
  `sante_max` int DEFAULT NULL,
  `taille` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poids` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BD62FA21A76ED395` (`user_id`),
  CONSTRAINT `FK_BD62FA21A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.perso : ~0 rows (environ)
INSERT INTO `perso` (`id`, `user_id`, `nom`, `espece`, `origine`, `age`, `sante`, `sante_max`, `taille`, `poids`, `sex`) VALUES
	(1, 1, 'bobby', 'humain', 'terre', '34', 27, 34, '174 cm', '55 kg', 'homme'),
	(2, 1, 'bertrand', 'humain', 'terre', '29', 29, 29, '184 cm', '64 kg', 'homme'),
	(3, 2, 'gangloff', 'humain?', 'inconnu', 'vieux', 43, 54, '194 cm', '51 kg', 'homme'),
	(4, 3, 'simon', 'humain', 'charente', '21', 32, 34, '145 cm', '45 kg', 'homme');

-- Listage de la structure de table simplifiedplifiedprojetjdr. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.user : ~3 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`) VALUES
	(1, 'test@test.fr', '[]', '$2y$13$GEgiVr0mrC9uJI82.anP3um/UpJHbYtppwc2/hLPxusK2MVOrBFbq', 'bob'),
	(2, 'admin@test.fr', '["ROLE_ADMIN"]', '$2y$13$iMY/zHSSpshVlR4dP8FblunhDEIN21ZmAwNTZXGq872GbwIDBPRWe', 'admin'),
	(3, 'test2@test.fr', '[]', '$2y$13$/ErPin/AHYy9GAbEor9hHO/pWn3grq/YhrWeYcSytTIfdtXKmc5sK', 'joel');

-- Listage de la structure de table simplifiedplifiedprojetjdr. user_perso
CREATE TABLE IF NOT EXISTS `user_perso` (
  `user_id` int NOT NULL,
  `perso_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`perso_id`),
  KEY `IDX_5FA00179A76ED395` (`user_id`),
  KEY `IDX_5FA001791221E019` (`perso_id`),
  CONSTRAINT `FK_5FA001791221E019` FOREIGN KEY (`perso_id`) REFERENCES `perso` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_5FA00179A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table simplifiedplifiedprojetjdr.user_perso : ~0 rows (environ)
INSERT INTO `user_perso` (`user_id`, `perso_id`) VALUES
	(3, 3),
	(3, 4);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
