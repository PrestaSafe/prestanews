<?php
class DetailsNewsSingleController extends FrontController{
	public function __construct(){
		//$this->php_self = 'modules/plblog/frontent/details.php';
		// if (Configuration::get("PS_REWRITING_SETTINGS") == 1)
		// 	$this->php_self = "blog/".Tools::getValue('plcn').'/'.Tools::getValue('plidp').'-'.Tools::getValue('plpn').".html";
		parent::__construct();
	}
	
	public function displayContent()
	{
		parent::displayContent();
		
		$this->detailsNews();
	}
	function detailsNews(){
		global $smarty;
		
		$id 	= Tools::getValue('id');
		

		$ps_shop_url = __PS_BASE_URI__;
		
		if(!isset($id) OR empty($id))
			Tools::redirectLink($ps_shop_url);

		$news 	= NewsModel::getNewsById($id);
		$this->context->smarty->assign('news',$news);
		
		if(_PS_VERSION_ >= 1.6)
			$smarty->display(_PS_MODULE_DIR_.'prestanews/views/templates/front/single-16.tpl');
		else
			$smarty->display(_PS_MODULE_DIR_.'prestanews/views/templates/front/single-16.tpl');
	}
}
