<?php

	// Init
	$sql = array();
	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'news`;';	
	$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'news_lang`;';	