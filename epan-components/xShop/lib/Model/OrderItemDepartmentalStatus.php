<?php

namespace xShop;

class Model_OrderItemDepartmentalStatus extends \SQL_Model{
	public $table ="xshop_orderitem_departmental_status";

	function init(){
		parent::init();

		$this->hasOne('xShop/OrderDetails','orderitem_id');
		$this->hasOne('xHR/Department','department_id');
		$this->hasOne('xProduction/OutSourceParty','outsource_party_id');
		
		$this->addExpression('Quantity')->set(function($m,$q){
			return $m->refSQL('orderitem_id')->fieldQuery('qty');
		});
		
		$this->addExpression('Unit')->set(function($m,$q){
			return $m->refSQL('orderitem_id')->fieldQuery('unit');
		});

		$this->addField('status')->defaultValue('Waiting');

		// status of previous department jobcard .. if any or null
		$this->addExpression('previous_status')->set(function($m,$q){
			// my departments
			// my previous departments : leftJOin
			// job cards of my same orderitem_id from previous departments
			// limit 1
			// 
			return $m->refSQL('xProduction/JobCard')->_dsql()->limit(1)->del('fields')->field('status');
		});		

		// hasMany JobCards
		$this->hasMany('xProduction/JobCard','orderitem_departmental_status_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function createJobCardFromOrder(){
		$new_job_card = $this->add($this->department()->getNamespace().'/Model_'.  $this->department()->jobcard_document());
		$new_job_card->createFromOrder($this->ref('orderitem_id'),$this);
		$this['status']='Sent To '. $this['department'];
		$this->save();
		return $new_job_card;
	}

	function receive_to_DELETE(){
		// create job card for this department and this orderitem_id;
		$jobcard_model=$this->add($this->department()->getNamespace().'/Model_'.  $this->department()->jobcard_document());
		$jobcard_model->addCondition('orderitem_departmental_status_id',$this->id);
		$jobcard_model->addCondition('orderitem_id',$this['orderitem_id']);
		$jobcard_model->addCondition('department_id',$this['department_id']);
		$jobcard_model->tryLoadAny();
		if($jobcard_model->loaded())
			throw $this->exception('Already Recieved and Job Card Created');
		
		$jobcard_model->receive();

		$this['status']='Received By '. $this['department'];
		$this->save();

		// jiska status ... received hoga
		// agar previous department hai to
			// uske job card ka status complete ka do
		// creatre log/communication entry
	}

	function department(){
		return $this->ref('department_id');
	}

	function orderItem(){
		return $this->ref('orderitem_id');
	}

	function outSourceParty($party=null){
		if(!$party){
			$t= $this->ref('outsource_party_id');
			if($t->loaded()) return $t;
			return false;
		}else{
			$this['outsource_party_id'] = $party->id;
			$this->save();
			return $party;
		}
	}

	function setStatus($status){
		$this['status']=$status;
		$this->save();
	}

}