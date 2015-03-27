<?php
namespace xDispatch;

class Model_DeliveryNote extends \xProduction\Model_JobCard {
	
	public $table = 'xdispatch_delivery_note';

	public $root_document_name='xDispatch\DeliveyNote';
	public $status = array('draft','submitted','approved','assigned','processing','processed','forwarded','completed','cancelled','return','redesign','received');

	function init(){
		parent::init();

		$this->hasOne('xShop/Order','order_id');
		$this->hasOne('xShop/MemberDetails','to_memberdetails_id');
		$this->hasOne('xStore/Warehouse','warehouse_id');
		$this->addField('shipping_address')->type('text');
		$this->addField('billing_address')->type('text');
		$this->addField('shipping_through')->type('text');
		$this->addField('narration')->type('text');
		$this->hasMany('xDispatch/DeliveryNoteItems','delivery_note_id');

	//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function create($order,$from_warehouse,$shipping_address,$shipping_via,$docket_no,$narration,$items_array){

	}

	function addItem($orderitem, $item,$qty,$unit,$custom_fields){
		$mr_item = $this->ref('xDispatch/DeliveryNoteItems');
		$mr_item['orderitem_id'] = $orderitem->id;
		$mr_item['item_id'] = $item->id;
		$mr_item['qty'] = $qty;
		$mr_item['unit'] = $unit;
		$mr_item['custom_fields'] = $custom_fields;
		$mr_item->save();

		$orderitem['deliverynote_id'] = $this->id;
		$orderitem->save();
	}

	function submit(){

	}

	function receive(){

	}
}
