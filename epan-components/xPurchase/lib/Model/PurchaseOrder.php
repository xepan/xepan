<?php
namespace xPurchase;

class Model_PurchaseOrder extends \Model_Document{
	public $table="xpurchase_purchase_order";
	public $status=array('draft','approved','processing','submitted','completed','rejected','redesign','accepted');
	public $root_document_name='xPurchase\PurchaseOrder';
	
	public $notification_rules = array(
		// 'activity NOT STATUS' => array (....)
		'submitted'=>array('xPurchase/PurchaseOrder_Submitted/can_approve'=>'New Purchase Order subimitted to approve [{supplier}]'),
		'approved'=>array(
				'xPurchase/PurchaseOrder_Approved/can_send_via_email'=>'New Purchase Order Approved [{supplier}], can send via email',
				'xPurchase/PurchaseOrder_Draft/creator' => 'Your Purchase Order is approved now'
			),
		
		'redesign' =>array('xPurchase/PurchaseOrder_Draft/creator'=>'Purchase Order {name} rejected to redesign by {actor}'),
		'cancelled' =>array('xPurchase/PurchaseOrder_Cancelled/can_view'=>'Purchase Order cancelled [{supplier}]'),
		'email' => array('xPurchase/PurchaseOrder_Submitted/can_send_via_email'=>'Purchase Order emailed to {supplier}')
	);

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/TermsAndCondition','termsandcondition_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'))->caption('Term and Condition');
		$this->hasOne('xPurchase/Supplier','supplier_id')->sortable(true)->display(array('form'=>'autocomplete/Plus'));
		$this->hasOne('xShop/Priority','priority_id')->group('z~6')->mandatory(true)->defaultValue($this->add('xShop/Model_Priority')->addCondition('name','Medium')->tryLoadAny()->get('id'));
		$this->hasOne('xShop/Currency','currency_id')->sortable(true)->mandatory(true);//->display(array('form'=>'autocomplete/Basic'));
		$this->addField('name')->caption('Purchase Order');
		$this->addField('order_summary')->type('text');
		$this->addField('order_date')->type('datetime')->defaultValue($this->api->now);

		$this->addField('total_amount')->type('money');
		$this->addField('tax')->type('money');
		$this->addField('net_amount')->type('money');
		$this->addField('delivery_to')->type('text');

		$this->hasMany('xPurchase/PurchaseOrderItem','po_id');
		$this->hasMany('xPurchase/PurchaseInvoice','po_id');
		$this->hasMany('xPurchase/PurchaseOrderAttachment','related_document_id',null,'Attachements');

		$this->addHook('beforeDelete',$this);
		$this->addHook('afterSave',$this);

