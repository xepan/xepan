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
		$this->addField('narration')->type('text')->system(false)->group('c~12~ Narration');
		$this->addField('custom_fields')->type('text')->system(false)->group('c~12~ Custom Fields');

		$this->addExpression('name')->set(function($m,$q){
			return $m->refSQL('item_id')->fieldQuery('name');
		});

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
			$custom_fields_assos_ids = $this->ref('item_id')->getAssociatedCustomFields($phase_id);
			foreach ($custom_fields_assos_ids as $cf_id) {
				if(!isset($cust_field_array[$phase_id][$cf_id]) or $cust_field_array[$phase_id][$cf_id] == ''){
					throw $this->exception('Custom Field Values not proper','Growl');
				}
			}
		}
		
	}

	function afterInsert($obj,$new_id){
		$new_order_details = $this->add('xShop/Model_OrderDetails')->load($new_id);
		if($new_order_details->order()->isFromOnline()){
			$item_departments = $new_order_details->item()->associatedDepartments();
			foreach($item_departments as $dept){
				$new_order_details->addToDepartment($dept);
			}
		}
		// else .. form_orderItem is doing for offline orders
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

	function getCurrentStatus(){
		$last_ds = $this->deptartmentalStatus()->addCondition('status','<>','Waiting');
		$last_ds->_dsql()->order('id','desc');
		$last_ds->tryLoadAny();

		if($last_ds->loaded())
			return $last_ds['status'];

		return "Waiting";
	}

	function deptartmentalStatus($department=false){
		$m = $this->ref('xShop/OrderItemDepartmentalStatus');
		if($department){
			$m->addCondition('department_id',$department->id);
			$m->tryLoadAny();
			if(!$m->loaded()) return false;
		}

		return $m;
	}

	function nextDeptStatus($after_department=false){
		foreach ($dept_status=$this->deptartmentalStatus() as $ds) {
			if($after_department){
				if($ds->department()->get('id') == $after_department->id) $after_department=false;
			}else{
				if($ds['status'] == 'Waiting') return $ds;
			}
		}
		return false;
	}

	function prevDeptStatus($before_department=false){
		$dept_status=$this->deptartmentalStatus()->setOrder('id','desc');
		
		foreach ($dept_status as $ds) {
			if($before_department){
				if($ds->department()->get('id') == $before_department->id) $before_department=false;
			}else{
				if($ds['status'] != 'Waiting') return $ds;
			}
		}
		return false;
	}

}

