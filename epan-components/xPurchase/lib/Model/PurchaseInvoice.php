<?php
namespace xPurchase;

class Model_PurchaseInvoice extends \xShop\Model_Invoice{

	public $root_document_name = 'xPurchase\PurchaseInvoice';

	public $notification_rules = array(
			// 'activity NOT STATUS' => array (....)
			'submitted' => array('xPurchase/Invoice_Submitted/can_approve'=>'New Purchase Invoice subimitted to approve [{supplier}]'),
			'approved' => array('xPurchase/Invoice_Approved/creator' => 'Your Purchase Invoice {purchase_invoice_name} is approved now'),
			'redesign' => array('xPurchase/Invoice_Redesign/creator'=>'Purchase Invoice {name} rejected by {actor} for redesign'),
			'cancelled' => array('xPurchase/Invoice_Canceled/can_view'=>'Purchase Invoice of [{supplier}] canceled by [{employee_name}]'),
			'completed' => array('xPurchase/Invoice_Completed/can_view'=>'Purchase Invoice {purchase_invoice_name} Completed by {employee_name}'),
			'email' => array('xPurchase/PurchaseInvoice/can_send_via_email'=>'Purchase Invoice {purchase_invoice_name} emailed to {supplier} by {employee_name}'),
			'comment' => array('xPurchase/PurchaseInvoice/can_see_activities'=>'New Comment Added by {employee_name} on {purchase_invoice_name}'),
			'call' => array('xPurchase/PurchaseInvoice/can_see_activities'=>'New Activity of {purchase_invoice_name} to see, Communication between {supplier} and {employee}'),
			'sms' => array('xPurchase/PurchaseInvoice/can_see_activities'=>'Purchase Invoice {purchase_invoice_name} Supplier {supplier_name} notify via sms by {employee_name}'),
			'personal' => array('xPurchase/PurchaseInvoice/can_see_activities'=>'personal Communication between {supplier_name} and  {employee_name} on {purchase_invoice_name}'),
			'action' => array('xPurchase/PurchaseInvoice/can_see_activities'=>'Action taken by {employee_name} on {purchase_order_name}')
		);

	function init(){
		parent::init();

		$this->addCondition('type','purchaseInvoice');
		$this->addExpression('invoiceitem_count')->set($this->refSql('xShop/InvoiceItem')->count());
		$this->hasMany('xPurchase/PurchaseOrderItem','invoice_id');
	}

	function forceDelete(){
		$this->ref('xPurchase/PurchaseOrderItem')->each(function($obj){
			$obj->newInstance()->load($obj->id)->set('invoice_id',null)->saveAndUnload();
		});
		
		$this->delete();
	}

	function supplier(){
		return $this->ref('supplier_id');
	}


	function submit(){
		$this->setStatus('submitted');
	}

	function approve(){
		$this->createVoucher();
		$this->setStatus('approved');
	}

	function cancle(){
		if($tr= $this->transaction()){
			$tr->forceDelete();
		}
		$this->setStatus('caneled');
	}

	function createVoucher($purchaseLedger=null,$taxLedger=null,$discountLedger=null){
		if(!$purchaseLedger) $purchaseLedger = $this->add('xAccount/Model_Account')->loadDefaultPurchaseAccount();
		if(!$taxLedger) $taxLedger = $this->add('xAccount/Model_Account')->loadDefaultTaxAccount();
		if(!$discountLedger) $discountLedger = $this->add('xAccount/Model_Account')->loadDefaultDiscountAccount();
		
		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('PURCHASE INVOICE', $this, $transaction_date=$this['created_at'], $Narration=null);
		
		$transaction->addDebitAccount($purchaseLedger,$this['total_amount']);
		$transaction->addDebitAccount($taxLedger,$this['tax']);
		
		$transaction->addCreditAccount($discountLedger,$this['discount']);
		$transaction->addCreditAccount($this->supplier()->account(),$this['net_amount']);

		$transaction->execute();

		return $transaction;

	}

