<?php

namespace xShop;
class Model_QuotationItem extends \Model_Document{
	
	public $table="xshop_quotation_item";
	public $status=array();
	public $root_document_name="QuotationItem";

	function init(){
		parent::init();
		$this->hasOne('xShop/Quotation','quotation_id')->sortable(true);
		$this->hasOne('xShop/Item','item_id')->display(array('form'=>'autocomplete/Basic'))->sortable(true);
		
		$this->addField('qty')->sortable(true);
		$this->addField('rate')->sortable(true);
		$this->addField('amount')->sortable(true);
		$this->addField('narration');
		$this->addField('custom_fields')->type('text')->sortable(true);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	//Return OrderItem DepartmentalStatus
	//$with_custom_Fields = true; means also return departmnet associated CustomFields of OrderItem in Human Redable
	function redableDeptartmentalStatus($with_custom_fields=false){
		if(!$this->loaded())
			return false;

		$str = "";
		$array = json_decode($this['custom_fields'],true);
		if(!$array) return false;
		
		foreach ($array as $department_id => $cf) {
			$d = $this->add('xHR/Model_Department')->load($department_id);
			$str .= $d['name'];
			if($with_custom_fields){
				if(!empty($cf)){
					$ar[$department_id] = $cf;
					$str .= "<br>[".$this->ref('item_id')->genericRedableCustomFieldAndValue(json_encode($ar))." ]<br>";
					unset($ar[$department_id]);							
				}else{
					$str.="<br>";
				}
			}
		}
			
		return $str;
	}


}