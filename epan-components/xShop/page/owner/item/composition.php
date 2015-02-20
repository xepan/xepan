<?php

class page_xShop_page_owner_item_composition extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$this->api->stickyGET('item_id');
		
		$itemcomposition=$this->add('xShop/Model_ItemComposition');
		$itemcomposition->addCondition('item_id',$_GET['item_id']);
		$crud=$this->add('CRUD');
		$crud->setModel($itemcomposition);
	}
}