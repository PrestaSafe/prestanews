<?php
class NewsModel extends ObjectModel
{
 	/** @var string Name */
 	public $id_news;
	public $title;
	public $txt;
	
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'news',
		'primary' => 'id_news',
		'multilang' => true,
		'fields' => array(
			// Lang fields
			'id_news' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'title' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 200),
			'txt' => 		array('type' => self::TYPE_HTML,'lang' => true, 'validate' => 'isCleanHtml'),
		),
	);

	function getAllNews(){
		global $cookie;
		$id_lang = $cookie->id_lang;
		$sql 	= "SELECT * FROM "._DB_PREFIX_."news AS n, "._DB_PREFIX_."news_lang AS nl WHERE n.id_news = nl.id_news AND nl.id_lang = $id_lang " ;
		$db 	= Db::getInstance();
		$array 	= $db->executeS($sql);
	
		return $array;
	}
	static function getNewsById($id_news = null){
		global $cookie;
		$id_lang = ($cookie->id_lang != null) ? $cookie->id_lang : Configuration::get("PS_LANG_DEFAULT");

		$sql 	= "SELECT * FROM "._DB_PREFIX_."news AS n, "._DB_PREFIX_."news_lang AS nl WHERE n.id_news = nl.id_news AND nl.id_lang = $id_lang AND n.id_news = $id_news " ;
		$exec	= Db::getInstance()->getRow($sql);
		if($exec)
			return $exec;
		else
			Tools::redirectLink(__PS_BASE_URI__);
	}
}