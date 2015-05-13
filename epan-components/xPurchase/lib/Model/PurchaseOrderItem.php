<?php
namespace xPurchase;

class Model_PurchaseOrderItem extends \Model_Document{
	public $table="xpurchase_purchase_order_item";
	public $status=array('waiting','processing','received','completed');
	public $root_document_name='xPurchase\PurchaseOrderItem';
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xPurchase/PurchaseOrder','po_id')->caption('Purchase Order');
		$this->hasOne('xPurchase/PurchaseInvoice','invoice_id')->display(array('form'=>'autocomplete/Basic'));
		$this->hasOne('xShop/Item_Purchasable','item_id')->display(array('form'=>'xShop/Item'));
		
		$this->addField('qty')->type('int');
		$this->addField('received_qty')->type('int');
		$this->addField('unit');
		$this->addField('rate')->type('money');
		$this->addField('amount')->type('money');
		$this->addField('narration')->type('text');

		$this->getElement('status')->defaultValue('waiting');

		$this->addField('custom_fields')->type('text');

		$this->addHook('beforeSave',$this);
		$this->addHook('afterSave',$this);


		// $this->add('dynamic_model/Controller_AutoCreator');

	}
	

	function afterSave($obj){
		if($this->loaded()){
			$this['unit'] = $this->ref('item_id')->get('qty_unit');
			$this->save();	
		}
	}

	function item(){
		return $this->ref('item_id');
	}

	function invoice($invoice=null){
		if($invoice){
			$this['invoice_id'] = $invoice->id;
			$this->save();
			return $invoice;
		}else{
			if(!$this['invoice_id']) return false;
			return $this->ref('invoice_id');
		}
	}

	function order(){
		return $this->ref('po_id');
	}

	function beforeSave(){
		$item_id = $this['item_id'];
		if(!$item_id) return;
		
		// validate custom field entries
		$phase = $this->add('xHR/Model_Department')->tryLoadStore();
		if($phase->loaded()){
			if($this['custom_fields']==''){
				// $phases_ids = $this->ref('item_id')->getAssociatedDepartment();
				$cust_field_array = array();
			}else{
				$cust_field_array = json_decode($this['custom_fields'],true);
				// $phases_ids = array_keys($cust_field_array);
			}

			// foreach ($phases_ids as $phase_id) {
				$pur_itm = $this->add('xShop/Model_Item_Purchasable')->load($item_id);

				$custom_fields_assos_ids = $pur_itm->getAssociatedCustomFields($phase->id);
				foreach ($custom_fields_assos_ids as $cf_id) {
					if(!isset($cust_field_array[$phase->id][$cf_id]) or $cust_field_array[$phase->id][$cf_id] == ''){
						throw $this->exception('Custom Field Values not proper','Growl');
					}
				}
		}
		// }
		
	}

	function setItemEmpty(){
		if(!$this->loaded()) return;

		$this['item_id'] = null;
		$this->save();
	}
}	