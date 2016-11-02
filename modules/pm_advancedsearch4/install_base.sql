CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch` (
  `id_search` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_hook` int(10) unsigned NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `internal_name` varchar(255) NOT NULL,
  `height` smallint(4) unsigned NOT NULL DEFAULT '0',
  `width` smallint(4) unsigned NOT NULL DEFAULT '0',
  `display_nb_result_on_blc` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `display_nb_result_criterion` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `save_selection` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `remind_selection` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `show_hide_crit_method` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `filter_by_emplacement` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `search_on_stock` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hide_empty_crit_group` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `search_method` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `dynamic_criterion` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `step_search` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `priority_on_combination_image` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `use_cache` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `products_per_page` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `products_order_by` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `products_order_way` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `background_color` varchar(15) NULL,
  `border_color` varchar(7) NULL,
  `border_size` varchar(24) NULL,
  `color_group_title` varchar(7) NULL,
  `font_size_group_title` smallint(4) unsigned NULL DEFAULT '0',
  `border_radius` smallint(4) unsigned NULL DEFAULT '0',
  `color_title` varchar(7) NULL,
  `font_size_title` smallint(4) unsigned NULL DEFAULT '0',
  PRIMARY KEY (`id_search`),
  KEY `id_hook` (`id_hook`),
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_lang` (
  `id_search` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `id_search` (`id_search`,`id_lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_shop` (
  `id_search` int(11) NOT NULL,
  `id_shop` int(11) NOT NULL,
  PRIMARY KEY (`id_search`,`id_shop`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_category` (
  `id_search` int(10) unsigned NOT NULL,
  `id_category` int(10) unsigned NOT NULL,
  PRIMARY KEY `id_search` (`id_search`,`id_category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_cms` (
  `id_search` int(10) unsigned NOT NULL,
  `id_cms` int(10) unsigned NOT NULL,
  PRIMARY KEY `id_search` (`id_search`,`id_cms`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_products` (
  `id_search` int(10) unsigned NOT NULL,
  `id_product` int(10) unsigned NOT NULL,
  PRIMARY KEY `id_search` (`id_search`,`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_manufacturers` (
  `id_search` int(10) unsigned NOT NULL,
  `id_manufacturer` int(10) unsigned NOT NULL,
  PRIMARY KEY `id_search` (`id_search`,`id_manufacturer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_suppliers` (
  `id_search` int(10) unsigned NOT NULL,
  `id_supplier` int(10) unsigned NOT NULL,
  PRIMARY KEY `id_search` (`id_search`,`id_supplier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_special_pages` (
  `id_search` int(10) unsigned NOT NULL,
  `page` varchar(255) NOT NULL,
  PRIMARY KEY `id_search` (`id_search`,`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_seo` (
  `id_seo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_search` int(10) unsigned NOT NULL,
  `id_currency` int(10) unsigned NOT NULL,
  `criteria` varchar(255) NOT NULL,
  `seo_key` varchar(32) NOT NULL,
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_seo`),
  KEY `id_search` (`id_search`),
  KEY `deleted` (`deleted`),
  UNIQUE KEY `seo_key` (`seo_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_seo_lang` (
  `id_seo` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `meta_title` varchar(128) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `seo_url` varchar(128) NOT NULL,
  UNIQUE KEY `id_seo` (`id_seo`,`id_lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pm_advancedsearch_seo_crosslinks` (
  `id_seo` int(10) unsigned NOT NULL,
  `id_seo_linked` int(10) unsigned NOT NULL,
  UNIQUE KEY `id_seo` (`id_seo`,`id_seo_linked`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;