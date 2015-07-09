<?php
namespace xShop;

class Model_SalesInvoice extends Model_Invoice{
	public $root_document_name = 'xShop\SalesInvoice';
	public $actions=array(
			'can_view'=>array(),
			'can_send_via_email'=>array('caption'=>'E-mail'),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_cancel'=>array(),
			'update_from_order'=>array(),
		);

	function init(){
		parent::init();
		$this->getElement('created_at')->system(false)->visible(true)->editable(true);
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

	function createVoucher($salesLedger=null,$taxLedger=null,$discountLedger=null,$roundLedger=null,$shippingLedger=null){
		if(!$salesLedger) $salesLedger = $this->add('xAccount/Model_Account')->loadDefaultSalesAccount();
		if(!$taxLedger) $taxLedger = $this->add('xAccount/Model_Account')->loadDefaultTaxAccount();
		if(!$discountLedger) $discountLedger = $this->add('xAccount/Model_Account')->loadDefaultDiscountAccount();
		if(!$roundLedger) $roundLedger = $this->add('xAccount/Model_Account')->loadDefaultRoundAccount();
		if(!$shippingLedger) $shippingLedger = $this->add('xAccount/Model_Account')->loadDefaultShippingAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('SALES INVOICE', $this, $transaction_date=$this['created_at'], $Narration=null);

		$transaction->addCreditAccount($salesLedger,$this['total_amount']);
		$transaction->addCreditAccount($taxLedger,$this['tax']);
		$transaction->addCreditAccount($shippingLedger,$this['shipping_charge']);
		
		$transaction->addDebitAccount($discountLedger,$this['discount']);
		$transaction->addDebitAccount($this->customer()->account(),$this->round($this['gross_amount'] + $this['shipping_charge']- $this['discount']));
		
		$round_value = $this['net_amount'] - ( $this['gross_amount'] + $this['shipping_charge'] - $this['discount']);

		if($round_value > 0)
			$transaction->addCreditAccount($roundLedger,abs($round_value));
		else
			$transaction->addDebitAccount($roundLedger,abs($round_value));

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
		return $transaction;
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
		$this['created_at'] = date('Y-m-d H:i:s');
		$this->save();

		$this->createVoucher();
		$this->setStatus('approved');
	}

	function transactions(){
		$transaction = $this->add('xAccount/Model_Transaction');
		if($tr=$transaction->loadWhoseRelatedDocIs($this)){
			return $tr;
		}

		return false;	
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
		$form->addField('Checkbox','send_receipt');
		$form->addField('Checkbox','send_invoice_via_email');
		$form->addField('line','email_to')->set($this->customer()->get('customer_email'));



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
					$new_transaction = $invoice->payViaCash($form['amount']);
				}
				elseif($form['payment'] == "cheque"){
					$invoice->payViaCheque($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_detail'],$self_bank_account=null);
				}
			}

		if($form['send_receipt']){
			if(!$form['email_to'])
				$form->displayError('email_to','Email Not Proper. ');

			$transcation_model=$this->add('xAccount/Model_Transaction');
			if(isset($new_transaction)){
				$transcation_model->load($new_transaction->id);
				$transcation_model->sendReceiptViaEmail($form['email_to']);
				$this->createActivity('email',$subject,"Payment Receipt (".$this['name'].")",$from=null,$from_id=null, $to='Customer', $to_id=$this->customer()->id);
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
			

			// $customer=$this->customer();

			$subject = $this->emailSubjectPrefix("");
			$this->sendEmail($form['email_to'],$subject,$this->parseEmailBody());

			$this->createActivity('email',$subject,"Advanced PAYMENT Invoice Paid (".$this['name'].")",$from=null,$from_id=null, $to='Customer', $to_id=$this->customer()->id);
		}
			$this->setStatus('completed');
			return true;


		}
		
	}


	function update_from_order_page($page){
		if(!$this['sales_order_id']){
			$page->add('View_Error')->set('Invoice Not Generated From Order');
			return false;
		}

		$col = $page->add('Columns');
		$col1 = $col->addColumn(6);
		$col2 = $col->addColumn(6);
		$col1->add('H3')->set('Order Items Not Included in Invoice')->addClass('atk-swatch-red atk-padding-small');
		$col2->add('H3')->set('Items Included in Invoice')->addClass('atk-swatch-green atk-padding-small');
		
		$invoice_items = $this->itemrows();
		if($order = $this->order()){
			$order_items = $order->itemrows();
			$order_items->addCondition('invoice_id',null);
		}

		$invoice_items_grid = $col2->add('Grid');
		$order_items_grid = $col1->add('Grid');

		$order_items_grid->setModel($order_items,array('name','qty','rate','amount','tax_per_sum','tax_amount','texted_amount'));
		$invoice_items_grid->setModel($invoice_items,array('item','qty','rate','amount','tax_per_sum','tax_amount','texted_amount'));
		
		$form = $col1->add('Form');
		$order_items_field = $form->addField('hidden','order_items');
		$form->addSubmit('Update Invoice');
		$order_items_grid->addSelectable($order_items_field);

		if($form->isSubmitted()){
			$js = array(
					$invoice_items_grid->js()->reload(),
					$order_items_grid->js()->reload()
				);
			$array = json_decode($form['order_items']);
			if( !count($array))
				$form->js(null,$js)->univ()->errorMessage('Select Order Items')->execute();
			
			$this->update_from_order($form['order_items']);
			$form->js(null,$js)->univ()->successMessage('Invoice Updated')->execute();
		}


	}


	function update_from_order($json){

		$array = json_decode($json);
			foreach ($array as $key => $value) {
				$oi = $this->add('xShop/Model_OrderDetails')->load($value);				
				$this->addItem(
						$oi->item(),
						$oi['qty'],
						$oi['rate'],
						$oi['amount'],
						$oi['unit'],
						$oi['narration'],
						$oi['custom_fields'],
						$oi['apply_tax'],
						$oi['tax_id']
					);
				$oi->invoice($this);
		}
	}

}