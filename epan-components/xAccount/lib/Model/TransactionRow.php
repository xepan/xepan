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

		$this->addExpression('created_at')->set($this->refSQL('transaction_id')->fieldQuery('created_at'));
		$this->addExpression('voucher_no')->set($this->refSQL('transaction_id')->fieldQuery('voucher_no'));
		$this->addExpression('Narration')->set($this->refSQL('transaction_id')->fieldQuery('Narration'));

		// $this->add('dynamic_model/Controller_AutoCreator');
	}
}