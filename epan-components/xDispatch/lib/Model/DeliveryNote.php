<?php
namespace xDispatch;

class Model_DeliveryNote extends \xProduction\Model_JobCard {
	
	public $table = 'xdispatch_delivery_note';

	public $root_document_name='xDispatch\DeliveyNote';
	public $status = array('draft','submitted','approved','assigned','processing','processed','forwarded','complete','cancel','return','redesign','received');

	function init(){
		parent::init();

		$this->hasOne('xShop/Order','order_id');
		$this->hasOne('xShop/MemberDetails','to_memberdetails_id');
		$this->hasOne('xStore/Warehouse','warehouse_id');
		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:I:S'));
		$this->addField('shipping_address')->type('text');
		$this->addField('billing_address')->type('text');
		$this->addField('shipping_through')->type('text');
		$this->addField('narration')->type('text');
		$this->hasMany('xDispatch/DeliveryNoteItems','delivery_note_id');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function submit(){

	}

	function receive(){

	}
}
