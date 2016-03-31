<?php

	// Init
	$sql = array();

	// Create Table in Database

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'news` (
  `id_news` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_news`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';




$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'news_lang` (
  `id_news` int(10) NOT NULL ,
  `id_lang` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `txt` text NOT NULL,
  UNIQUE KEY `news_lang_lang_index` (`id_news`,`id_lang`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';