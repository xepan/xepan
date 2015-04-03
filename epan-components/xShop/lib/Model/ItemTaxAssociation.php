<?php

namespace xShop;

class Model_ItemTaxAssociation extends \Model_Document {
	public $table='xshop_itemtaxasso';
	public $status=array();
	public $root_document_name='xShop\ItemTaxAssociation';

	public $actions=array(
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
		);
	
	function init(){
		parent::init();

		$this->hasOne('xShop/Tax','tax_id')->display(array('form'=>'autocomplete/Plus'));
		$this->hasOne('xShop/Item','item_id');
		$this->addField('name')->caption('Tax in %');
		$this->addHook('beforeSave',$this);
		$this->add('dynamic_model/Controller_AutoCreator');

	}	


	function beforeSave(){	
		if(!$this['name']){
			$this['name'] = $this->tax($this['tax_id'])->get('value');
		}
	}

	function tax($tax_id){
		if(!$tax_id)
			return false;
		return $this->add('xShop/Model_Tax')->load($tax_id);
	}

	function duplicate($new_item_id){
		if(!$new_item_id)
			return;
		$m = $this->add('xShop/Model_ItemTaxAssociation');
		$m['tax_id'] = $this['tax_id'];
		$m['item_id'] = $new_item_id;
		$m['name'] = $this['name'];
		$m->saveAndUnload();
	}

}