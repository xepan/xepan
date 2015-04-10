<?php

namespace xShop;

class Model_ItemCustomFieldAssos extends \Model_Table{
	public $table="xshop_item_customfields_assos";

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/CustomFields','customfield_id')->display(array('form'=>'autocomplete/Plus'));
		$this->hasOne('xShop/Item','item_id');
		$this->hasOne('xProduction/Phase','department_phase_id');

		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('is_active')->type('boolean')->defaultValue(true)->sortable(true);
		$this->addField('can_effect_stock')->type('boolean')->defaultValue(false)->mandatory(true);

		$this->hasMany('xShop/CustomFieldValue','itemcustomfiledasso_id');

		$this->addExpression('name')->set(function($m,$q){
			return $m->refSQL('customfield_id')->fieldQuery('name');			
		});

		$this->addHook('beforeSave',$this);
		// $this->addHook('beforeDelete',$this);
		
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){		
		if(!$this['department_phase_id']){
			throw $this->Exception('Department Cannot be Empty','ValidityCheck')->setField('department_phase_id');
		}

		$old_model = $this->add('xShop/Model_ItemCustomFieldAssos');
		
		$old_model->addCondition('item_id',$this['item_id'])
				->addCondition('department_phase_id',$this['department_phase_id'])
				->addCondition('customfield_id',$this['customfield_id'])
				->addCondition('id','<>',$this->id)
				->tryLoadAny();
		if($old_model->loaded()){
			throw $this->Exception('Custom Filed Exist','ValidityCheck')->setField('customfield_id');
		}

		//check for the Can Effect Stock 
		//Check selected Department Phase is Store
		//if check_effect_stock is true
			// if($this['can_effect_stock']){
			// 	//load Store Department
			// 	$store = $this->add('xHR/Model_Department')->loadStore();
			// 	//if department phase is not store
			// 	if($store['id'] != $this['department_phase_id']){
			// 		// display error
			// 		throw $this->Exception('Only Apply With Store Department Phase','ValidityCheck')->setField('can_effect_stock');
			// 	}			
			// }

		//Check customField is empty
		if(!$this['customfield_id'])
			throw $this->Exception('Select Any CustomField','ValidityCheck')->setField('customfield_id');
		
	}

	function duplicate($new_item_id){
		$new_asso = $this->add('xShop/Model_ItemCustomFieldAssos');
		$new_asso['customfield_id'] = $this['customfield_id'];
		$new_asso['item_id'] = $new_item_id;
		$new_asso['is_active'] = $this['is_active'];
		$new_asso['department_phase_id'] = $this['department_phase_id'];
		$new_asso['can_effect_stock'] = $this['can_effect_stock'];
		$new_asso->save();
		return $new_asso;
	}
		
}