		$this->addExpression('orderitem_count')->set($this->refSQL('xPurchase/PurchaseOrderItem')->count());
		$this->add('dynamic_model/Controller_AutoCreator');
		$this->setOrder('id','desc');
	}

	function afterSave(){
		$shop_config = $this->add('xShop/Model_Configuration')->tryLoadAny();
		if($shop_config['is_round_amount_calculation']){
			$this['net_amount'] = round($this['net_amount'],0);
			$this->save();
		}
	}

	function beforeDelete(){
		$p_in = $this->ref('xPurchase/PurchaseInvoice')->count()->getOne();
		if($p_in)
			throw $this->exception('Cannot Delete, First Delete PurchaseInvoice');

		$this->ref('xPurchase/PurchaseOrderItem')->each(function($item){
			$item->forceDelete();
		});

		$this->ref('Attachements')->each(function($attach){
			$attach->forceDelete();
		});

	}

	function forceDelete(){
		$this->ref('xPurchase/PurchaseInvoice')->each(function($pi){
			$pi->forceDelete();
		});
		
		$this->delete();
	}

	function itemRows(){
		return $this->add('xPurchase/Model_PurchaseOrderItem')->addCondition('po_id',$this['id'])->tryLoadAny();
	}

	function termAndCondition(){
		return $this->ref('termsandcondition_id');
	}

	function submit(){		
		$this->setStatus('submitted');
	}

	function cancle(){
		$this->setStatus('canceled');
	}

	function invoice(){
		return $this->add('xPurchase/Model_PurchaseInvoice')->addCondition('po_id',$this->id)->tryLoadAny();
	}


	function forceDelete_page($page){
		$page->add('View_Warning')->set('All Purchase order Item, and Invoice will be delete');
		$str = "";
		$ois = $this->purchaseOrderItems();
		foreach ($ois as $oi) {
			$str.= " Item :: ".$oi['item_name']."<br>";
		}
		
		$invcs = $this->invoice();
		foreach ($invcs as $invc) {
			$str.= "Invoices <br>";
			$str.= $invc['name'];
		}

		$page->add('View')->setHtml($str);

		$form = $page->add('Form');
		$form->addField('checkbox','delete_invoice_also')->set(true);
		$form->addSubmit('ForceDelete');

		if($form->isSubmitted()){
			foreach ($ois as $oi) {
				$oi->delete();
			}
			foreach ($invcs as $inc) {
				$inc->delete();
			}
			$this->delete();
			return true;
		}

	}

	function approve_page($page){
		$page->add('View')->set('Advanced Payment');
		$form = $page->add('Form_Stacked');
		$form->addField('DropDown','payment')->setValueList(array('cheque'=>'Bank Account/Cheque','cash'=>'Cash'))->setEmptyText('Select Payment Mode');
		$form->addField('Money','amount');
		$form->addField('line','bank_account_detail');
		$form->addField('line','cheque_no');
		$form->addField('DatePicker','cheque_date');
		$form->addSubmit('Approve & Pay Advance');
		if($form->isSubmitted()){

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
				
				if($form['payment'] == "cash")
					$this->cashAdvance($form['amount']);
				
				if($form['payment'] == "cheque")
					$this->bankAdvance($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_detail'],$self_bank_account=null);
				
			}
				
			$this->approve();			
			return true;
		}

	}


	function approve(){
		//TODO SEND MAIL
			//COMMUNICATION LOG ENTRY
		$this['order_date']=$this->api->now;
		$this->save();
		//Change PurchaseOrderItem Stautus Waiting to Processing
		$ois = $this->itemRows();
		foreach ($ois as $oi) {
			$oi->addCondition('status','waiting')->tryLoadAny();
			if($oi->loaded()){
				$oi['status'] = "processing";
				$oi->saveAndUnload();
			}
		}

		$this->setStatus('approved');
	}

	function reject(){
		$this->setStatus('rejected');
	}

	function redesign(){
		$this->setStatus('redesign');
	}

	function accept(){
		$this->setStatus('accepted');
	}

	function start_processing(){
		$this->setStatus('processing');
		//TODO
	}

	function setStatus($status){
		parent::setStatus($status);
	}

	function mark_processed_page($page){
		$ois = $this->itemRows();
		$ois->addCondition('invoice_id',null)->tryLoadAny();
		
		$form = $page->add('Form_Stacked',null,null,array('form/minimal'));
		$th = $form->add('Columns');
		$th_name =$th->addColumn(1);
		$th_name->add('H4')->set('S.No');
		$th_name =$th->addColumn(4);
		$th_name->add('H4')->set('Items');
		$th_qty =$th->addColumn(2);
		$th_qty->add('H4')->set('Order Qty');
		$th_received_qty = $th->addColumn(2);
		$th_received_qty->add('H4')->set('Received Qty');
		$th_receive_qty = $th->addColumn(3);
		$th_receive_qty->add('H4')->set('Receive Qty');
		// $form = $page->add('Form');
		$i = 1;
		foreach ($ois as $oi) {
			$c = $form->add('Columns');
			$c0 = $c->addColumn(1);
			$c0->addField('Readonly','item_sno')->set($i);
			$c1 = $c->addColumn(4);
			$c1->addField('Readonly','item_name_'.$oi->id)->set($oi['item_name']);
			$c2 = $c->addColumn(2);
			$c2->addField('Readonly','item_qty_'.$oi->id)->set($oi['qty']." ".$oi['unit']);
			$c3 = $c->addColumn(2);
			$c3->addField('Readonly','item_received_before_qty_'.$oi->id)->set($oi['received_qty']?:0);
			$c4 = $c->addColumn(3);
			$c4->addField('Number','item_received_qty_'.$oi->id)->set(0);
			// $c4 = $c->addColumn(2);
			// $c4->addField('Checkbox','item_received_'.$i);
			$i++;
		}

		$page->add('H3')->set('Items for Receive');
		// $grid = $page->add('Grid');
		// $grid->setModel($ois);

		// $grid->removeColumn('custom_fields');
		// $grid->removeColumn('item');
		
		$form->addField('line','received_via');
		$form->addField('line','delivery_docket_no','Docket No / Person name / Other Reference');
		$form->addField('text','received_narration');
		$form->addField('Checkbox','generate_purchase_invoice');
		$form->addField('DropDown','include_items')->setValueList(array('Selected'=>'Selected Only','All'=>'All Ordered Items'))->setEmptyText('Please Select');
		$form->addField('DropDown','payment')->setValueList(array('cheque'=>'Bank Account/Cheque','cash'=>'Cash'))->setEmptyText('Select Payment Mode');
		$form->addField('Money','amount');
		$form->addField('line','bank_account_detail');
		$form->addField('line','cheque_no');
		$form->addField('DatePicker','cheque_date');
		$form->addField('Checkbox','keep_open');

		$include_field = $form->addField('hidden','selected_items');

		// $grid->addSelectable($include_field);

		$page->add('H3')->set('Items Received');
		$grid = $page->add('Grid');
		$grid->setModel($this->itemRows(),array('item','item_name','qty','received_qty','custom_fields'));
		$grid->removeColumn('custom_fields');
		$grid->removeColumn('item');
		
		$receive_btn = $form->addSubmit('Receive and Pay');

		if($form->isSubmitted()){
			//Selected Item Array
			$items_selected = array();
			$i = 1;
			foreach ($ois as $oi) {
				if($form['item_received_qty_'.$oi->id] > 0){
					$items_selected [] = $oi->id ;
					// $items_selected [$oi->id]['received_qty'] = $form['item_qty_'.$i];
					// $items_selected [$oi->id]['qty'] = $form['item_qty_'.$i] ;
					// $items_selected [$oi->id]['received_qty'] = $form['item_received_qty_'.$i];
				}
				$i++;
			}

			if(empty($items_selected))
				throw $this->Exception('No Item Selected','Growl');
			// $items_selected = json_decode($form['selected_items'],true);			
					
			if($form['payment']){//Payment Validation Checked
				switch ($form['payment']) {
					case 'cheque':
						if(trim($form['amount']) == "" or $form['amount']==0)
							$form->displayError('amount','Amount Cannot be Null');

						if(trim($form['bank_account_detail']) == "")
							$form->displayError('bank_account_detail','Account Number Cannot  be Null');

						if(trim($form['cheque_no']) =="")
							$form->displayError('cheque_no','Cheque Number not valid.');

						if(!$form['cheque_date'])
							$form->displayError('cheque_date','Date Canot be Empty.');

					break;
					case 'cash':
						if(trim($form['amount']) == "" or $form['amount']==0)
							$form->displayError('amount','Amount Cannot be Null');
					break;
				}
			}

			//CHECK FOR GENERATE INVOICE
			if($form['generate_purchase_invoice']){
				if($form['include_items'] == "")
					$form->displayError('include_items','Please Select');

				//Check for the Invoice Already Created or Not
				$count = $this->itemRows()->addCondition('invoice_id','<>',null)->count()->getOne();
				if( $count and $form['include_items'] == "All"){
					$form->displayError('include_items',$count.' item\'s already in invoice, select selected option ' );
				}

				//GENERATE INVOICE FOR SELECTED / ALL ITEMS
				if($form['include_items']=='All'){
					$items_selected=array();
					foreach ($this->itemRows() as $itm) {
						$items_selected [] = $itm->id;
					}
				}
				
				
				$purchase_invoice = $this->createInvoice($status='approved',$purchaseLedger=null, $items_selected);
				// throw new \Exception("Error Processing Request", 1);
				
				if($form['payment'] == "cash")
					$purchase_invoice->payViaCash($form['amount']);
				
				if($form['payment'] == "cheque")
					$purchase_invoice->payViaCheque($form['amount'],$form['cheque_no'],$form['cheque_date'],$form['bank_account_no'],$self_bank_account=null);
			}

			//WAREHOUSE ENTRY
			// $items_selected = json_decode($form['selected_items'],true);
			$to_warehouse = $this->add('xStore/Model_Warehouse')->loadPurchase();
			$movement_challan = $to_warehouse->newPurchaseReceive($this);
			foreach ($this->itemRows() as $ir) {
				if(!in_array($ir->id, $items_selected)) continue;
				$movement_challan->addItem($ir->item(),$form['item_received_qty_'.$ir->id],$ir['unit'],$ir['custom_fields']);
				
				//PurchaseOrderItem Receievd Qty Add
				$ir['received_qty'] = $ir['received_qty'] + $form['item_received_qty_'.$ir->id];
				$ir->save();
			}

			$movement_challan->executePurchase($add_to_stock=true);

			if(!$form['keep_open'])
				$this->setStatus('completed');
			return true;
			// if($form['include_items'] == 'Selected'){
			// 	if($this->itemRows()->addCondition('invoice_id',null)->count()->getOne() == 0)
			// }else	
			// 	$this->setStatus('processing');
		}


	}

	function supplier(){
		return $this->ref('supplier_id');
	}

	function purchaseOrderItems(){
		return $this->itemRows();
	}

	function createInvoice($status='draft',$purchaseLedger=null, $items_array=array()){
		
		// try{
			// $this->api->db->beginTransaction();
			$invoice = $this->add('xPurchase/Model_PurchaseInvoice')->addCondition('status', $status)->tryLoadAny();

			$invoice['po_id'] = $this['id'];
			$invoice['supplier_id'] = $this->supplier()->get('id');
			$invoice['total_amount'] = $this['total_amount'];
			$invoice['tax'] = $this['tax'];
			
			$invoice->relatedDocument($this);

			$invoice['net_amount'] = $this['net_amount'];
			$invoice->save();
			

			$ois = $this->purchaseOrderItems();
			foreach ($ois as $oi) {
				// or !in_array($oi->id, $items_array) 
				if(count($items_array) AND !in_array($oi->id,$items_array)) continue;
				
				if($oi->invoice())
					throw $this->exception('Order Item already used in Invoice','ValidityCheck');

				$invoice->addItem(
						$oi->item(),
						$oi['qty'],
						$oi['rate'],
						$oi['amount'],
						$oi['unit'],
						$oi['narration'],
						$oi['custom_fields']
					);
				$oi->invoice($invoice);	
			}

			if($status !== 'draft' and $status !== 'submitted'){
				$invoice->createVoucher($purchaseLedger);
			}
			
			// $this->api->db->commit();
			return $invoice;
		// }catch(\Exception $e){
		// 	echo $e->getmessage();
		// 	$this->api->db->rollback();
		// 	// if($this->api->getConfig('developer_mode',false))
		// 	// 	throw $e;
		// }
	}
	

	function cashAdvance($cash_amount, $cash_account=null){

		if(!$cash_account) $cash_account = $this->add('xAccount/Model_Account')->loadDefaultCashAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('PURCHASE ORDER ADVANCE CASH PAYMENT GIVEN', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addCreditAccount($cash_account,$cash_amount);
		$transaction->addDebitAccount($this->supplier()->account() ,$cash_amount);
		

		$transaction->execute();
	}

	function bankAdvance($amount, $cheque_no,$cheque_date,$bank_account_detail, $self_bank_account=null){
		if(!$self_bank_account) $self_bank_account = $this->add('xAccount/Model_Account')->loadDefaultBankAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('PURCHASE ORDER ADVANCE BANK PAYMENT GIVEN', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addDebitAccount($this->supplier()->account(),$amount);
		$transaction->addCreditAccount($self_bank_account ,$amount);
		
		$transaction->execute();
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
		
		$tnc = $this->termAndCondition();
		$tnc = $tnc['terms_and_condition'].$this->itemsTermAndCondition();

		$view=$this->add('xPurchase/View_PurchaseOrderDetail');
		$view->setModel($this->itemrows());		
		$supplier = $this->supplier();
		$supplier_email=$supplier->get('email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();		
		
		$email_body=$config_model['purchase_order_detail_email_body']?:"Purchase Order Layout Is Empty";
	
		// $email_body = $print_order->getHTML(false);
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{purchase_order_details}}", $view->getHtml(), $email_body);
		$email_body = str_replace("{{company_name}}", $supplier['name']?$supplier['name']:" ", $email_body);
		$email_body = str_replace("{{owner_name}}", $supplier['owner_name']?$supplier['owner_name']:" ", $email_body);
		$email_body = str_replace("{{supplier_code}}", $supplier['code']?$supplier['code']:" ", $email_body);
		$email_body = str_replace("{{mobile_number}}", $supplier['contact_no']?$supplier['contact_no']:" ", $email_body);
		$email_body = str_replace("{{supplier_email}}", $supplier['email']?$supplier['email']:" ", $email_body);
		$email_body = str_replace("{{purchase_order_address}}",$supplier['address']?$supplier['address']:" ", $email_body);
		$email_body = str_replace("{{supplier_tin_no}}", $supplier['tin_no']?$supplier['tin_no']:" - ", $email_body);
		$email_body = str_replace("{{supplier_pan_no}}", $supplier['pan_no']?$supplier['pan_no']:" - ", $email_body);
		$email_body = str_replace("{{purchase_order_no}}", $this['name'], $email_body);
		$email_body = str_replace("{{purchase_order_date}}", $this['created_date'], $email_body);
		$email_body = str_replace("{{delivery_to}}", $this['delivery_to'], $email_body);
		$email_body = str_replace("{{terms_and_conditions}}", $tnc?$tnc:" ", $email_body);
		$email_body = str_replace("{{purchase_order_summary}}", $this['order_summary'], $email_body);
		//END OF REPLACING VALUE INTO ORDER DETAIL EMAIL BODY

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
		// array_pop(array_re/verse($emails));
		unset($emails[0]);

		$form->addField('line','cc')->set(implode(',',$emails));
		$form->addField('line','bcc');
		$form->addField('line','subject')->validateNotNull()->set($config_model['purchase_order_detail_email_subject']);
		$form->addField('RichText','custom_message');
		$form->add('View')->setHTML($email_body);
		$form->addSubmit('Send');
		if($form->isSubmitted()){
			$subject = $this->emailSubjectPrefix($form['subject']);

			$ccs=$bccs = array();
			if($form['cc'])
				$ccs = explode(',',$form['cc']);

			if($form['bcc'])
				$bccs = explode(',',$form['bcc']);

			$email_body = $form['custom_message']."<br>".$email_body;
			$this->sendEmail($form['to'],$subject,$email_body,$ccs,$bccs);
			$this->createActivity('email',$subject,$form['custom_message'],$from=null,$from_id=null, $to='Supplier', $to_id=$supplier->id);
			//$form->js(null,$form->js()->reload())->univ()->successMessage('Send Successfully')->execute();
			return true;
		}
	}

	function currency($name=1){
		if($name)
			return $this->ref('currency_id')->get('name');
		
		return $this->ref('currency_id');
	}
}

