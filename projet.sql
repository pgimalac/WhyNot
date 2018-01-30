-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `projet`;
CREATE DATABASE `projet` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `projet`;

DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `categorie` int(10) NOT NULL,
  `auteur` mediumint(10) unsigned NOT NULL,
  `titre` varchar(255) NOT NULL,
  `miniature` varchar(4) NOT NULL DEFAULT 'null',
  `contenu` mediumtext NOT NULL,
  `date_de_publication` datetime DEFAULT NULL,
  `etat` char(1) NOT NULL DEFAULT '0',
  `nb_lectures` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `categorie_titre` (`categorie`,`titre`),
  KEY `etat` (`etat`),
  KEY `auteur` (`auteur`),
  FULLTEXT KEY `contenu` (`contenu`),
  FULLTEXT KEY `titre` (`titre`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`categorie`) REFERENCES `categories` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `articles_ibfk_4` FOREIGN KEY (`auteur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

INSERT INTO `articles` (`id`, `categorie`, `auteur`, `titre`, `miniature`, `contenu`, `date_de_publication`, `etat`, `nb_lectures`) VALUES
(2,	1,	1,	'Le poème des anneaux',	'jpg',	'<p>Trois anneaux pour les rois Elfes sous le ciel,</p>\r\n<p>Sept pour les Seigneurs Nains dans leurs demeures de pierre,</p>\r\n<p>Neuf pour les Hommes Mortels destinés au trépas,</p>\r\n<p>Un pour le Seigneur Ténébreux sur son sombre trône,</p>\r\n<p>Dans le Pays de Mordor où s\'étendent les Ombres.</p>\r\n<p>Un anneau pour les gouverner tous. Un anneau pour les trouver,</p>\r\n<p>Un anneau pour les amener tous et dans les ténèbres les lier</p>\r\n<p>Au Pays de Mordor où s\'étendent les Ombres.</p>',	'2017-04-08 19:19:05',	'2',	243),
(3,	3,	1,	'Poème PI',	'null',	'Que j\'aime à faire apprendre un nombre utile aux sages!\r\nGlorieux Archimède, artiste ingénieux,\r\nToi qui, de Syracuse aime encore la gloire,\r\nSoit ton nom conservé par de savants grimoires !\r\nJadis, mystérieux, un problème bloquait\r\nTout l\'admirable procédé, l\'œuvre grandiose\r\nque Pythagore découvrit aux anciens grecs.\r\nO, quadrature ! vieux tourment du philosophe !\r\nInsoluble rondeur, trop longtemps vous avez\r\nDéfié Pythagore et ses imitateurs.\r\nComment intégrer l\'espace bien circulaire ?\r\nFormer un triangle auquel il équivaudra ?\r\nNouvelle invention : Archimède inscrira\r\nDedans un hexagone, appréciera son aire\r\nFonction du rayon. Pas trop ne s\'y tiendra\r\nDédoublera chaque élément antérieur ;\r\nToujours de l\'orbe calculée approchera ;\r\nDéfinira limite ; enfin, l\'arc, le limiteur\r\nDe cet inquiétant cercle, ennemi trop rebelle !\r\nProfesseur, enseignez son problème avec zèle !',	'2017-04-15 13:55:23',	'2',	39),
(4,	5,	1,	'Qu\'est-ce que la physique ?',	'null',	'La physique est la science qui tente de comprendre, de modéliser, voire d\'expliquer les phénomènes naturels de l\'univers. \r\nElle correspond à l\'étude du monde qui nous entoure sous toutes ses formes, des lois de sa variation et de son évolution.\r\n\r\nLa modélisation des systèmes peut laisser de côté les processus chimiques et biologiques ou les inclure. La physique développe des représentations du monde expérimentalement vérifiables dans un domaine de définition donné. \r\nElle produit donc plusieurs lectures du monde, chacune n\'étant considérée comme précise que jusqu\'à un certain point.',	'2017-04-15 14:01:58',	'2',	57),
(6,	1,	1,	'Chanson d\'automne',	'null',	'<p>Les sanglots longs</p>\r\n<p>Des violons</p>\r\n<p>De l\'automne</p>\r\n<p>Blessent mon coeur</p>\r\n<p>D\'une langueur</p>\r\n<p>Monotone.</p>\r\n<p></p>\r\n<p>Tout suffocant</p>\r\n<p>Et blême, quand</p>\r\n<p>Sonne l\'heure,</p>\r\n<p>Je me souviens</p>\r\n<p>Des jours anciens</p>\r\n<p>Et je pleure</p>\r\n\r\n<p>Et je m\'en vais</p>\r\n<p>Au vent mauvais</p>\r\n<p>Qui m\'emporte</p>\r\n<p>Deçà, delà,</p>\r\n<p>Pareil à la</p>\r\n<p>Feuille morte.</p>\r\n\r\n\r\n<cite>Paul VERLAINE</cite>',	'2017-05-05 12:41:07',	'2',	24),
(7,	1,	1,	'Demain, dès l\'aube',	'null',	'<p>Demain, d&egrave;s l&#39;aube, &agrave; l&#39;heure o&ugrave; blanchit la campagne,<br />\r\nJe partirai. Vois-tu, je sais que tu m&#39;attends.<br />\r\nJ&#39;irai par la for&ecirc;t, j&#39;irai par la montagne.<br />\r\nJe ne puis demeurer loin de toi plus longtemps.<br />\r\n<br />\r\nJe marcherai les yeux fix&eacute;s sur mes pens&eacute;es,<br />\r\nSans rien voir au dehors, sans entendre aucun bruit,<br />\r\nSeul, inconnu, le dos courb&eacute;, les mains crois&eacute;es,<br />\r\nTriste, et le jour pour moi sera comme la nuit.<br />\r\n<br />\r\nJe ne regarderai ni l&#39;or du soir qui tombe,<br />\r\nNi les voiles au loin descendant vers Harfleur,<br />\r\nEt quand j&#39;arriverai, je mettrai sur ta tombe<br />\r\nUn bouquet de houx vert et de bruy&egrave;re en fleur.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><em>Victor Hugo</em></p>\r\n',	'2017-05-07 20:52:52',	'1',	0),
(8,	1,	1,	'C\'est la mer noire ?',	'null',	'<p>40 secondes et on joue, c&#39;est parti, top : quelle mer communique avec l&#39;Atlantique par le d&eacute;troit de Gibraltar ?</p>\r\n\r\n<p>La mer du Nord ?</p>\r\n\r\n<p>Non, bah non ! Sous quel autre nom connait-on la mer des Cara&iuml;bes ?</p>\r\n\r\n<p>La mer ...</p>\r\n\r\n<p>Quelle mer ferm&eacute;e de l&#39;Asie occidentale est bord&eacute;e par la jordanie et par Isra&euml;l ?</p>\r\n\r\n<p>C&#39;est la mer noire.</p>\r\n\r\n<p>Non. Quelle mer faisant partie de l&#39;oc&eacute;an arctique borde la Sib&eacute;rie ?</p>\r\n\r\n<p>C&#39;est la mer noire, la mer ...</p>\r\n\r\n<p>Quelle mer situ&eacute;e entre l&#39;Arabie et l&#39;Afrique est reli&eacute;e &agrave; la m&eacute;diterran&eacute;e par le canal de Suez ?</p>\r\n\r\n<p>C&#39;est la mer noire ?</p>\r\n\r\n<p>Non. Au bord de quelle mer est situ&eacute;e la station baln&eacute;aire de Yalta ?</p>\r\n\r\n<p>C&#39;est la mer noire ?</p>\r\n\r\n<p>OUI !</p>\r\n',	'2017-05-14 13:50:34',	'0',	0)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `categorie` = VALUES(`categorie`), `auteur` = VALUES(`auteur`), `titre` = VALUES(`titre`), `miniature` = VALUES(`miniature`), `contenu` = VALUES(`contenu`), `date_de_publication` = VALUES(`date_de_publication`), `etat` = VALUES(`etat`), `nb_lectures` = VALUES(`nb_lectures`);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`id`, `nom`) VALUES
(1,	'Culture'),
(6,	'Histoire'),
(2,	'Jeux Vidéo'),
(3,	'Mathématiques'),
(5,	'Physique'),
(4,	'Programmation')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `nom` = VALUES(`nom`);

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE `commentaires` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auteur` mediumint(10) unsigned NOT NULL,
  `article` int(5) NOT NULL,
  `contenu` tinytext NOT NULL,
  `date_de_publication` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auteur` (`auteur`),
  KEY `article` (`article`),
  FULLTEXT KEY `contenu` (`contenu`),
  CONSTRAINT `commentaires_ibfk_5` FOREIGN KEY (`auteur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `commentaires_ibfk_6` FOREIGN KEY (`article`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO `commentaires` (`id`, `auteur`, `article`, `contenu`, `date_de_publication`) VALUES
(1,	6,	2,	'Le Seigneur des Anneaux c\'est vraiment la base, j\'adore !',	'2017-04-20 00:32:08'),
(9,	1,	3,	'Très pratique !',	'2017-04-20 18:26:30'),
(11,	1,	6,	'Magnifique !',	'2017-05-11 20:47:49')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `auteur` = VALUES(`auteur`), `article` = VALUES(`article`), `contenu` = VALUES(`contenu`), `date_de_publication` = VALUES(`date_de_publication`);

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auteur` mediumint(10) unsigned NOT NULL,
  `destinataire` mediumint(10) unsigned NOT NULL,
  `contenu` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `nLu` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `destinataire` (`destinataire`),
  KEY `auteur` (`auteur`),
  CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`destinataire`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_ibfk_4` FOREIGN KEY (`auteur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

INSERT INTO `messages` (`id`, `auteur`, `destinataire`, `contenu`, `date`, `nLu`) VALUES
(1,	1,	7,	'Bonjour !',	'2017-05-09 19:50:14',	0),
(2,	7,	1,	'Slt mdr',	'2017-05-09 19:50:37',	0),
(3,	1,	7,	'Tu ne sais ni écrire ni compter mon pauvre null...',	'2017-05-09 19:51:01',	0),
(4,	1,	6,	'truc',	'2017-05-09 20:32:20',	0),
(5,	6,	1,	'machin',	'2017-05-09 20:32:36',	0),
(6,	1,	7,	'alors ?',	'2017-05-11 01:34:08',	0),
(7,	1,	7,	'.',	'2017-05-11 01:36:07',	0),
(8,	1,	7,	'truc',	'2017-05-11 01:36:11',	0),
(9,	1,	7,	'machin',	'2017-05-11 01:36:15',	0),
(10,	1,	7,	'bidule',	'2017-05-11 01:36:19',	0),
(11,	1,	7,	'spam',	'2017-05-11 01:36:25',	0),
(12,	1,	7,	'spam',	'2017-05-11 01:36:29',	0),
(13,	1,	7,	'spam !',	'2017-05-11 01:36:34',	0),
(14,	1,	7,	'blablabla trop bien ça marche',	'2017-05-11 02:50:47',	0)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `auteur` = VALUES(`auteur`), `destinataire` = VALUES(`destinataire`), `contenu` = VALUES(`contenu`), `date` = VALUES(`date`), `nLu` = VALUES(`nLu`);

DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `utilisateur` mediumint(10) unsigned NOT NULL,
  `article` int(10) NOT NULL,
  `note` tinyint(4) NOT NULL,
  UNIQUE KEY `utilisateur_article` (`utilisateur`,`article`),
  KEY `article` (`article`),
  CONSTRAINT `notes_ibfk_4` FOREIGN KEY (`utilisateur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notes_ibfk_5` FOREIGN KEY (`article`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `notes` (`utilisateur`, `article`, `note`) VALUES
(1,	2,	20),
(1,	3,	14),
(1,	4,	7),
(1,	6,	18)
ON DUPLICATE KEY UPDATE `utilisateur` = VALUES(`utilisateur`), `article` = VALUES(`article`), `note` = VALUES(`note`);

DROP TABLE IF EXISTS `personnes_connectees`;
CREATE TABLE `personnes_connectees` (
  `adresse_ip` varchar(15) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `connecte` char(4) NOT NULL,
  `id` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`adresse_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `personnes_connectees` (`adresse_ip`, `timestamp`, `connecte`, `id`) VALUES
('127.0.0.1',	'2017-05-14 14:09:13',	'vrai',	16)
ON DUPLICATE KEY UPDATE `adresse_ip` = VALUES(`adresse_ip`), `timestamp` = VALUES(`timestamp`), `connecte` = VALUES(`connecte`), `id` = VALUES(`id`);

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE `utilisateurs` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mdp` char(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(4) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `master` char(4) NOT NULL,
  `inscription` date DEFAULT NULL,
  `connexion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

INSERT INTO `utilisateurs` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `mail`, `description`, `image`, `site`, `master`, `inscription`, `connexion`) VALUES
(1,	'master',	'OzugIJ9f38aX.lIVQ1P5xHpT2HNr9xha',	'Gimalac',	'Pierre',	'pierre.gimalac@gmail.com',	'',	'jpg',	'',	'vrai',	'2017-03-28',	'2017-05-14 13:54:03'),
(6,	'florefloreflore',	'.rtI/Xrnm7U6Em6wg/cbNUZWVRt6cpqS',	'Giarrizzo',	'Flore',	'exemple@gmail.com',	'',	'null',	'',	'faux',	'2017-04-07',	NULL),
(7,	'null',	'eAl2QKAbolvrHeC.NArBS1H6puxUgUT6',	'Xu',	'Stéphane',	'xu_stephane@hotmail.fr',	'',	'jpeg',	'',	'vrai',	'2017-04-18',	'2017-04-25 14:10:52'),
(16,	'Exemple',	'.AcH4Uzn4nRkm.PBuWDT/PUq2p6mCRhy',	'Exemple',	'Exemple',	'truc@gmail.com',	'',	'null',	'',	'vrai',	'2017-05-14',	'2017-05-14 13:39:20')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `pseudo` = VALUES(`pseudo`), `mdp` = VALUES(`mdp`), `nom` = VALUES(`nom`), `prenom` = VALUES(`prenom`), `mail` = VALUES(`mail`), `description` = VALUES(`description`), `image` = VALUES(`image`), `site` = VALUES(`site`), `master` = VALUES(`master`), `inscription` = VALUES(`inscription`), `connexion` = VALUES(`connexion`);

-- 2017-05-14 14:11:15
