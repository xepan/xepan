<?php
namespace xDispatch;

class Model_DeliveryNote extends \xProduction\Model_JobCard {
	
	public $table = 'xdispatch_delivery_note';

	public $root_document_name='xDispatch\DeliveyNote';
	public $status = array('submitted','processed','completed','cancelled','return','received');

	function init(){
		parent::init();

		$this->getElement('status')->defaultValue('completed');

		$this->hasOne('xShop/Order','order_id');
		$this->hasOne('xShop/MemberDetails','to_memberdetails_id');
		$this->hasOne('xStore/Warehouse','warehouse_id');
		$this->addField('shipping_address')->type('text');
		$this->addField('shipping_via')->type('text');
		$this->addField('docket_no');
		$this->addField('narration')->type('text');
		$this->hasMany('xDispatch/DeliveryNoteItem','delivery_note_id');

		$this->addHook('beforeDelete',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		$this->ref('xDispatch/DeliveryNoteItem')->each(function($m){
			$m->delete();
		});
	}

	function create($order,$from_warehouse,$shipping_address,$shipping_via,$docket_no,$narration,$items_array=array(),$status=null){
		$this['order_id'] = $order->id;
		$this['to_memberdetails_id'] = $order->customer()->get('id');
		$this['warehouse_id'] = $from_warehouse->id;
		$this['shipping_address'] = $shipping_address;
		$this['shipping_via'] = $shipping_via;
		$this['docket_no'] = $docket_no;
		$this['narration'] = $narration;
		$this['status'] = $status?:'completed';
		$this->save();
		foreach ($items_array as $item) {
			$this->addItem($item['orderitem'],$item['item'],$item['qty'],$item['unit'],$item['custom_fields']);
		}
	}

	function addItem($orderitem, $item,$qty,$unit,$custom_fields,$dispatch_req_item_model=null){
		$mr_item = $this->ref('xDispatch/DeliveryNoteItem');
		$mr_item['orderitem_id'] = $orderitem->id;
		$mr_item['item_id'] = $item->id;
		$mr_item['qty'] = $qty;
		$mr_item['unit'] = $unit;
		$mr_item['custom_fields'] = $custom_fields;
		$mr_item->save();

		if($dispatch_req_item_model){
			$dri = $this->add('xDispatch/Model_DispatchRequestItem')->load($dispatch_req_item_model->id);
			$dri['deliverynote_id'] = $mr_item->id;
			$dri->save();
		}
	}

	function submit(){

	}

	function receive(){

	}

	function itemRows(){
		return $this->add('xDispatch/Model_DeliveryNoteItem')->addCondition('delivery_note_id',$this->id);
	}
}
