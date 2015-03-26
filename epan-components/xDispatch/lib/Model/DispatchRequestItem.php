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

		$this->hasOne('xDispatch/DeliveryNote','deliverynote_id'); // to know if this item is already dilivered
		$this->hasOne('xDispatch/DispatchRequest','dispatch_request_id');
		$this->hasOne('xShop/Item','item_id');
		
		$this->getElement('status')->defaultValue('to_receive');

		$this->addField('qty');
		$this->addField('unit');
		$this->addField('custom_fields');

		$this->add('dynamic_model/Controller_AutoCreator');

	}

	function item(){
		return $this->ref('item_id');
	}

	function isDelivered(){
		return $this['deliverynote_id'];
	}

	function receive(){
		parent::setStatus('received');
	}

}