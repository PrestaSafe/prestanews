<?php
/**
 * Module Example - Main file
 *
 * @category   	Module / documentation
 * @author     	Guillaume Batier
 * @copyright  	2013-2014 web-batier.com
 * @version   	1.6.0.5
 * @link       	http://www.web-batier.com/
 * @since      	File available since Release 1.2
*/


// Security
if (!defined('_PS_VERSION_'))
	exit;


if (!defined('_MYSQL_ENGINE_'))
	define('_MYSQL_ENGINE_', 'MyISAM');

// Loading Models
require_once(_PS_MODULE_DIR_ .'prestanews/models/NewsModel.php');


class Prestanews extends Module
{

  public function __construct(){
	$this->author 							= 'Guillaume batier -> web-batier.com ';
	$this->name 							= 'prestanews';
	$this->tab 								= 'front_office_featured';
	$this->version 							= '1.5';
	$this->ps_versions_compliancy['min'] 	= '1.5';
	$this->bootstrap = true;
  $this->display = 'view';
  $this->meta_title = $this->l('Your Merchant Expertise');
	$this->need_instance 					= 0;
	$this->dependencies 					= array();


	parent::__construct();

	$this->displayName 						= $this->l('Actualities block');
	$this->description 						= $this->l('Add some actualities on your shop !');

  }

	public function install()
	{
		// Install SQL
		include(dirname(__FILE__).'/sql/install.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;

		// Install Tabs
		$parent_tab = new Tab();
        $lang = ($this->context->language->id) ? $this->context->language->id : _PS_LANG_DEFAULT_ ;

		// Need a foreach for the language
		$parent_tab->name[$lang] = $this->l('News');
		$parent_tab->class_name = 'NewsMain';
		$parent_tab->id_parent = 0; // Home tab
		$parent_tab->module = $this->name;
		$parent_tab->add();


		$tab = new Tab();
		// Need a foreach for the language
		$tab->name[$lang] = $this->l('Your actualities');
		$tab->class_name = 'News';
		$tab->id_parent = $parent_tab->id;
		$tab->module = $this->name;
		$tab->add();





   	return parent::install()
		&& $this->registerHook('displayLeftColumn')  && $this->registerHook('displayHeader')  && $this->registerHook('displayBackofficeHeader') && Configuration::updateValue('_NEWS_NUMBER_', 5 );
  }

  public function uninstall()
	{
		// Uninstall SQL
		include(dirname(__FILE__).'/sql/uninstall.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;
		// Uninstall Tabs
		$tab = new Tab((int)Tab::getIdFromClassName('News'));
		$tab->delete();
		$tabMain = new Tab((int)Tab::getIdFromClassName('NewsMain'));
		$tabMain->delete();

		// Uninstall Module
		if (!parent::uninstall())
			return false;



		return true;
	}

public function postProcess(){
	$output = '';
	if(Tools::isSubmit('submitprestanews')){
		if($this->updateConfiguration())
			$output .= $this->displayConfirmation($this->l('Settings updated'));
		else
			$output .= $this->displayError($this->l('Error while updating value'));

		return $output;
	}
}

public function updateConfiguration(){
	$number = (int)$_POST['_NEWS_NUMBER_'];
	return Configuration::updateValue('_NEWS_NUMBER_',$number);
}

public function getContent(){

		return $this->postProcess().$this->displayForm();
	}

public function displayForm()
{
    // Get default Language
    $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

    // Init Fields form array
    $fields_form[0]['form'] = array(
        'legend' => array(
            'title' => $this->l('Settings'),
        ),
        'input' => array(
            array(
                'type' => 'text',
                'label' => $this->l('News number on columns'),
                'name' => '_NEWS_NUMBER_',
                'size' => 20,
                'required' => true
            )
        ),
        'submit' => array(
            'title' => $this->l('Save'),
            'class' => 'button'
        )
    );

    $helper = new HelperForm();

    // Module, token and currentIndex
    $helper->module = $this;
    $helper->name_controller = $this->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

    // Language
    $helper->default_form_language = $default_lang;
    $helper->allow_employee_form_lang = $default_lang;

    // Title and toolbar
    $helper->title = $this->displayName;
    $helper->show_toolbar = true;        // false -> remove toolbar
    $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
    $helper->submit_action = 'submit'.$this->name;
    $helper->toolbar_btn = array(
        'save' =>
        array(
            'desc' => $this->l('Save'),
            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
            '&token='.Tools::getAdminTokenLite('AdminModules'),

        ),
        'back' => array(
            'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Back to list')
        )
    );

    // Load current value
    $helper->fields_value['_NEWS_NUMBER_'] = Configuration::get('_NEWS_NUMBER_');

    return $helper->generateForm($fields_form);
}


function getAllNews(){
	global $cookie;
	$id_lang = $cookie->id_lang;
	$sql 	= "SELECT * FROM "._DB_PREFIX_."news AS n, "._DB_PREFIX_."news_lang AS nl WHERE n.id_news = nl.id_news AND nl.id_lang = $id_lang ORDER BY n.id_news DESC" ;
	$db 	= Db::getInstance();
	$array 	= $db->executeS($sql);

	return $array;
}
function getNewsByLimit(){
	global $cookie;
	$limit = Configuration::get('_NEWS_NUMBER_');
	$id_lang = $cookie->id_lang;
	$sql 	= "SELECT * FROM "._DB_PREFIX_."news AS n, "._DB_PREFIX_."news_lang AS nl WHERE n.id_news = nl.id_news AND nl.id_lang = $id_lang ORDER BY n.id_news DESC LIMIT 0,$limit" ;
	$db 	= Db::getInstance();
	$array 	= $db->executeS($sql);

	return $array;
}
## HOOKS
public function hookdisplayBackOfficeHeader(){

	if(_PS_VERSION_ >= 1.6)
     	$this->context->controller->addCSS($this->_path.'css/admin-theme.css', 'all');

}


public function hookdisplayHeader(){
        $this->context->controller->addCSS(($this->_path).'css/styles.css', 'all');
}

function hookdisplayRightColumn(){
	global $smarty,$link;



	$this->context->smarty->assign('news', $this->getNewsByLimit() ) ;
	if(_PS_VERSION_ >= 1.6)
		return $this->display(__FILE__, 'views/templates/front/right_column-16.tpl');
	else
		return $this->display(__FILE__, 'views/templates/front/right_column-15.tpl');


}
function hookdisplayLeftColumn(){
	return $this->hookdisplayRightColumn();
}


}
