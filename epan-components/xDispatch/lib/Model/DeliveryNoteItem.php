<?php

namespace xDispatch;

class Model_DeliveryNoteItem extends \Model_Document{
	public $table="xdispatch_delivery_note_items";
	public $status=array();
	public $root_document_name='xDispatch\DeliveryNoteItem';

	function init(){
		parent::init();

		$this->hasOne('xShop/OrderDetails','orderitem_id')->sortable(true);
		$this->hasOne('xDispatch/DeliveyNote','delivery_note_id');
		$this->addField('qty');
		$this->addField('unit');

		//$this->add('dynamic_model/Controller_AutoCreator');

	}

	
}