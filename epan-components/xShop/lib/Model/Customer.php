<?php

namespace xShop;

class Model_Customer extends Model_MemberDetails{
	public $title_field ='customer_search_phrase';

	public $actions=array(
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
		);

	function init(){
		parent::init();

		$this->getElement('users_id')->destroy();
		$this->getElement('name')->destroy();
		$this->getElement('email')->destroy();

		$user_j = $this->join('users','users_id');
		$user_j->addField('username')->sortable(true)->group('b~6~Customer Loign');
		$user_j->addField('password')->type('password')->group('b~6');
		$user_j->addField('customer_name','name')->group('a~6~Basic Info')->mandatory(true);
		$user_j->addField('customer_email','email')->sortable(true)->group('a~6');
		$user_j->addField('type')->setValueList(array(100=>'SuperUser',80=>'BackEndUser',50=>'FrontEndUser'))->defaultValue(50)->group('a~6')->sortable(true)->mandatory(false);

		$this->addCondition('type',50);

		$this->addExpression('customer_search_phrase')->set($this->dsql()->concat(
				$this->getElement('customer_name'),
				' :: ',
				$this->getElement('customer_email'),
				' :: ',
				$this->getElement('mobile_number')
				
			));

		$this->hasMany('xShop/Oppertunity','customer_id');
		$this->hasMany('xShop/Quotation','customer_id');
		$this->hasMany('xShop/Order','customer_id');

		$this->arrangeFields();



	}

	function arrangeFields(){
		$o=$this->add('Order');
		$o->move($this->getElement('mobile_number'),'first');
		$o->move($this->getElement('customer_email'),'first');
		$o->move($this->getElement('customer_name'),'first');
		$o->move($this->getElement('username'),'last');
		$o->move($this->getElement('password'),'last');

		$o->now();
	}

	function account(){
		$acc = $this->add('xAccount/Model_Account')
				->addCondition('customer_id',$this->id)
				->addCondition('group_id',$this->add('xAccount/Model_Group')->loadSundryDebtor()->get('id'));
		$acc->tryLoadAny();
		if(!$acc->loaded()){
			$acc['name'] = $this['customer_search_phrase'];
			$acc->save();
		}

		return $acc;
	}

	function email(){
		if(!$this->loaded())
			return false;
		return $this['customer_email'];
	}

	function mobileno(){
		if(!$this->loaded())
			return false;
		return $this['mobile_number'];	
	}

	
}