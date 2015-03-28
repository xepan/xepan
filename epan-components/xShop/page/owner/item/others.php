<?php

class page_xShop_page_owner_item_others extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		
		if(!$_GET['item_id'])
			return;
		
		$this->api->stickyGET('item_id');
		$selected_item_model = $this->add('xShop/Model_Item')->load($_GET['item_id']);		
		if(!$selected_item_model->loaded())
			return;
		
		$form = $this->add('Form_Stacked');
		$form->setModel($selected_item_model,array('terms_condition'));
		$form->addSubmit()->set('Update');

		$form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){	
			$form->update();
			$form->js()->univ()->successMessage('Updtaed')->execute();
		}


	}
}