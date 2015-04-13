<?php

class page_xShop_page_owner_quotation_items extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$quotation_id=$this->api->stickyGET('xshop_quotation_id');
		
		$item_model = $this->add('xShop/Model_QuotationItem');
		$item_model->addCondition('quotation_id',$quotation_id);
		
		$item_crud=$this->add('CRUD');
		$item_crud->setModel($item_model,array('name','item_name','item_id','qty','rate','amount','custom_fields','narration','apply_tax'),array('name','item_name','item','qty','rate','amount','custom_fields','tax_per_sum','tax_amount','texted_amount'));
		$item_crud->add('xHR/Controller_Acl');
		$item_crud->add('xShop/Controller_getRate');

		if(!$item_crud->isEditing()){
			$g = $item_crud->grid;
			$g->removeColumn('name');
			$g->removeColumn('item');
			$g->removeColumn('custom_fields');
		}

	}
}