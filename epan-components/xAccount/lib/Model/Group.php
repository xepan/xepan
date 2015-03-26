<?php
namespace xAccount;

class Model_Group extends \Model_Table{
	public $table="xaccount_group";
	function init(){
		parent::init();

		$this->hasOne('xAccount/BalanceSheet','balance_sheet_id');
		
		$this->addField('name')->caption('Group Name')->mandatory(true);
		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));


		$this->hasMany('Account','group_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function loadSunderyCreditor(){
		
	}

	function createNewGroup($name,$balance_sheet_id,$other_values=array(),$form=null,$on_date=null){
		
		$this['name'] = $name;
		$this['balance_sheet_id'] = $balance_sheet_id;
		

		foreach ($other_values as $field => $value) {
			$this[$field] = $value;
		}

		$this->save();
	}
}