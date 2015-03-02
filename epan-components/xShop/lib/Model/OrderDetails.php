<?php

namespace xShop;

class Model_OrderDetails extends \Model_Document{
	public $table='xshop_orderDetails';

	public $status=array();
	public $root_document_name = 'OrderDetails';

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('xShop/Order','order_id');
		$this->hasOne('xShop/Item','item_id')->display(array('form'=>'autocomplete/Basic'));//->group('a~6~Item Select');

		$this->addField('qty')->type('money')->group('b~3~Order Details');
		$this->addField('unit')->group('b~3');
		$this->addField('rate')->type('money')->group('b~3');
		$this->addField('amount')->type('money')->group('b~3');
		$this->addField('custom_fields')->type('text')->system(false)->group('c~12~ Custom Fields');

		$this->addExpression('created_by_id')->set(function($m,$q){
			return $m->refSQL('order_id')->fieldQuery('created_by_id');
		});

		$this->hasMany('xShop/OrderItemDepartmentalStatus','orderitem_id');

		$this->addHook('beforeSave',$this);
		$this->addHook('afterInsert',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){
		// validate custom field entries
		if($this['custom_fields']==''){
			$phases_ids = $this->ref('item_id')->getAssociatedDepartment();
			$cust_field_array = array();
		}else{
			$cust_field_array = json_decode($this['custom_fields'],true);
			$phases_ids = array_keys($cust_field_array);
		}

		foreach ($phases_ids as $phase_id) {
			$custome_fields_assos_ids = $this->ref('item_id')->getAssociatedCustomFields($phase_id);
			foreach ($custome_fields_assos_ids as $cf_id) {
				if(!isset($cust_field_array[$phase_id][$cf_id]) or $cust_field_array[$phase_id][$cf_id] == ''){
					throw $this->exception('Custome Field Values not proper','Growl');
				}
			}
		}
		throw new \Exception("Error Processing Request", 1);
		
	}

	function afterInsert($obj,$new_id){
		$new_order_details = $this->add('xShop/Model_OrderDetails')->load($new_id);
		if($new_order_details->order()->isFromOnline()){
			$item_departments = $new_order_details->item()->associatedDepartments();
			foreach($item_departments as $dept){
				$new_order_details->addToDepartment($dept);
			}
		}
	}

	function associatedWithDepartment($department){
		$relation = $this->ref('xShop/OrderItemDepartmentalStatus')->addCondition('department_id',$department->id);
		if($relation->tryLoadAny()->loaded())
			return $relation;
		else
			return false;		
	}

	function addToDepartment($department){
		$relation = $this->ref('xShop/OrderItemDepartmentalStatus')->addCondition('department_id',$department->id);
		$relation->tryLoadAny()->save();
	}

	function removeFromDepartment($department){
		$relation = $this->ref('xShop/OrderItemDepartmentalStatus')->addCondition('department_id',$department->id);
		if($relation->tryLoadAny()->loaded())
			$relation->delete();
	}

	function item(){
		return $this->ref('item_id');
	}

	function order(){
		return $this->ref('order_id');
	}

	function deptartmentalStatus(){
		return $this->ref('xShop/OrderItemDepartmentalStatus');
	}

	function nextDept(){
		foreach ($dept_status=$this->deptartmentalStatus() as $ds) {
			if(!$ds['status']) return $ds;
		}
		return false;
	}

}

