<?php

namespace xShop;

class Form_OrderItem extends \Form_Stacked {

	function setModel($model,$fields=null){
		$m=parent::setModel($model,$fields);

		$this->onSubmit(function($form){
			$form->save();

			$depts = $form->add('xHR/Model_Department');
			$custome_fields_array  = json_decode($form['custom_fields'],true);

			foreach ($depts as $dept) {
				if(isset($custome_fields_array[$dept->id])){
					// associate with department
					$this->model->addToDepartment($dept);
				}else{
					// remove association with department
					$this->model->removeFromDepartment($dept);
				}
			}

			return true;

		});

		return $m;
	}

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