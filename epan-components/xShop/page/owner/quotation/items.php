<?php

class page_xShop_page_owner_quotation_items extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$quotation_id=$this->api->stickyGET('xshop_quotation_id');
		
		$item_model = $this->add('xShop/Model_QuotationItem');
		$item_model->addCondition('quotation_id',$quotation_id);
		
		$item_crud=$this->add('CRUD');
		$item_crud->setModel($item_model);
		$item_crud->add('xHR/Controller_Acl');

		if($item_crud->isEditing()){
			$item_field = $item_crud->form->getElement('item_id');
            $f= $item_field->other_field;
            $custom_fields_field = $item_crud->form->getElement('custom_fields');
            // $custom_fields_field->js(true)->hide();
            
            $btn = $item_field->other_field->belowField()->add('Button')->set('CustomFields');
            $btn->js('click',$this->js()->univ()->frameURL('Custome Field Values',array($this->api->url('xShop_page_owner_quotation_customfields',array('orderitem_id'=>$item_crud->id,'custom_field_name'=>$item_crud->form->getElement('custom_fields')->name)),"selected_item_id"=>$item_field->js()->val(),'current_json'=>$custom_fields_field->js()->val())));
		}



	}
}