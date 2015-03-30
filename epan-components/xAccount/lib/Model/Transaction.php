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
		$this->addField('name')->caption('Voucher No');
		$this->addExpression('voucher_no')->set(function ($m,$q){
			return $q->getField('name');
		});
		 
		$this->addField('Narration')->type('text');

		$this->hasMany('xAccount/TransactionRow','transaction_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}
	
	function createNewTransaction($transaction_type, $related_document=false, $transaction_date=null, $Narration=null){
		if($this->loaded()) throw $this->exception('Use Unloaded Transaction model to create new Transaction');
		
		$transaction_type_model = $this->add('xAccount/Model_TransactionType');
		$transaction_type_model->tryLoadBy('name',$transaction_type);
		
		if(!$transaction_type_model->loaded()) $transaction_type_model->save();

		if(!$transaction_date) $transaction_date = date('Y-m-d H:i:s');

		// Transaction TYpe Save if not available
		$this['transaction_type_id'] = $transaction_type_model->id;
		$this['name'] = $transaction_type_model->newVoucherNumber($transaction_date);
		$this['Narration'] = $Narration;
		$this['created_at'] = $transaction_date;

		$this->related_document = $related_document;

		$this->create_called=true;
	}

	function addDebitAccount($account, $amount){
		if(is_string($account)){
			$account = $this->add('xAccount/Model_Account')->load($account->id);
		}

		$amount = round($amount,2);
		
		$this->dr_accounts += array($account->id => array('amount'=>$amount,'account'=>$account));
	}

	function addCreditAccount($account, $amount){
		if(is_string($account)){
			$account = $this->add('xAccount/Model_Account')->load($account->id);
		}

		$amount = round($amount,2);
		
		$this->cr_accounts += array($account->id=>array('amount'=>$amount,'account'=>$account));
	}

	function execute(){
		if($this->loaded())
			throw $this->exception('New Transaction can only be added on unLoaded Transaction Model ');

		if(!$this->create_called) throw $this->exception('Create Account Function Must Be Called First');
		
		// $this->senitizeTransaction();
		
		if(($msg=$this->isValidTransaction($this->dr_accounts,$this->cr_accounts, $this['transaction_type_id'])) !== true)
			throw $this->exception('Transaction is Not Valid ' .  $msg)->addMoreInfo('message',$msg);

		if($this->related_document){
			$this->relatedDocument($this->related_document);
		}

		$this->executeSingleBranch();


		$this->executed=true;
	}

	function executeSingleBranch(){

		$this->save();

		$total_debit_amount =0;
		// Foreach Dr add new TransacionRow (Dr wali)
		foreach ($this->dr_accounts as $accountNumber => $dtl) {
			if($dtl['amount'] ==0) continue;
			$dtl['account']->debitWithTransaction($dtl['amount'],$this->id);
			$total_debit_amount += $dtl['amount'];
		}


		$total_credit_amount =0;
		// Foreach Cr add new Transactionrow (Cr Wala)
		foreach ($this->cr_accounts as $accountNumber => $dtl) {
			if($dtl['amount'] ==0) continue;
			$dtl['account']->creditWithTransaction($dtl['amount'],$this->id);
			$total_credit_amount += $dtl['amount'];
		}
		
		// Credit Sum Must Be Equal to Debit Sum
		if($total_debit_amount != $total_credit_amount)
			throw $this->exception('Debit and Credit Must be Same')->addMoreInfo('DebitSum',$total_debit_amount)->addMoreInfo('CreditSum',$total_credit_amount);

	}

	function isValidTransaction($DRs, $CRs, $transaction_type_id){
		// if(count($DRs) > 1 AND count($CRs) > 1)
		// 	return "Dr and Cr both have multiple accounts";

		if(!count($DRs) or !count($CRs))
			return "Either Dr or Cr accounts are not present. DRs =>".count($DRs). " and CRs =>".count($CRs);

		if(!$this->all_debit_accounts_are_mine and !$this->all_credit_accounts_are_mine)
			return "Dr and Cr both containes other branch accounts";

		if(count($this->other_branches_involved) > 1)
			return "More then one other branch involved";

		return true;
	}

}