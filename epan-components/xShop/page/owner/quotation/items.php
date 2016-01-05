<?php

class page_xShop_page_owner_quotation_items extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$quotation_id=$this->api->stickyGET('xshop_quotation_id');
		
		$item_model = $this->add('xShop/Model_QuotationItem');
		$item_model->addCondition('quotation_id',$quotation_id);
		
		$item_crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_QuotationItem'));
		$item_crud->setModel($item_model,array('name','item_name','item_id','qty','rate','amount','custom_fields','narration','apply_tax','tax_id'),array());
		$item_crud->add('xHR/Controller_Acl');
		$item_crud->add('xShop/Controller_getRate');

	}
}