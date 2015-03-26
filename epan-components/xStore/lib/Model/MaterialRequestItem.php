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
		$this->addField('narration');
		
		$this->addField('custom_fields')->type('text')->sortable(true);
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
			$custom_fields_assos_ids = $this->ref('item_id');
			$custom_fields_assos_ids = $custom_fields_assos_ids->getAssociatedCustomFields($phase->id);
			foreach ($custom_fields_assos_ids as $cf_id) {
				if(!isset($cust_field_array[$phase->id][$cf_id]) or $cust_field_array[$phase->id][$cf_id] == ''){
					throw $this->exception('Custom Field Values not proper');
				}
			}
		// }
		
	}
}