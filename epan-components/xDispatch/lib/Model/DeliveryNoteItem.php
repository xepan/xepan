<?php

namespace xDispatch;

class Model_DeliveryNoteItem extends \Model_Document{
	public $table="xdispatch_delivery_note_items";
	public $status=array();
	public $root_document_name='xDispatch\DeliveryNoteItem';

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/OrderDetails','orderitem_id')->sortable(true);
		$this->hasOne('xDispatch/DeliveryNote','delivery_note_id');
		$this->addField('qty');
		$this->addField('unit');

		$this->addHook('beforeDelete',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		// throw new \Exception("Error Processing Request", 1);
		
	}
	
}