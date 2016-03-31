<?php
class PrestanewsDefaultModuleFrontController extends ModuleFrontController{

	public function initContent() {
		parent::initContent(); 

	

	
		$model = new NewsModel();
		$news = $model->getAllNews();
		$this->context->smarty->assign('nb_news',Configuration::get('_NEWS_NUMBER_'));
		$this->context->smarty->assign('all_news', $news);
		if(_PS_VERSION_ >= 1.6)
			$this->setTemplate('list-news-16.tpl');
		else
			$this->setTemplate('list-news-15.tpl');
	}	
	
}