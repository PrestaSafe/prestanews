<?php
class PrestanewsSingleModuleFrontController extends ModuleFrontController{

	public function initContent() {
		parent::initContent(); 
		$this->detailsNews();
	}	

	function detailsNews(){
		$id = (int)Tools::getValue('id');
		$news = NewsModel::getNewsById($id);

		
		$this->context->smarty->assign('news',$news);
		$this->setTemplate('single.tpl');
	}
}
