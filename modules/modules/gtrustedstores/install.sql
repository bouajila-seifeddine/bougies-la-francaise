CREATE TABLE IF NOT EXISTS `PREFIX_gts_processed_orders` (`id_order` int(11) NOT NULL, `id_shop` int(11) NOT NULL DEFAULT "1", `date_add` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;