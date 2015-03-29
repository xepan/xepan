<?php
namespace xAccount;

class Model_TransactionType extends \Model_Table{
	public $table="xaccount_transaction_types";
	
	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('FromAC');
		$this->addField('ToAC');
		$this->addField('Default_Narration');
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function newVoucherNumber(){
		return rand(10000,99999);
	}	

}