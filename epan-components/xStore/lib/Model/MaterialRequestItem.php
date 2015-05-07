<?php

namespace xStore;
class Model_MaterialRequestItem extends \Model_Document{
	public $table="xstore_material_request_items";
	public $status=array();
	public $root_document_name='xStore\MaterialRequestItem';

	function init(){
		parent::init();

		$this->hasOne('xStore/MaterialRequest','material_request_jobcard_id');
		$this->hasOne('xShop/Item','item_id')->display(array('form'=>'xShop/Item'));
		$this->addField('qty')->sortable(true);
		$this->addField('unit')->sortable(true);
		$this->addField('narration')->type('text');
		
		$this->addField('custom_fields')->type('text')->sortable(true);
		$this->addHook('beforeSave',$this);
		$this->addHook('afterLoad',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterLoad(){
		$cf_array=json_decode($this['custom_fields'],true);
		$qty_json = json_encode(array('stockeffectcustomfield'=>$cf_array['stockeffectcustomfield']));
		$this['item_with_qty_fields'] = $this['item'] .' [' .$this->item()->genericRedableCustomFieldAndValue($qty_json) .']';
	}

	function item(){
		return $this->ref('item_id');
	}

	function beforeSave(){

		// validate custom field entries
		if($this['custom_fields']==''){
			$cust_field_array = array();
		}else{
			$all_custom_field = json_decode($this['custom_fields'],true);
			$cust_field_array = $all_custom_field['stockeffectcustomfield'];
		}

		// foreach ($phases_ids as $phase_id) {
			$stock_effect_cf = $this->ref('item_id')->stockeffectcustomfields();
			// $custom_fields_assos_ids = $custom_fields_assos_ids->getAssociatedCustomFields($phase->id);
			foreach ($stock_effect_cf as $cf) {
				if(!isset($cust_field_array[$cf['customfield_id']]) or $cust_field_array[$cf['customfield_id']] == ''){
					throw $this->exception('Custom Field Values not proper .' . $this['custom_fields']);
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