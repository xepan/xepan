<?php
namespace xAccount;

class Model_Transaction extends \Model_Document{
	public $table="xaccount_transaction";
	public $status=array();
	public $root_document_name = 'xAccount\Transaction';
	public $dr_accounts=array();
	public $cr_accounts=array();


	public $only_transaction=false;
	public $create_called=false;

	public $all_debit_accounts_are_mine = true;
	public $all_credit_accounts_are_mine = true;

	public $other_branch=null;
	public $other_branches_involved = array();

	public $executed=false;

	function init(){
		parent::init();
		$this->hasOne('xAccount/TransactionType','transaction_type_id');
		$this->hasOne('xAccount/Account','reference_account_id');
		$this->hasOne('xHR/Employee','employee_id');
		$this->addField('voucher_no_original')->type('int'); 
		$this->addField('voucher_no')->type('int'); 
		$this->addField('Narration')->type('text');

		$this->hasMany('xAccount/TransactionRow','transaction_id');


		// $this->add('dynamic_model/Controller_AutoCreator');
	}
	
	function createNewTransaction($transaction_type, $transaction_date=null, $Narration=null, $only_transaction=null,$options=array()){
		if($this->loaded()) throw $this->exception('Use Unloaded Transaction model to create new Transaction');
		
		$transaction_type_model = $this->add('xAccount/Model_TransactionType');
		$transaction_type_model->tryLoadBy('name',$transaction_type);
		
		if(!$transaction_type_model->loaded()) $transaction_type_model->save();

		if(!$transaction_date) $transaction_date = $this->api->now;

		// Transaction TYpe Save if not available
		$this['transaction_type_id'] = $transaction_type_model->id;
		$this['reference_account_id'] = isset($options['reference_account_id'])?:0;
		$this['branch_id'] = $branch->id;
		$this['voucher_no'] = $branch->newVoucherNumber($branch,$transaction_date);
		$this['Narration'] = $Narration;
		$this['created_at'] = $transaction_date;

		$this->transaction_type = $transaction_type;
		$this->branch = $branch;
		$this->only_transaction = $only_transaction;
		$this->transaction_date = $transaction_date;
		$this->Narration = $Narration;
		$this->only_transaction = $only_transaction;
		$this->options = $options;

		$this->create_called=true;
	}

}