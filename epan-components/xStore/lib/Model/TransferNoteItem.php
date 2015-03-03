<?php
namespace xStore;
class Model_TransferNoteItem extends \Model_Table{
	public $table="xstore_transfer_note_items";
	function init(){
		parent::init();

		$this->hasOne('xStore/TransferNote','transfer_note_id');
		$this->hasOne('xShop/Item','item_id');
		
		$this->addField('qty');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}