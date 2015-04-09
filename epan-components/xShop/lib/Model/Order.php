<?php

namespace xShop;

class Model_Order extends \Model_Document{
	public $table='xshop_orders';
	public $status = array('draft','submitted','approved','processing','processed','dispatched',
							'complete','cancel','return','redesign');
	public $root_document_name = 'xShop\Order';

	function init(){
		parent::init();
		
 		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/PaymentGateway','paymentgateway_id');
		$this->hasOne('xShop/TermsAndCondition','termsandcondition_id')->display(array('form'=>'autocomplete/Basic'))->caption('Terms & Cond.');
		$this->hasOne('xShop/Priority','priority_id')->group('z~6')->mandatory(true)->defaultValue($this->add('xShop/Model_Priority')->addCondition('name','Medium')->tryLoadAny()->get('id'));

		$f = $this->hasOne('xShop/Customer','member_id')->group('a~3')->sortable(true)->display(array('form'=>'autocomplete/Plus'))->caption('Customer')->mandatory(true);
		$f->icon = "fa fa-user~red";
		$f = $this->addField('name')->caption('Order ID')->mandatory(true)->group('a~3')->sortable(true);
		$f = $this->addField('email')->group('a~3')->sortable(true);
		$f = $this->addField('mobile')->group('a~3')->sortable(true);
	
		$this->addExpression('search_phrase')->set($this->dsql()->concat(
				'Order No - ',
				$this->getElement('name'),
				' [',
				$this->refSQL('member_id')->fieldQuery('customer_search_phrase'),
				' ]'
			));

		$this->addField('order_from')->enum(array('online','offline'))->defaultValue('offline');
		$f = $this->getElement('status')->group('a~2');

		$f = $this->addField('total_amount')->type('money')->mandatory(true)->group('b~3~<i class="fa fa-money"></i> Order Amount')->sortable(true);
		$f = $this->addField('gross_amount')->type('money')->mandatory(true)->group('b~3~<i class="fa fa-money"></i> Order Amount')->sortable(true);
		$f = $this->addField('discount_voucher')->group('b~3');
		$f = $this->addField('discount_voucher_amount')->group('b~3');
		$f = $this->addField('tax')->type('money')->group('b~3');
		$f = $this->addField('net_amount')->type('money')->mandatory(true)->group('b~3')->sortable(true);

		$f = $this->addField('billing_address')->mandatory(true)->group('x~6~<i class="fa fa-map-marker"> Address</i>');
		$f = $this->addField('shipping_address')->mandatory(true)->group('x~6');	
		$f = $this->addField('order_summary')->type('text')->group('y~12');
		$f = $this->addField('delivery_date')->type('date')->group('z~6');

		// Payment GateWay related Info
		$this->addField('transaction_reference');
		$this->addField('transaction_response_data')->type('text');

		// Last OrderItem Status
		$dept_status = $this->add('xShop/Model_OrderItemDepartmentalStatus',array('table_alias'=>'ds'));
		$oi_j = $dept_status->join('xshop_orderDetails','orderitem_id');
		$oi_j->addField('order_id');
		$dept_status->addCondition($dept_status->getELement('order_id'),$this->getElement('id'));
		$dept_status->_dsql()->limit(1)->order($dept_status->getElement('id'),'desc')->where('status','<>','Waiting');
		
		
		$this->addExpression('last_action')->set(function ($m, $q) use($dept_status){
			return $dept_status->_dsql()->del('fields')
				->field(
					$dept_status->dsql()->concat(
						$dept_status->getELement('orderitem'),
						' ',
						$dept_status->getElement('status')
						)
					);
		})->caption('Last OrderItem Action');


		$this->hasMany('xShop/OrderDetails','order_id');
		$this->hasMany('xShop/SalesOrderAttachment','related_document_id',null,'Attachements');
		$this->hasMany('xShop/SalesInvoice','sales_order_id');
		
		$this->addExpression('orderitem_count')->set($this->refSQL('xShop/OrderDetails')->count());
		
		$this->addHook('afterSave',$this);
		$this->addHook('beforeDelete',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterSave(){
		$this->updateAmounts();
	}

	function relatedActivity(){
		$activities = $this->add('xCRM/Model_Activity');
		$activities->addCondition('related_root_document_name',$this->root_document_name);
		$activities->addCondition('related_document_id',$this->id);
		return $activities->tryLoadAny();

	}

	function deliveryNotes(){
		$delivery_notes = $this->add('xDispatch/Model_DeliveryNote');
		$delivery_notes->addCondition('order_id',$this->id);
		return $delivery_notes->tryLoadAny();

	}

	
	function forceDelete_page($page){
		$page->add('View_Warning')->set('All Item, Jobcard, Invoice and Attachments will be delete');
		$str = "";
		//get all item_jobcard with status
		$ois = $this->orderItems();
		foreach ($ois as $oi) {
			$str.= " Item :: ".$oi['name']."<br>";
			// Related Jobcards
			$jcs = $oi->jobCards();
			foreach ($jcs as $jc) {
				$str.= "JobCard No. ".$jc['name']." Department ".$jc['to_department']." :: ". $jc['status']."<br>";
			}
		}

		//Related Invoice
		$inv = $this->invoice();
		if($inv and $inv->loaded())
			$str .= "<br> Invoice No. :: ".$this->invoice()->get('name');
		
		$dns = $this->deliveryNotes();
		//Related DeliveryNote
		foreach ($dns as $dn) {
			$str .= "<br> DeliveryNote :: ".$dn['docket_no']." :: ".$dn['narration'];
		}

		$page->add('View')->setHtml($str);
		//Related activity
		$page->add('Grid')->setModel($this->relatedActivity());
		//Related Financial Account
		//Create the log 
		//and delete all related above-4 functionality
		$form = $page->add('Form');
		$form->addField('checkbox','delete_invoice_also')->set(true);
		$form->addSubmit('ForceDelete');

		if($form->isSubmitted()){
			foreach ($ois as $oi) {
				//ORDER DETAIL (ITEMS) DELETE
				//Create Log
				$oi->delete();
			}
			$invs = $this->invoice();
			if($form['delete_invoice_also'] and $invs){
				foreach ($invs as $inv) {
					//Create Log
					$invs->delete();
				}
			}elseif($invs){
				foreach ($invs as $inv) {
					$inv['sales_order_id'] = null;
					$inv->saveAndUnload();
				}
				// if($invs->count()->getOne()){
				// 	$form->displayError('delete_invoice_also','First Delete it\'s Invoice ( '.$invs->count()->getOne()." )" );
				// }
			}
			//ORDER DELETE
			//create Log
			$this->delete();
			return true;
		}

	}

	function beforeDelete($m){

		if($m['discount_voucher'] != null and $m['discount_voucher'] != 0 ){
			$discountvoucher = $this->add('xShop/Model_DiscountVoucher');		
			$discountvoucher->addCondition('name',$m['discount_voucher']);
			$discountvoucher->tryLoadAny();
			if($discountvoucher->loaded()){
				$voucher_used = $discountvoucher->ref('xShop/DiscountVoucherUsed');
				$voucher_used->addCondition('member_id',$m['member_id']);
				$voucher_used->tryLoadAny();
				$voucher_used->delete();
			}
		}

	}

	function placeOrderFromCart(){
		// $billing_address=$order_info['address'].", ".$order_info['landmark'].", ".$order_info['city'].", ".$order_info['state'].", ".$order_info['country'].", ".$order_info['pincode'];
		// $shipping_address=$order_info['shipping_address'].", ".$order_info['s_landmark'].", ".$order_info['s_city'].", ".$order_info['s_state'].", ".$order_info['s_country'].", ".$order_info['s_pincode'];
		$member = $this->add('xShop/Model_MemberDetails');
		$member->loadLoggedIn();

		$cart_items=$this->add('xShop/Model_Cart');
		$this['member_id'] = $member->id;
		$this['status'] = "submitted";
		$this['order_from'] = "online";
		// $this['billing_address'] = $billing_address;
		// $this['shipping_address'] = $shipping_address;		
		$this->save();
			$total_amount=0;
			foreach ($cart_items as $junk) {
				$order_details=$this->add('xShop/Model_OrderDetails');
				$item_model = $this->add('xShop/Model_Item')->load($cart_items['item_id']);

				$order_details['order_id']=$this->id;
				$order_details['item_id']=$cart_items['item_id'];
				$order_details['qty']=$cart_items['qty'];
				$order_details['rate']=$cart_items['sales_amount'];//get Item Rate????????????????
				$order_details['amount']=$cart_items['total_amount'];
				$order_details['custom_fields']= $item_model->customFieldsRedableToId(json_encode($cart_items['custom_fields']));//json_encode($cart_items['custom_fields']);
				$total_amount+=$order_details['amount'];
				$order_details->save();
			}

			$this['amount']=$total_amount;
			
			//$discount_voucher_amount = 0; 
			//TODO NET AMOUNT, TAXES, DISCOUNT VOUCHER AMOUNT etc.. CALCULATING AGAIN FOR SECURITY REGION 
			// $discountvoucher=$this->add('xShop/Model_DiscountVoucher');
			// if($discountvoucher->isUsable($order_info['discount_voucher'])){
			// 	$discount_voucher_amount=$total_amount * $discountvoucher->isUsable($order_info['discount_voucher']) /100;	
			// }
			// $this['discount_voucher']=$order_info['discount_voucher'];
			// $this['discount_voucher_amount']=$discount_voucher_amount;
			$this['net_amount'] = $total_amount;
			$this->save();
			echo "placeOrderFromCart";
			
			// $discountvoucher->processDiscountVoucherUsed($this['discount_voucher']);
			return $this;
	}

	function payNow($transaction_reference,$transaction_reference_data){
		$this['transaction_reference'] =  $transaction_reference;
	    $this['transaction_response_data'] = json_encode($transaction_reference_data);
	    $this->save();
	}
	

	function getAllOrder($member_id){
		if($this->loaded())
			throw new \Exception("member model loaded nahi hona chahiye");	
			// $this->api->js(true)->univ()->errorMessage('Member Model Loded nahi hona chahiye');
		 return $this->addCondition('member_id',$member_id);
		// throw new \Exception($member['']);
	}

	function updateAmounts(){
		$this['total_amount']=0;
		$this['gross_amount']=0;
		$this['tax']=0;
		$this['net_amount']=0;
		
		foreach ($this->itemRows() as $oi) {
			$this['total_amount'] = $this['total_amount'] + $oi['amount'];
			$this['gross_amount'] = $this['gross_amount'] + $oi['texted_amount'];
			$this['tax'] = $this['tax'] + $oi['tax_amount'];
			$this['net_amount'] = $this['total_amount'] + $this['tax'] - $this['discount_voucher_amount'];
		}
		$this->save();
	}

	function send_via_email_page($email_id=null, $order_id=null){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
		
		$subject ="Thanku for Order";
		$customer = $this->customer();
		$customer_email=$customer->get('customer_email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
		
		$print_order=$this->add('xShop/View_PrintOrder');
		$print_order->setModel($this);

		if($config_model['order_detail_email_subject']){
			$subject=$config_model['order_detail_email_subject'];
		}

		if($config_model['order_detail_email_body']){
			$email_body=$config_model['order_detail_email_body'];		
		}
		
		
		$email_body = $print_order->getHTML(false);
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{customer_name}}", $customer['customer_name'], $email_body);
		$email_body = str_replace("{{mobile_number}}", $customer['mobile_number'], $email_body);
		$email_body = str_replace("{{order_billing_address}}",$customer['billing_address'], $email_body);
		$email_body = str_replace("{{order_shipping_address}}",$customer['shipping_address'], $email_body);
		$email_body = str_replace("{{customer_email}}", $customer['customer_email'], $email_body);
		$email_body = str_replace("{{customer_tin_no}}", $customer['tin_no'], $email_body);
		$email_body = str_replace("{{customer_pan_no}}", $customer['pan_no'], $email_body);
		$email_body = str_replace("{{order_no}}", $this['name'], $email_body);
		$email_body = str_replace("{{Order_date}}", $this['created_at'], $email_body);
		//END OF REPLACING VALUE INTO ORDER DETAIL EMAIL BODY
		// return;
		$this->sendEmail($customer_email,$subject,$email_body);
		
	}

	function isFromOnline(){
		return $this['order_from']=='online';
	}

	function orderItems(){
		return $this->ref('xShop/OrderDetails');
	}

	function itemrows(){
		return $this->orderItems();
	}

	function customer(){
		return $this->ref('member_id');
	}

	function member(){
		return $this->customer();
	}

	function from(){
		return $this->customer();
	}

	function unCompletedOrderItems(){
		$oi=$this->orderItems();
		$oi->addExpression('open_departments')->set($oi->refSQL('xShop/OrderItemDepartmentalStatus')->addCondition('is_open',true)->count());
		$oi->addCondition('open_departments',true);

		return $oi;
	}

	function invoice(){
		$inv = $this->add('xShop/Model_SalesInvoice')->addCondition('sales_order_id',$this->id);
		$inv->tryLoadAny();
		if($inv->loaded()) return $inv;
		return false;
	}

	function createInvoice($status='draft',$salesLedger=null, $items_array=array()){
		try{

			$this->api->db->beginTransaction();
			$invoice = $this->add('xShop/Model_Invoice_'.ucwords($status));
			$invoice['sales_order_id'] = $this['id'];
			$invoice['customer_id'] = $this->customer()->get('id');
			$invoice['billing_address'] = $this['billing_address'];
			$invoice['total_amount'] = $this['total_amount'];
			$invoice['discount'] = $this['discount_voucher_amount'];
			$invoice['tax'] = $this['tax'];
			$invoice['net_amount'] = $this['net_amount'];
			$invoice['termsandcondition_id'] = $this['termsandcondition_id'];
			$invoice->relatedDocument($this);

			$invoice->save();
			

			$ois = $this->orderItems();
			foreach ($ois as $oi) {

				if(!count($items_array)) continue;
				
				if($oi->invoice())
					throw $this->exception('Order Item already used in Invoice','Growl');
				
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
				$invoice->createVoucher($salesLedger);
			}

			$this->api->db->commit();
			return $invoice;
		}catch(\Exception $e){
			echo $e->getmessage();
			// $this->api->db->rollback();
			if($this->api->getConfig('developer_mode',false))
				throw $e;
		}

	}

	function placeOrderFromQuotation($quotation_approved_id){
		if($quotation_approved_id < 0 or $quotation_approved_id == null)
			return false;

		$approved_quotation = $this->add('xShop/Model_Quotation')->load($quotation_approved_id);
		$approved_quotation_items = $approved_quotation->ref('xShop/QuotationItem','quotation_id');

		$this['member_id'] = $this->api->auth->model->id;
		$this['status'] = "Draft";
		$this['order_from'] = "offline";
		$this->save();

		$order_details=$this->add('xShop/Model_OrderDetails');
		$total_amount=0;
			foreach ($approved_quotation_items as $junk) {

				$order_details['order_id']=$this->id;
				$order_details['item_id']=$approved_quotation_items['item_id'];
				$order_details['qty']=$approved_quotation_items['qty'];
				$order_details['rate']=$approved_quotation_items['sales_amount'];//get Item Rate????????????????
				$order_details['amount']=$approved_quotation_items['total_amount'];
				$order_details['custom_fields']=json_encode($approved_quotation_items['custom_fields']);
				$total_amount+=$order_details['amount'];
				$order_details->saveAndUnload();
			}

			$this['amount']=$total_amount;
			$this['net_amount'] = $total_amount;
			$this->save();

			// $discountvoucher->processDiscountVoucherUsed($this['discount_voucher']);
			return true;
		
	}	

	function isOrderClose($close_as_well=true){
		if($this->unCompletedOrderItems()->count()->getOne() == 0){
			if($close_as_well)
				$this->setStatus('processed');
			return true;
		}
		return false;
	}

	function submit(){
		$this->setStatus('submitted');
		return $this;
	}

	function reject_page($page){
		$form= $page->add('Form_Stacked');
		$form->addField('text','reason');
		$form->addSubmit('Reject & Send to Re Design');
		if($form->isSubmitted()){
			$this->setStatus('redesign',$form['reason']);
			return true;
		}
	}

	function cancel_page($page){
		$form= $page->add('Form_Stacked');
		$form->addField('text','reason');
		$form->addSubmit('reject');
		if($form->isSubmitted()){
			$this->cancel($form['reason']);
			return true;
		}
	}

	function cancel($reason){
		$this->setStatus('cancelled',$form['reason']);
	}

	function approve_page($page){

		$form = $page->add('Form_Stacked');
		$form->addField('text','comments');
		$form->addSubmit('Approve & Create Jobcards');

		$page->add('HtmlElement')->setElement('H3')->setHTML('<small>Approving Job Card will move this order to approved status and create JobCards to receive in respective FIRST Departments for EACH Item</small>');
		if($form->isSubmitted()){
			$this->approve($form['comments']);
			return true;
		}
		return false;
	}

	function approve($message){
		// check conditions
		foreach ($ois=$this->orderItems() as $oi) {
			$ois->createDepartmentalAssociations();
			if($department_association = $oi->nextDeptStatus()){
				$department_association->createJobCardFromOrder();
			}
		}

		$this->setStatus('approved',$message);
		return $this;
	}

	function cashAdvance($cash_amount, $cash_account=null){

		if(!$cash_account) $cash_account = $this->add('xAccount/Model_Account')->loadDefaultCashAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('ORDER ADVANCE CASH PAYMENT RECEIVED', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addCreditAccount($this->customer()->account(),$cash_amount);
		$transaction->addDebitAccount($cash_account ,$cash_amount);
		

		$transaction->execute();
	}

	function bankAdvance($amount, $cheque_no,$cheque_date,$bank_account_detail, $self_bank_account=null){
		if(!$self_bank_account) $self_bank_account = $this->add('xAccount/Model_Account')->loadDefaultBankAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('ORDER ADVANCE BANK PAYMENT RECEIVED', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addCreditAccount($this->customer()->account(),$amount);
		$transaction->addDebitAccount($self_bank_account ,$amount);
		
		$transaction->execute();
	}

	function attachments(){
		if(!$this->loaded())
			return false;

		$atts = $this->add('xShop/Model_SalesOrderAttachment');
		$atts->addCondition('related_root_document_name','xShop\Order');
		$atts->addCondition('related_document_id',$this->id);
		$atts->tryLoadAny();
		if($atts->loaded())
			return $atts;
		return false;
		// return $this->ref('Attachements')->tryLoadAny();
	}
}