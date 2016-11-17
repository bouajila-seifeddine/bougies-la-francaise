SET NAMES 'utf8';

CREATE TABLE IF NOT EXISTS `PREFIX_ganalytics` (
	`id_google_analytics` int(11) NOT NULL AUTO_INCREMENT,
	`id_order` int(11) NOT NULL,
	`id_customer` int(10) NOT NULL,
	`id_shop` int(11) NOT NULL,
	`sent` tinyint(1) DEFAULT NULL,
	`date_add` datetime DEFAULT NULL,
	PRIMARY KEY (`id_google_analytics`),
	KEY `id_order` (`id_order`),
	KEY `sent` (`sent`)
) ENGINE = ENGINE_TYPE DEFAULT CHARSET=utf8;

ALTER TABLE `PREFIX_ganalytics` ADD COLUMN IF NOT EXISTS (`id_shop` int(11) NOT NULL);

ALTER TABLE `PREFIX_customer` ADD COLUMN IF NOT EXISTS (`ga_context` varchar(64) DEFAULT '');

