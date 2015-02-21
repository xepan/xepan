<?php

namespace xShop;

class Form_OrderItem extends \Form_Stacked {

	function recursiveRender(){
		$item_field = $this->getElement('item_id');
		$f= $item_field->other_field;
		$custom_fields_field = $this->getElement('custom_fields');
		$custom_fields_field->js(true)->hide();
		
		$btn = $item_field->other_field->belowField()->add('Button')->set('CustomFields');
		$btn->js('click',$this->js()->univ()->frameURL('Custome Field Values',array($this->api->url('xShop_page_owner_order_customfields',array('orderitem_id'=>$this->model->id,'custom_field_name'=>$this->getELement('custom_fields')->name)),"selected_item_id"=>$item_field->js()->val(),'current_json'=>$custom_fields_field->js()->val())));
		parent::recursiveRender();
	}
}