	function payViaCash($cash_amount, $cash_account=null){

		if(!$cash_account) $cash_account = $this->add('xAccount/Model_Account')->loadDefaultCashAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('PURCHASE INVOICE CASH PAYMENT', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addDebitAccount($this->supplier()->account(),$cash_amount);
		$transaction->addCreditAccount($cash_account ,$cash_amount);
		
		$transaction->execute();
	}

	function payViaCheque($amount, $cheque_no,$cheque_date,$bank_account_no, $self_bank_account=null){
		if(!$self_bank_account) $self_bank_account = $this->add('xAccount/Model_Account')->loadDefaultBankAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('PURCHASE INVOICE BANK PAYMENT', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addDebitAccount($this->supplier()->account(),$amount);
		$transaction->addCreditAccount($self_bank_account ,$amount);
		
		$transaction->execute();
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
			$purchase_invoice = $this;
			//CHECK FOR GENERATE INVOICE
			if($form['payment']){
				switch ($form['payment']) {
					case 'cheque':
						if(trim($form['amount']) == "" or $form['amount'] == 0)
							$form->displayError('amount','Amount Cannot be Null');

						if(trim($form['bank_account_detail']) == "")
							$form->displayError('bank_account_detail','Account Number Cannot  be Null');

						if(trim($form['cheque_no']) =="")
							$form->displayError('cheque_no','Cheque Number not valid.');

						if(!$form['cheque_date'])
							$form->displayError('cheque_date','Date Canot be Empty.');

					break;

					case 'cash':
						if(trim($form['amount']) == "" or $form['amount'] == 0)
							$form->displayError('amount','Amount Cannot be Null');
					break;
				}
				
				if($form['payment'] == "cash"){
					$purchase_invoice->payViaCash($form['amount']);
				}
				elseif($form['payment'] == "cheque"){
					$purchase_invoice->payViaCheque($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_detail'],$self_bank_account=null);
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
	
	function itemsTermAndCondition(){
		$tnc = "";
		$item_array = array();
		foreach ($this->itemRows() as $q_item) {
			$item = $q_item->item();
			if(in_array($item->id, $item_array)) continue;

			$tnc .= $item['terms_condition'];
			$item_array[]=$item->id;
		}

		return $tnc;
		
	}
	
	function parseEmailBody(){
		$view=$this->add('xPurchase/View_PurchaseInvoiceDetail');
		$view->setModel($this->itemrows());
		
		$tnc=$this->termAndCondition();


		$supplier = $this->supplier();
		$supplier_email=$supplier->get('email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
		
		// $subject = $config_model['purchase_invoice_email_subject']?:"[ Invoice No.:".$this['name']." ]"." "."::"." "."PURCHASE INVOICE";
		
		$email_body=$config_model['purchase_invoice_email_body']?:"Purchase Invoice Layout Is Empty";
		
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{purchase_invoice_details}}", $view->getHtml(), $email_body);
		$email_body = str_replace("{{company_name}}", $supplier['name'], $email_body);
		$email_body = str_replace("{{owner_name}}", $supplier['owner_name']?$supplier['owner_name']:" ", $email_body);
		$email_body = str_replace("{{supplier_code}}", $supplier['code']?$supplier['code']:" ", $email_body);
		$email_body = str_replace("{{mobile_number}}", $supplier['contact_no']?$supplier['contact_no']:" ", $email_body);
		$email_body = str_replace("{{purchase_order_address}}",$supplier['address']?$supplier['address']:" ", $email_body);
		$email_body = str_replace("{{supplier_email}}", $supplier['email'], $email_body);
		$email_body = str_replace("{{supplier_tin_no}}", $supplier['tin_no']?$supplier['tin_no']:" - ", $email_body);
		$email_body = str_replace("{{supplier_pan_no}}", $supplier['pan_no']?$supplier['pan_no']:" - ", $email_body);
		$email_body = str_replace("{{purchase_Order_no}}", $this['name'], $email_body);
		$email_body = str_replace("{{purchase_Order_date}}", $this['created_at'], $email_body);
		$email_body = str_replace("{{terms_an_conditions}}", $tnc['terms_and_condition']?$tnc['terms_and_condition']:" ", $email_body);
		$email_body = str_replace("{{purchase_invoice_narration}}",$this['narration']?$this['narration']:"", $email_body);
			
		return $email_body;
	}


	function send_via_email_page($p){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
		
		$email_body = $this->parseEmailBody();

		$supplier = $this->supplier();
		$supplier_email=$supplier->get('email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
		
		$emails = explode(',', $supplier['email']);
		
		$form = $p->add('Form_Stacked');
		$form->addField('line','to')->set($emails[0]);
		unset($emails[0]);

		$form->addField('line','cc')->set(implode(',',$emails));
		$form->addField('line','bcc');
		$form->addField('line','subject')->validateNotNull()->set($config_model['purchase_invoice_email_subject']);
		$form->addField('RichText','custom_message');
		$form->add('View')->setHTML($email_body);
		$form->addSubmit('Send');
		if($form->isSubmitted()){
			
			$subject = $this->emailSubjectPrefix($form['subject']);

			$email_body = $form['custom_message']."<br>".$email_body;
			$this->sendEmail($form['to'],$subject,$email_body,explode(',',$form['cc']),explode(',',$form['bcc']));
			$this->createActivity('email',$subject,$form['custom_message'],$from=null,$from_id=null, $to='supplier', $to_id=$supplier->id);
			// $form->js(null,$form->js()->reload())->univ()->successMessage('Send Successfully')->execute();
			return true;
		}
	}

}