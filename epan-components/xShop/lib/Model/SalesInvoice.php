<?php
namespace xShop;

class Model_SalesInvoice extends Model_Invoice{
	public $root_document_name = 'xShop\SalesInvoice';
	public $actions=array(
			'can_view'=>array(),
			'can_reject'=>array(),
			'can_send_via_email'=>array(),
			'allow_edit'=>array(),

		);

	function init(){
		parent::init();

		$this->hasMany('xShop/OrderDetails','invoice_id',null,'UsedInOrderDetails');

		$this->addCondition('type','salesInvoice');

		$this->addExpression('invoiceitem_count')->set($this->refSql('xShop/InvoiceItem')->count());
	}

	function forceDelete(){
		$this->ref('UsedInOrderDetails')->each(function($obj){$obj->newInstance()->load($obj->id)->set('invoice_id',null)->save();});
		$this->delete();
	}

	function orderItem(){
		if(!$this['orderitem_id']){
			return false;
		}
		return $this->ref('orderitem_id');
	}


	function customer(){
		return $this->ref('customer_id');
	}

	// function transaction(){
	// 	$tr = $this->add('xAccount/Model_Transaction')->loadWhoseRelatedDocIs($this);
	// 	if($tr and $tr->loaded()) return $tr;
	// 	return false;
	// }

	function createVoucher($salesLedger=null,$taxLedger=null,$discountLedger=null){		
		if(!$salesLedger) $salesLedger = $this->add('xAccount/Model_Account')->loadDefaultSalesAccount();
		if(!$taxLedger) $taxLedger = $this->add('xAccount/Model_Account')->loadDefaultTaxAccount();
		if(!$discountLedger) $discountLedger = $this->add('xAccount/Model_Account')->loadDefaultDiscountAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('SALES INVOICE', $this, $transaction_date=$this['created_at'], $Narration=null);

		$transaction->addCreditAccount($salesLedger,$this['total_amount']);
		$transaction->addCreditAccount($taxLedger,$this['tax']);
		
		$transaction->addDebitAccount($discountLedger,$this['discount']);
		$transaction->addDebitAccount($this->customer()->account(),$this['net_amount']-$this['discount']);

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

	function payViaCheque($amount, $cheque_no,$cheque_date,$bank_account_no, $self_bank_account=null){
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

	    if(!$self_bank_account) $self_bank_account = $this->add('xAccount/Model_Account')->loadDefaultBankAccount();

	    $transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('INVOICE ONLINE PAYMENT RECEIVED', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addCreditAccount($this->customer()->account(),$amount);
		$transaction->addDebitAccount($self_bank_account ,$amount);
		
		$transaction->execute();
	}

	function submit(){
		$this->setStatus('submitted');
	}

	function approve(){
		$this->createVoucher();
		$this->setStatus('approved');
	}

	function cancel_page($p){
		$transaction = $this->add('xAccount/Model_Transaction');
		$form = $p->add('Form');
		$form->addField('text','reason');

		if($tr=$transaction->loadWhoseRelatedDocIs($this)){
			$form->addField('CheckBox','remove_related_transaction');
		}

		$form->addSubmit('Sure');
		
		if($form->isSubmitted()){
			if($tr){
				$tr->forceDelete();
				$this->cancel($form['reason']);
			}
			return true;
		}
	}

	function cancel($reason){
		if($tr= $this->transaction()){
			$tr->forceDelete();
		}
		$this->setStatus('canceled',$reason);
	}

	function mark_processed_page($p){
		$form = $p->add('Form_Stacked');
		$form->addField('DropDown','payment')->setValueList(array('cheque'=>'Bank Account/Cheque','cash'=>'Cash'))->setEmptyText('Select Payment Mode');
		$form->addField('Money','amount');
		$form->addField('line','bank_account_detail');
		$form->addField('line','cheque_no');
		$form->addField('DatePicker','cheque_date');
		$form->addField('Checkbox','send_invoice_via_email');
		$form->addField('line','email_to');



		$form->addSubmit('PayNow');

		if($form->isSubmitted()){
			$invoice = $this;
			//CHECK FOR GENERATE INVOICE
			if($form['payment']){
				switch ($form['payment']) {
					case 'cheque':
						if(trim($form['cheque_no']) =="")
							$form->displayError('cheque_no','Cheque Number not valid.');

						if(!$form['cheque_date'])
							$form->displayError('cheque_date','Date Canot be Empty.');

						if(trim($form['bank_account_detail']) == "")
							$form->displayError('bank_account_detail','Account Number Cannot  be Null');
					break;

					default:
						if(trim($form['amount']) == "")
							$form->displayError('amount','Amount Cannot be Null');
					break;
				}
				
				if($form['payment'] == "cash"){					
					$invoice->payViaCash($form['amount']);
				}
				elseif($form['payment'] == "cheque"){
					$invoice->payViaCheque($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_detail'],$self_bank_account=null);
				}
			}

		if($form['send_invoice_via_email']){
			$inv = $this->order()->invoice();
			
			if(!$inv){
				$form->displayError('send_invoice_via_email','Invoice Not Created. ');
			}
			
			if(!$inv->isApproved())
				$form->displayError('send_invoice_via_email','Invoice Not Approved. '. $inv['name']);

			if(!$form['email_to'])
				$form->displayError('email_to','Email Not Proper. ');

			$inv->send_via_email();

		}
			$this->setStatus('completed');
			return true;

		}
		
	}



}