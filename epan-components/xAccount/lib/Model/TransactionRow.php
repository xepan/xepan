<?php
namespace xAccount;

class Model_TransactionRow extends \Model_Table{
	public $table="xaccount_transaction_row";
	function init(){
		parent::init();

		$this->hasOne('xAccount/Transaction','transaction_id');
		$this->hasOne('xAccount/Account','account_id');
		$this->addField('amountDr')->caption('Debit')->type('money');
		$this->addField('amountCr')->caption('Credit')->type('money');
		$this->addField('side');
		$this->addField('accounts_in_side')->type('int');

		// $this->add('dynamic_model/Controller_AutoCreator');
	}
}