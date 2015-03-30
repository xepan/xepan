<?php
namespace xShop;

class Model_InvoiceItem extends \Model_Document{
	public $table="xshop_invoice_item";
	public $status  = array('draft','submitted','approved','canceled','completed');
	public $root_document_name = 'xShop\InvoiceItem';
	public $actions=array(
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_view'=>array(),
		);
	function init(){
		parent::init();

		$this->hasOne('xShop/Invoice','invoice_id');
	
		$this->hasOne('xShop/Item','item_id')->display(array('form'=>'xShop/Item'));
		
		$this->addField('qty');
		$this->addField('unit');
		$this->addField('rate');
		$this->addField('narration');
		
		$this->addField('custom_fields')->type('text');

		// $this->addHook('beforeSave',$this);

	// $this->add('dynamic_model/Controller_AutoCreator');

	}

	function item(){
		return $this->ref('item_id');
	}

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
	
