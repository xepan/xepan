<?php

namespace xProduction;

class Model_JobCard extends \Model_Document{
	public $table ="xproduction_jobcard";
	public $status=array('-','received','approved','assigned','processing','processed','completed','forwarded');
	public $root_document_name = 'xProduction\JobCard';

	function init(){
		parent::init();
		// hasOne OrderItemDepartment Association id
		$this->hasOne('xShop/OrderDetails','orderitem_id');
		$this->hasOne('xHR/Department','department_id');
		$this->hasOne('xShop/OrderItemDepartmentalStatus','orderitem_departmental_status_id');
		
		$this->addField('type')->enum(array('JobCard','MaterialRequest'))->defaultValue('JobCard');

		$this->addField('name')->caption('Job Number');
		$this->getElement('status')->defaultValue('-');
		
		$this->addExpression('outsource_party')->set(function($m,$q){
			$p = $m->add('xProduction/Model_OutSourceParty');
			$j=$p->join('xshop_orderitem_departmental_status.outsource_party_id');
			$j->addField('order_item_dept_status_id','id');
			$p->addCondition('order_item_dept_status_id',$q->getField('orderitem_departmental_status_id'));
			return $p->fieldQuery('name');
		});

		$this->hasMany('xProduction/JobCardEmployeeTeamAssociation','jobcard_id');

		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required',
							)
					);
		$this->add('dynamic_model/Controller_AutoCreator');

	}

	// function assignTo($employee){
	// 	// create log/communication 
	// 	$temp=$this->add('xProduction/Model_JobCardEmployeeAssociation');
	// 	$temp->addCondition('jobcard_id',$this->id);
	// 	$temp->addCondition('employee_id',$employee->id);
	// 	$temp->tryLoadAny();
	// 	$temp->save();

	// 	$this['status']='assigned';
	// 	$this->saveAs('xProduction/Model_JobCard');
	// 	// throw $this->exception('To Do');
	// }

	// function getAssociatedEmployees(){
	// 	$associate_employees= $this->ref('xProduction/JobCardEmployeeAssociation')->_dsql()->del('fields')->field('employee_id')->getAll();
	// 	return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associate_employees)),false);
	// }

	// function removeAllEmployees(){
	// 	$this->ref('xProduction/JobCardEmployeeAssociation')->deleteAll();
	// 	$this['status']='received'; // back to received .. not assigned
	// 	$this->saveAs('xProduction/Model_JobCard');
	// }

	function previousDeptJobCard(){
		
		if($cf = $this->orderItem()->get('custom_fields')){
			$custom_fields = json_decode($cf,true);
		}else{
			$custom_fields = array();
		}

		$prev_dept_id = null;
		foreach ($custom_fields as $dept_id => $custom_field_values ) {
			if($this->department()->get('id') == $dept_id) break;
			$prev_dept_id = $dept_id;
		}
		if($prev_dept_id){
			$pre_dept_job_card = $this->add('xProduction/Model_JobCard');
			$pre_dept_job_card->addCondition('orderitem_id',$this['orderitem_id']);
			$pre_dept_job_card->addCondition('department_id',$prev_dept_id);
			$pre_dept_job_card->tryLoadAny();

			if($pre_dept_job_card->loaded()) return $pre_dept_job_card;
		}
		
		return false;
	}

	function dept(){
		return $this->ref('department_id');
	}

	function department(){
		return $this->dept();
	}

	function orderItem(){
		return $this->ref('orderitem_id');
	}

	function departmentalStatus(){
		return $this->ref('orderitem_departmental_status_id');
	}

	function outSourceParty($party=null){
		$t= $this->departmentalStatus();
		return $t->outSourceParty($party);
	}

	function removeOutSourceParty(){
		$t = $this->departmentalStatus();
		$t['outsource_party_id'] = 0;
		$t->save();
	}

	function receive(){
		// mark complete previous dept jobcard
		if($pre_dept_job_card = $this->previousDeptJobCard()){
			$pre_dept_job_card->complete();
		}

		// self status received
		if($this->department()->isOutSourced()){
			if(!$this->outSourceParty())
				throw $this->exception('Define OutSource Party First');
			else{
				$this['status']='processed';
			}
		}else{
			$this['status']='received';
		}

		$this['created_by_id']=$this->api->current_employee->id;
		$this->saveAs('xProduction/Model_JobCard');
	}

	function complete(){
		$this['status']='completed';
		$this->saveAs('xProduction/Model_JobCard');
	}

	function approve(){
		$rt = $this->relatedTask();
		if($rt->loaded())
			$rt->set('status','complete')->save();

		$this['status']='approved';
		$this->saveAs('xProduction/Model_JobCard');	
		
	}

	function forward($note){
		if($nd = $this->orderItem()->nextDept()){
			$nd->createJobCard();
		}
		$this['status'] = 'forwarded';
		$this->saveAs('xProduction/Model_JobCard');
	}

	function start_processing(){
		$this['status']='processing';
		$this->saveAs('xProduction/Model_JobCard');
	}

}	