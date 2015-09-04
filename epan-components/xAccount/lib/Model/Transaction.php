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
	public $actions=array(
			'can_forcedelete'=>array(),
		);
	
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xAccount/TransactionType','transaction_type_id');
		$this->addField('name')->caption('Voucher No');
		$this->addExpression('voucher_no')->set(function ($m,$q){
			return $q->getField('name');
		});
		 
		$this->addField('Narration')->type('text');

		$this->hasMany('xAccount/TransactionRow','transaction_id');

		// $this->addExpression('cr_sum')->set($this->refSQL('xAccount/TransactionRow')->sum('amountCr'));
		// $this->addExpression('dr_sum')->set($this->refSQL('xAccount/TransactionRow')->sum('amountDr'));

		$this->addHook('beforeDelete',$this);
		$this->addHook('beforeSave',[$this,'searchStringBeforeSave']));

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function searchStringBeforeSave(){
		$str = "Transaction: ".$this['name']." ".
				$this['Narration'];

		foreach ($this->rows() as $tr) {
			$str .= $tr['side'];
			$str .= $tr->account()->get('name');
			$str .= $tr['amountCr']." ".$tr['amountDr']." ".$tr['Narration']." ".$tr['voucher_no']." ".$tr['transaction_type'];
		}

		$this['search_string'] = $str;
	}

	function beforeDelete(){
		if($this->ref('xAccount/TransactionRow')->count()->getOne())
			throw $this->exception('TRansaction Contains Rows, Cannot Delete','Growl');
	}

	function cr_sum(){
		return $this->ref('xAccount/TransactionRow')->sum('amountCr');
	}

	function dr_sum(){
		return $this->ref('xAccount/TransactionRow')->sum('amountDr');
	}

	
	function forceDelete(){
		foreach ($this->ref('xAccount/TransactionRow') as $trrow) {
			$trrow->forceDelete();
		}

		$this->delete();
	}

	function rows(){
		return $this->ref('xAccount/TransactionRow');
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
		// Foreach Dr add new TransactionRow (Dr wali)
		foreach ($this->dr_accounts as $accountNumber => $dtl) {
			if($dtl['amount'] ==0) continue;
			$dtl['account']->debitWithTransaction($dtl['amount'],$this->id);
			$total_debit_amount += $dtl['amount'];
		}

		//FOR ROUND AMOUNT CALCULATION
		$shop_config = $this->add('xShop/Model_Configuration')->tryLoadAny();
		if($shop_config['is_round_amount_calculation']){
			$total_debit_amount = round($total_debit_amount,0);
		}

		$total_credit_amount =0;
		// Foreach Cr add new Transactionrow (Cr Wala)
		foreach ($this->cr_accounts as $accountNumber => $dtl) {
			if($dtl['amount'] ==0) continue;
			$dtl['account']->creditWithTransaction($dtl['amount'],$this->id);
			$total_credit_amount += $dtl['amount'];
		}
		
		//FOR ROUND AMOUNT CALCULATION
		if($shop_config['is_round_amount_calculation']){
			$total_credit_amount = round($total_credit_amount,0);
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
			return "Dr and Cr both contains other branch accounts";

		if(count($this->other_branches_involved) > 1)
			return "More then one other branch involved";

		return true;
	}

	function sendReceiptViaEmail($customer_email=false){
		
		if(!$this->loaded())
			return false;
		
		$order = $this->relatedDocument();

		$config = $this->add('xShop/Model_Configuration')->tryLoadAny();
		$subject = $config['cash_voucher_email_subject'];
		$subject = str_replace('{{order_no}}', $order['name'], $subject);
		$subject = str_replace('{{voucher_no}}', $this['name'], $subject);
		$email_body = $config['cash_voucher_email_body'];
		
		$email_body = str_replace('{{voucher_no}}', $this['name'], $email_body);
		$email_body = str_replace('{{order_no}}', $order['name'], $email_body);
		$email_body = str_replace('{{date}}', $this['created_at'], $email_body);
		$email_body = str_replace('{{amount}}', $this->ref('xAccount/TransactionRow')->sum('amountCr'), $email_body);
		$email_body = str_replace('{{pay_to}}', $order->customer()->get('customer_name'), $email_body);
		$email_body = str_replace('{{approve_by}}', $order->searchActivity('approved'), $email_body);
		$email_body = str_replace('{{transaction_type}}', $this['transaction_type'], $email_body);

		if(strpos($this['transaction_type'],"CASH") !==false){
			$email_body = str_replace('{{cash}}',"Yes", $email_body);
			$email_body = str_replace('{{cheque}}',"No", $email_body);
		}

		if(strpos($this['transaction_type'],"BANK") !==false){
			$email_body = str_replace('{{cash}}',"No", $email_body);
			$email_body = str_replace('{{cheque}}',"Yes", $email_body);
		}

		$customer = $this->customer();
		if(!$customer_email){
			$customer_email=$customer->get('customer_email');
		}

		if(!$customer_email) return;

		$this->sendEmail($customer_email,$subject,$email_body,$ccs=array(),$bccs=array());
		if(!$order instanceof \Dummy)
			$order->createActivity('email',$subject,"Advanced Payment Voucher od Order (".$this['name'].")",$from=null,$from_id=null, $to='Customer', $to_id=$customer->id);
		return true;
	}

	function customer(){
		foreach ($this->rows() as $trrow) {
			$acc = $trrow->account();
			if($acc->isSundryDebtor())
				return $trrow->account()->customer();
		}
	}

}