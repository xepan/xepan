<?php

namespace xDispatch;

class Model_DispatchRequestItem extends \Model_Document{
	public $table="xdispatch_dispatch_request_items";
	public $status=array('to_receive','received','delivered');
	public $root_document_name='xDispatch\DispatchRequestItem';

	public $actions=array(
		'can_receive'=>array()
		);

	function init(){
		parent::init();

		$this->hasOne('xShop/OrderDetails','orderitem_id')->sortable(true);
		$this->hasOne('xDispatch/DeliveryNote','deliverynote_id'); // to know if this item is already dilivered
		$this->hasOne('xDispatch/DispatchRequest','dispatch_request_id');
		$this->hasOne('xShop/Item','item_id');
		
		$this->getElement('status')->defaultValue('to_receive');

		$this->addField('qty');
		$this->addField('unit');
		$this->addField('custom_fields');

		$this->addExpression('item_with_qty_fields',"custom_fields");

		$this->addHook('afterLoad',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');

	}

	function afterLoad(){
		if($this['custom_fields']){
			$cf_array=json_decode($this['custom_fields'],true);
			$qty_json = json_encode(array('stockeffectcustomfield'=>$cf_array['stockeffectcustomfield']));
			$this['item_with_qty_fields'] = $this['item'] .' [' .$this->item()->genericRedableCustomFieldAndValue($this['custom_fields']) .']';
		}
	}

	function item(){
		return $this->ref('item_id');
	}

	function isDelivered(){
		return $this['deliverynote_id'];
	}

	function orderItem(){
		return $this->ref('orderitem_id');
	}

	function receive_page($page){
		$form = $page->add('Form_Stacked');	
		$form->addField('line','model')->set($this->model->id)
		$form->addField('checkbox','receive_material_request');
		$form->addSubmit('receive');
		if($form->isSubmitted()){
			if($form['receive_material_request']){
				$doc = $this->add('Model_Document');
				$dc->loadWhoseRelatedDocIs($this);
			}
			$this->receive();
		}
	}

	function receive(){		
		$this->ref('dispatch_request_id')->receive();
		parent::setStatus('received');
	}

}