<?php
namespace xStore;

class Model_Stock extends \Model_Table{
	public $table="xstore_stock";
	function init(){
		parent::init();

			$this->hasOne('xStore/Warehouse','warehouse_id')->display(array('form'=>'autocomplete/Plus'))->sortable(true);	
			$this->hasOne('xShop/Item_Stockable','item_id')->display(array('form'=>'xShop/Item'))->sortable(true);
			$this->addExpression('item_name','"item_name"')->sortable(true);
			$this->addField('qty')->sortable(true);
			$this->addField('custom_fields')->type('text')->hint('1(custom_field_id):11(custom_field_value_id) ~ 12(custom_field_id):21(custom_field_value_id)');
			

			$this->addHook('afterLoad',$this);
			// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterLoad(){
		if($this->hasElement('custom_fields') and $this['custom_fields'] and $this->hasElement('item_id')){
			$cf_array=json_decode($this['custom_fields'],true);
			$qty_json = json_encode(array('stockeffectcustomfield'=>$cf_array['stockeffectcustomfield']));
			$this['item_name'] = $this['item'] .' [' .$this->item()->genericRedableCustomFieldAndValue($qty_json) .' ]';
		}elseif($this->hasElement('item_id')){
			$this['item_name'] = $this['item'];
		}else{
			$this['item_name'] = $this['item'];
		}
	}

	function item(){
		return $this->ref('item_id');
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
