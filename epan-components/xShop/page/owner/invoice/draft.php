<?php
class page_xShop_page_owner_invoice_draft extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$invoice_draft = $this->add('xShop/Model_Invoice_Draft');
		
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
			$crud->setModel($invoice_draft);
			$crud->add('xHR/Controller_Acl');
		$this->add('xShop/View_Invoice',array('invoice'=>$this->add('xShop/Model_Invoice')->load(1)));
	}
}		