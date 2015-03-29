<?php
namespace xShop;

class Model_SalesInvoice extends Model_Invoice{
	public $root_document_name = 'xShop\SalesInvoice';

	function init(){
		parent::init();
		$this->addCondition('type','salesInvoice');
	}

	function customer(){
		return $this->ref('customer_id');
	}

	function createVoucher($salesLedger=null,$taxLedger=null,$discountLedger=null){
		if(!$salesLedger) $salesLedger = $this->add('xAccount/Model_Account')->loadDefaultSalesAccount();
		if(!$taxLedger) $taxLedger = $this->add('xAccount/Model_Account')->loadDefaultTaxAccount();
		if(!$discountLedger) $discountLedger = $this->add('xAccount/Model_Account')->loadDefaultDiscountAccount();
		
		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('SALES INVOICE', $this, $transaction_date=$this['created_at'], $Narration=null);

		$transaction->addCreditAccount($salesLedger,$this['total_amount']);
		$transaction->addCreditAccount($taxLedger,$this['tax']);
		
		$transaction->addDebitAccount($discountLedger,$this['discount']);
		$transaction->addDebitAccount($this->customer()->account(),$this['net_amount']);

		$transaction->execute();

		return $transaction;

	}

	function payViaCash($cash_amount, $cash_account=null){

		if(!$cash_account) $cash_account = $this->add('xAccount/Model_Account')->loadDefaultCashAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('INVOICE CASH PAYMENT RECEIVED', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addCreditAccount($this->customer()->account(),$cash_amount);
		$transaction->addDebitAccount($cash_account ,$cash_amount);
		

		$transaction->execute();
	}

	function payViaCheque($amount, $cheque_no,$cheque_date,$bank_account_no, $self_bank_account=null)){
		if(!$self_bank_account) $self_bank_account = $this->add('xAccount/Model_Account')->loadDefaultBankAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('INVOICE BANK PAYMENT RECEIVED', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addCreditAccount($this->customer()->account(),$amount);
		$transaction->addDebitAccount($self_bank_account ,$amount);
		
		$transaction->execute();
	}

	function PayViaOnline($transaction_reference,$transaction_reference_data){
		$this['transaction_reference'] =  $transaction_reference;
	    $this['transaction_response_data'] = json_encode($transaction_reference_data);
	    $this->save();
	}

	function submit(){
		$this->setStatus('submitted');
	}

	function approve(){
		$this->createVoucher();
		$this->setStatus('approved');
	}

	
}