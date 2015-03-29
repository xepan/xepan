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

	function submit(){
		$this->setStatus('submitted');
	}

	function approve(){
		$this->createVoucher();
		$this->setStatus('approved');
	}
}