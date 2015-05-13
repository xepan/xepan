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

	function duplicate($item_id){
		if( $item_id < 0)
			return false;

		$asso_model = $this->add('xShop/Model_ItemDepartmentAssociation')->addCondition('item_id',$item_id);

		foreach ($asso_model as $association) {
			$m = $this->add('xShop/Model_ItemDepartmentAssociation');
			$m['department_id'] = $association['department_id'];
			$m['item_id'] = $association['item_id'];
			$m['is_active'] = $association['is_active'];
			$m->saveAndUnload();
		}

	}


}