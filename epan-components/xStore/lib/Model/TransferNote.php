<?php

namespace xStore;
class Model_TransferNote extends \Model_Document{
	public $table="xstore_transfer_notes";
	public $status = null;
	public $root_document_name="xStore\TransferNote";
	function init(){
		parent::init();

		$this->hasOne('xHR/Department','to_department_id');
		$this->hasOne('Document','related_document_id');
		$this->hasOne('xStore/MaterialRequest','material_request_id');
		$this->hasOne('xShop/Order','order_id');

		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));

		$this->hasMany('xStore/TransferNoteItem','transfer_note_id');

		$this->add('dynamic_model/Controller_AutoCreator');	
	}
}