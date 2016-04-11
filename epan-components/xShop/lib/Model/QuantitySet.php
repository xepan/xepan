<?php

namespace xShop;

class Model_QuantitySet extends \Model_Table{
	public $table = 'xshop_item_quantity_sets';

	function init(){
		parent::init();

		$this->hasOne('xShop/Item','item_id');
		$this->addField('name');//->sortable(true); // To give special name to a quantity Set .. leave empty to have qty value here too
		$this->addField('qty')->type('number')->mandatory(true);//->sortable(true);
		$this->addField('old_price')->type('money')->mandatory(true);//->sortable(true);
		$this->addField('price')->type('money')->mandatory(true)->caption('Unit Price');//->sortable(true);
		
		$this->addField('shipping_charge')->type('money')->mandatory(true);
		$this->addField('is_default')->type('boolean')->defaultValue(false);//->sortable(true);

		$this->addExpression('custom_fields_conditioned')->set(function($m,$q){
			$temp =$m->refSQL('xShop/QuantitySetCondition');
			return $temp->_dsql()->group('quantityset_id')->del('fields')->field('count(*)');
		});//->sortable(true);

		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);
		$this->addHook('afterInsert',$this);

		$this->hasMany('xShop/QuantitySetCondition','quantityset_id');
		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){
		if(trim($this['name'])=='') $this['name']=$this['qty'];
	}

	function afterInsert(){
		$item = $this->add('xShop/Model_Item')->load($this['item_id']);
		$cf_array = $item->getAssociatedCustomFields();
		// foreach ($cf_array as $junk) {			
		// }
	}

	function beforeDelete(){
		$this->ref('xShop/QuantitySetCondition')->deleteAll();
	}

	function duplicate($new_item_id){
		
		if(!$this->loaded())
			throw new \Exception("Model Must be loaded");
			
		$new_asso = $this->add('xShop/Model_QuantitySet');
		$new_asso['item_id'] = $new_item_id;
		$new_asso['name'] = $this['name'];
		$new_asso['qty'] = $this['qty'];
		$new_asso['old_price'] = $this['old_price'];
		$new_asso['price'] = $this['price'];
		$new_asso['shipping_charge'] = $this['shipping_charge'];
		$new_asso->save();
		
		$old_qsc = $this->add('xShop/Model_QuantitySetCondition')->addCondition('quantityset_id', $this->id);
		foreach ($old_qsc as $qsc) {
			$qsc->duplicate($new_asso->id);
		}
	}

}