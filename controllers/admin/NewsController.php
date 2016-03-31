<?php
class NewsController extends ModuleAdminController{

	public function __construct()
	{
		$this->table = 'news';
		$this->className = 'NewsModel';
		$this->lang = true;
		$this->deleted = false;
		$this->colorOnBackground = false;
		$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));
		$this->context = Context::getContext();
		
		if(_PS_VERSION_ >= 1.6)
			$this->bootstrap = true;			
		
		parent::__construct();

	}

/**
	 * Function used to render the list to display for this controller
	 */
	public function renderList()
	{
		$this->addRowAction('edit');
		$this->addRowAction('delete');
		//$this->addRowAction('details');
		
		$this->bulk_actions = array(
			'delete' => array(
				'text' => $this->l('Delete selected'),
				'confirm' => $this->l('Delete selected items?')
				)
			);
		
		$this->fields_list = array(
			'id_news' => array(
				'title' => $this->l('ID'),
				'align' => 'center',
				'width' => 25
			),
			'title' => array(
				'title' => $this->l('title'),
				'width' => 'auto',
			),

		);
		
		
		$lists = parent::renderList();
		
		$this->initToolbar();
		
		return $lists;




	}

	public function renderForm()
	{
		$this->fields_form = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->l('News'),
				'image' => '../img/admin/edit.gif'
			),
			'input' => array(
				array(
					'type' => 'text',
					'lang' => true,
					'label' => $this->l('Title:'),
					'name' => 'title',
					'size' => 40
				),
				
				array(
					'type' => 'textarea',
					'lang' => true,
					'label' => $this->l('Contenu:'),
					'name' => 'txt',
					'autoload_rte' => true,
					
				)
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);

		if (!($obj = $this->loadObject(true)))
			return;
	

		$this->initToolbar();
		return parent::renderForm();
	}

	public function initToolbar(){
		parent::initToolbar();
		if ($this->display == 'edit' || $this->display == 'add')
		{
			$this->toolbar_btn['save'] = array(
				'short' => 'Save',
				'href' => '#',
				'desc' => $this->l('Save'),
			);

			$this->toolbar_btn['save-and-stay'] = array(
				'short' => 'SaveAndStay',
				'href' => '#',
				'desc' => $this->l('Save and stay'),
			);

			// adding button for adding a new combination in Combination tab
			
		}
		
		
		$this->context->smarty->assign('toolbar_scroll', 1);
		$this->context->smarty->assign('show_toolbar', 1);
		$this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);


	}




}

?>