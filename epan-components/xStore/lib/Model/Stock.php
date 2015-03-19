<?php
namespace xStore;

class Model_Stock extends \Model_Table{
	public $table="xstore_stock";
	function init(){
		parent::init();

			$this->hasOne('xStore/Warehouse','warehouse_id')->sortable(true);	
			$this->hasOne('xShop/Item_Stockable','item_id')->sortable(true);	
			$this->addField('qty')->sortable(true);
			$this->addField('custom_fields')->type('text')->hint('1(custom_field_id):11(custom_field_value_id) ~ 12(custom_field_id):21(custom_field_value_id)');
			
			// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function genericRedableCustomFiledAndValue(){
		if(!$this->loaded() and $this['custom_fields'] == "")
			return false;

		$str = ""; 
		$array = explode(" ", $this['custom_fields']);
		foreach ($array as $id => $cf_value) {
			if($cf_value !== ""){
				$cf = explode(":",$cf_value);
				$cfm = $this->add('xShop/Model_CustomFields')->load($cf[0]);
				$str.= $cfm['name'];
				$str.=": ";
				$cfvm = $this->add('xShop/Model_CustomFieldValue')->load($cf[1]);
				$str.= $cfvm['name'];
				$str.= "<br>";
			}
		}
		return $str;
	}

}		
