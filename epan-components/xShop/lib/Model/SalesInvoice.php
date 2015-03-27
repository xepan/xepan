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



	function submit(){
		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('SALE_INVOICE',$this);

		$transaction->addDebitAccount($this->customer(),$this->netAmount());
		$transaction->addCreditAccount($this->add('xAccount/Model_Account')->loadDefaultSalesAccount(),$this->netAmount());
		$transaction->addCreditAccount($this->add('xAccount/Model_Account')->loadDiscountAccount(),$this->discount());
		$transaction->addCreditAccount($this->add('xAccount/Model_Account')->loadTaxAccount(),$this->discount());

	}
}