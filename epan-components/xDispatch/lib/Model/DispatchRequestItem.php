<?php

namespace xDispatch;

class Model_DispatchRequestItem extends \Model_Document{
	public $table="xdispatch_dispatch_request_items";
	public $status=array();
	public $root_document_name='xDispatch\DispatchRequestItem';

	function init(){
		parent::init();

		$this->hasOne('xDispatch/DispatchRequest','dispatch_request_id');
		$this->hasOne('xShop/Item','item_id');
		
		$this->addField('qty');
		$this->addField('unit');

		$this->add('dynamic_model/Controller_AutoCreator');

	}

	function item(){
		return $this->ref('item_id');
	}
}