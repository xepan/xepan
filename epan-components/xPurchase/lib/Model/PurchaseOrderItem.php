<?php
namespace xPurchase;

class Model_PurchaseOrderItem extends \Model_Document{
	public $table="xpurchase_purchase_order_item";
	public $status=array('waiting','processing','received','completed');
	public $root_document_name='xPurchase\PurchaseOrder';
	function init(){
		parent::init();

		$this->hasOne('xPurchase/PurchaseOrder','po_id');
		
		$this->hasOne('xShop/Item_Purchasable','item_id')->display(array('form'=>'xShop/Item'));
		
		$this->addField('qty');
		$this->addField('unit');
		$this->addField('rate');
		$this->addField('amount');
		$this->addField('narration');

		$this->getElement('status')->defaultValue('waiting');

		$this->addField('custom_fields')->type('text');

		$this->addHook('beforeSave',$this);


		// $this->add('dynamic_model/Controller_AutoCreator');

	}

	function item(){
		return $this->ref('item_id');
	}

	function beforeSave(){

		// validate custom field entries
		$phase = $this->add('xHR/Model_Department')->loadStore();

		if($this['custom_fields']==''){
			// $phases_ids = $this->ref('item_id')->getAssociatedDepartment();
			$cust_field_array = array();
		}else{
			$cust_field_array = json_decode($this['custom_fields'],true);
			// $phases_ids = array_keys($cust_field_array);
		}

		// foreach ($phases_ids as $phase_id) {
			$custom_fields_assos_ids = $this->ref('item_id')->getAssociatedCustomFields($phase->id);
			foreach ($custom_fields_assos_ids as $cf_id) {
				if(!isset($cust_field_array[$phase->id][$cf_id]) or $cust_field_array[$phase->id][$cf_id] == ''){
					throw $this->exception('Custom Field Values not proper','Growl');
				}
			}
		// }
		
	}
}	