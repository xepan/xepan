<?php

namespace xShop;

class Model_ItemDepartmentAssociation extends \Model_Table{
	public $table='xshop_item_department_asso';

	function init(){
		parent::init();
		
		$this->hasOne('xShop/Item','item_id');
		$this->hasOne('xHR/Department','department_id');
		$this->addField('is_active')->type('boolean')->defaultValue(true);
		$this->addField('can_redefine_qty')->type('boolean')->defaultValue(true);
		$this->addField('can_redefine_items')->type('boolean')->defaultValue(true);

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function canRedefineQty(){
		return $this['can_redefine_qty'];
	}

	function canRedefineItems(){
		return $this['can_redefine_items'];
	}

	function duplicate($new_item_id,$from_item_id){

		$asso_model = $this->add('xShop/Model_ItemDepartmentAssociation')->addCondition('item_id',$from_item_id)->addCondition('is_active',true);
		foreach ($asso_model as $association) {
			$m = $this->add('xShop/Model_ItemDepartmentAssociation');
			$m['department_id'] = $association['department_id'];
			$m['item_id'] = $new_item_id;
			$m['is_active'] = $association['is_active'];
			$m->saveAndUnload();
		}

	}
}