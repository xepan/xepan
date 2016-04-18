<?php

namespace xShop;

class Model_Order extends \Model_Document{
	public $table='xshop_orders';
	public $status = array('draft','submitted','approved','processing','processed','dispatched',
							'complete','cancel','return','redesign','onlineunpaid');
	public $root_document_name = 'xShop\Order';

	public $notification_rules = array(
			// 'activity NOT STATUS' => array (....)
			'submitted' => array(
							'xShop/Order_Submitted/can_approve'=>['title'=>'New sales Order for Approval','message'=>'New saless Order {$name} is subimitted  by {$created_by} for Approval'],
							'xShop/Order_Submitted/creator'=>['title'=>'Sales Order Submitted','message'=>'Sales Order{$name} is submitted by {$created_by}'],
							),
			'approved' => array('xShop/Order_Approved/creator' => ['title'=>'Sales Order Approved','message'=>'Sales Order {$name} is approved by {$created_by}']),
			'redesign' => array('xShop/Order_Redesign/creator'=>['title'=>'Sales Order Rejected','message'=>'sales Order {$name} is rejected to Redesign by {$created_by}']),
			'cancelled' => array('xShop/Order_Cancelled/can_view'=>['title'=>'Sales Order Canceled','message'=>'Sales Order {$name} is canceled by {$created_by}']),
			'completed' => array('xShop/Order_Completed/can_view'=>['title'=>'Sales Order Completed','message'=>'Sales Order {$name} is Completed']),
			'processed' => array('xShop/Order_Processed/can_view'=>['title'=>'Sales Order Processed','message'=>'Sales Order {$name} is Processed by {$created_by}']),
			'processing' => array('xShop/Order_Processing/can_view'=>['title'=>'Sales Order under Processing','message'=>'Sales Order {$name} is under processing ']),
			'email' => array('xShop/Order_Approved/creator'=>['title'=>'Sales Order been mailed','message'=>'Sales order [{$name}] is been mailed to [{$to}-{$email_to}] from [{$from}]'])

			// 'comment' => array('xShop/Order/can_see_activities'=>),
			// 'call' => array('xShop/Order/can_see_activities'=>'New Activity of {order_name} to see, Communication between {customer} and {employee}'),
			// 'sms' => array('xShop/Order/can_see_activities'=>'sales {oder_name} Customer {customer_name} notify via sms by {employee_name}'),
			// 'personal' => array('xShop/Order/can_see_activities'=>'personal Communication between {customer_name} and  {employee_name} on {order_name}'),
			// 'action' => array('xShop/Order/can_see_activities'=>'Action taken by {employee_name} on {order_name}')
		);

	function init(){
		parent::init();
		
 		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/PaymentGateway','paymentgateway_id');
		$this->hasOne('xShop/TermsAndCondition','termsandcondition_id')->display(array('form'=>'autocomplete/Basic'))->caption('Terms & Cond.');
		$this->hasOne('xShop/Priority','priority_id')->group('z~6')->mandatory(true);//->defaultValue($this->add('xShop/Model_Priority')->addCondition('name','Medium')->fieldQuery('id'));
		$this->hasOne('xShop/Currency','currency_id')->sortable(true)->mandatory(true);//->display(array('form'=>'autocomplete/Basic'));

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
		
		$f = $this->addField('billing_landmark');
		$f = $this->addField('billing_city');
		$f = $this->addField('billing_state');
		$f = $this->addField('billing_country');
		$f = $this->addField('billing_zip');
		$f = $this->addField('billing_tel');
		$f = $this->addField('billing_email');

		$f = $this->addField('shipping_landmark');
		$f = $this->addField('shipping_city');
		$f = $this->addField('shipping_state');
		$f = $this->addField('shipping_country');
		$f = $this->addField('shipping_zip');
		$f = $this->addField('shipping_tel');
		$f = $this->addField('shipping_email');


		// Payment GateWay related Info
		$this->addField('transaction_reference');
		$this->addField('transaction_response_data')->type('text');

		// Last OrderItem Status
		$dept_status = $this->add('xShop/Model_OrderItemDepartmentalStatus',array('table_alias'=>'ds'));
		$oi_j = $dept_status->join('xshop_orderdetails','orderitem_id');
		$oi_j->addField('order_id');
		$dept_status->addCondition($dept_status->getElement('order_id'),$this->getElement('id'));
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
		})->caption('Last Action');


		$this->hasMany('xShop/OrderDetails','order_id');
		$this->hasMany('xShop/SalesOrderAttachment','related_document_id',null,'Attachments');
		$this->hasMany('xShop/SalesInvoice','sales_order_id');
		$this->hasMany('xDispatch/DeliveryNote','order_id');
		
		$this->addExpression('orderitem_count')->set($this->refSQL('xShop/OrderDetails')->count());
		
		$this->addHook('afterSave',$this);
		$this->addHook('beforeDelete',$this);
		$this->setOrder('id','desc');

		$this->addExpression('shipping_charge')->set(function($m,$q){
			return $m->refSQL('xShop/OrderDetails')->sum('shipping_charge');
		});

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterSave(){
		$this->updateAmounts();
	}

	function termAndCondition(){
		return $this->ref('termsandcondition_id');
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
			$this->forceDelete($form['delete_invoice_also']);
			return true;
		}

	}

	function forceDelete($delete_invoice_also = true){
		$ois = $this->orderItems();

		foreach ($ois as $oi) {
				//ORDER DETAIL (ITEMS) DELETE
				//Create Log
				$oi->forceDelete();
			}
			$invs = $this->invoice();
			if($delete_invoice_also and $invs){
				foreach ($invs as $inv) {
					//Create Log
					$invs->forceDelete();
				}
			}elseif($invs){
				foreach ($invs as $inv) {
					$inv['sales_order_id'] = null;
					$inv->saveAndUnload();
				}
			}

			$this->ref('xDispatch/DeliveryNote')->each(function($dn){
				$dn->forceDelete();
			});

			//ORDER DELETE
			//create Log
			$this->delete();
	}

	function beforeDelete(){
		$m = $this;
		
		if($m->ref('xShop/SalesInvoice')->count()->getOne())
			throw $this->exception('Cannot Delete, First Delete It\'s Invoice');

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

		$m->ref('Attachments')->each(function($attach){
			$attach->forceDelete();
		});
	}

	function placeOrderFromCart(){
		// $billing_address=$order_info['address'].", ".$order_info['landmark'].", ".$order_info['city'].", ".$order_info['state'].", ".$order_info['country'].", ".$order_info['pincode'];
		// $shipping_address=$order_info['shipping_address'].", ".$order_info['s_landmark'].", ".$order_info['s_city'].", ".$order_info['s_state'].", ".$order_info['s_country'].", ".$order_info['s_pincode'];
		$member = $this->add('xShop/Model_MemberDetails');
		$member->loadLoggedIn();

		$cart_items=$this->add('xShop/Model_Cart');
		$this['member_id'] = $member->id;
		$this['status'] = "onlineUnpaid";
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
				$order_details['rate']=$cart_items['rateperitem'];//get Item Rate????????????????
				$order_details['amount']=round($cart_items['qty'] * $cart_items['rateperitem'],2);
				$order_details['custom_fields']= $item_model->customFieldsRedableToId(json_encode($cart_items['custom_fields']));//json_encode($cart_items['custom_fields']);				
				$order_details['apply_tax'] = true;
				$order_details['shipping_charge'] = $cart_items['shipping_charge'];

				$tax_id = 0;
				$t = $item_model->applyTaxs()->setLimit(1);
				foreach ($t as $ts) {
					$tax_id = $ts['tax_id'];
				}
				
				$order_details['tax_id'] = $tax_id;

				$total_amount+=$order_details['amount'];
				$order_details->save();

				if($cart_items['file_upload_id']){

					$uploaded_images = explode(",", $cart_items['file_upload_id']);

					foreach ($uploaded_images as $file_id) {
						// echo "$file_id<br/>";
						$atts = $this->add('xShop/Model_SalesOrderDetailAttachment');
						$atts->addCondition('related_root_document_name','xShop\OrderDetail');
						$atts->addCondition('related_document_id',$order_details->id);
						$atts['attachment_url_id'] = $file_id;
						$atts->saveAndUnload();
					}
				}
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
			// echo "placeOrderFromCart";
			// $discountvoucher->processDiscountVoucherUsed($this['discount_voucher']);
			$this->createInvoice('approved');
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
		$shop_config = $this->add('xShop/Model_Configuration')->tryLoadAny();
		$this['total_amount']=0;
		$this['gross_amount']=0;
		$this['tax']=0;
		$this['net_amount']=0;
		
		$order_items_info = "";
		foreach ($this->itemRows() as $oi) {
			$this['total_amount'] = $this['total_amount'] + $oi['amount'];
			$this['gross_amount'] = $this['gross_amount'] + $oi['texted_amount'];
			$this['tax'] = $this['tax'] + $oi['tax_amount'];
			$this['net_amount'] = $this['total_amount'] + $this['tax'] - $this['discount_voucher_amount'] + ($this['shipping_charge']?$this['shipping_charge']:0);
			
			//For Order Item String Manupulation
			$order_items_info .= $oi['name']." ".
								$oi['qty']." ".
								$oi['amount']." ".
								$oi['narration']." ".
								$oi['item_name'];
		}

		if($shop_config['is_round_amount_calculation']){
			$this['net_amount'] = round($this['net_amount'],0);
		}

		//Updating Search String 
		$this['search_string']= $this['search_phrase']." ".
								$this['order_from']. " ".
								$this['total_amount']. " ".
								$this['net_amount']. " ".
								$this['billing_address']. " ".
								$this['shipping_address']. " ".
								$this['meta_description']. " ".
								$this['order_summary']. " ".
								$this['status']. " ".
								$order_items_info;

		$this->save();
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

		$print_order = $this->add('xShop/View_OrderDetail',array('show_department'=>false,'show_price'=>true,'show_customfield'=>true));
		$print_order->setModel($this->itemrows());
		$order_detail_html = $print_order->getHTML(false);

		$customer = $this->customer();
		$customer_email=$customer->get('customer_email');
		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();

		$email_body=$config_model['order_detail_email_body']?:"Order Layout Is Empty";
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{customer_name}}", $customer['customer_name']?$customer['customer_name']:"", $email_body);
		$email_body = str_replace("{{customer_organization_name}}", $customer['organization_name'], $email_body);
		$email_body = str_replace("{{order_billing_address}}",$customer['billing_address']?$customer['billing_address']:"", $email_body);
		$email_body = str_replace("{{mobile_number}}", $customer['mobile_number']?$customer['mobile_number']:"", $email_body);
		$email_body = str_replace("{{customer_email}}", $customer['customer_email']?$customer['customer_email']:"", $email_body);
		$email_body = str_replace("{{order_shipping_address}}",$customer['shipping_address']?$customer['shipping_address']:"", $email_body);
		$email_body = str_replace("{{customer_tin_no}}", $customer['tin_no'], $email_body);
		$email_body = str_replace("{{customer_pan_no}}", $customer['pan_no'], $email_body);
		$email_body = str_replace("{{order_no}}", $this['name'], $email_body);
		$email_body = str_replace("{{order_date}}",$this->customDateFormat(), $email_body);
		$email_body = str_replace("{{order_deliver_date}}", date('d-m-Y',strtotime($this['delivery_date'])), $email_body);
		$email_body = str_replace("{{sale_order_details}}", $order_detail_html, $email_body);
		$email_body = str_replace("{{terms_and_conditions}}", $tnc?$tnc:"", $email_body);
		// if($config_model['show_narration'])
		$email_body = str_replace("{{order_summary}}", $this['order_summary'], $email_body);


		return $email_body;
	}
	
	// //Model Return Currency name or Model
	// function currency($name=1){
	// 	if($name)
	// 		return $this->ref('currency_id')->get('name');
		
	// 	return $this->ref('currency_id');
	// }

	function send_via_email_page($p){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
						
		$email_body = $this->parseEmailBody();
		$customer = $this->customer();
		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();

		$emails = explode(',', $customer['customer_email']);
		
		$form = $p->add('Form_Stacked');
		
		$this->populateSendFrom($form, $this->api->current_department);

		$form->addField('Email','to')->set($emails[0])->validateNotNull();
		// array_pop(array_re/verse($emails));
		unset($emails[0]);

		$form->addField('line','cc')->set(implode(',',$emails));
		$form->addField('line','bcc');
		$form->addField('line','subject')->validateNotNull()->set($config_model['order_detail_email_subject']);
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
			$this->sendEmail($form['to'],$subject,$email_body,$ccs,$bccs,array(),$this->getPopulatedSendFrom($form));
			$this->createActivity('email',$form['subject'],$email_body,$from=null,$from_id=null, $to='Customer', $to_id=$customer->id,$form['to'].",".$form['cc'].",".$form['bcc']);
			return true;
		}	
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

	function createInvoice($status='draft',$salesLedger=null, $items_array=array(),$amount=0,$discount=0,$shipping_charge=0){
		try{

			$this->api->db->beginTransaction();
			$invoice = $this->add('xShop/Model_Invoice_'.ucwords($status));
			$invoice['sales_order_id'] = $this['id'];
			$invoice['customer_id'] = $this->customer()->get('id');
			$invoice['billing_address'] = $this['billing_address'];
			$invoice['total_amount'] = $amount?$amount:$this['total_amount'];
			$invoice['discount'] = $discount?$discount:$this['discount_voucher_amount'];
			$invoice['tax'] = $this['tax'];
			$invoice['net_amount'] = $this['net_amount'];
			$invoice['shipping_charge'] = $this['shipping_charge']+$shipping_charge;
			$invoice['termsandcondition_id'] = $this['termsandcondition_id'];
			$invoice->save();

			$invoice->relatedDocument($this);
			
			$ois = $this->orderItems();
			foreach ($ois as $oi) {	
				if(count($items_array)) {
					if(!in_array($oi['id'],$items_array)){
						continue;
					}
				}
			// throw new \Exception($ois->count()->getOne()."I-".$oi->id.print_r($items_array,true));

				if($oi->invoice())
					throw $this->exception('Order Item already used in Invoice','Growl');
			
				$invoice->addItem(
						$oi->item(),
						$oi['qty'],
						$oi['rate'],
						$oi['amount'],
						$oi['unit'],
						$oi['narration'],
						$oi['custom_fields'],
						$oi['apply_tax'],
						$oi['tax_id'],
						$oi['shipping_charge']
					);					
				$invoice->updateAmounts();
				$oi->invoice($invoice);	
			}

			if($status !== 'draft' and $status !== 'submitted'){				
				$invoice->createVoucher($salesLedger);
			}

			$this->api->db->commit();
			return $invoice;
		}catch(\Exception $e){
			echo $e->getmessage();
			$this->api->db->rollback();
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

	function submit_page($page){

		if(!$this->orderItems()->count()->getOne()){
			$page->add('View_Error')->set('Order Detail Cannot be Empty');
			return false;
		}

		$form=$page->add('Form');
		$form->addSubmit('Submit');
		if($form->isSubmitted()){
			$this->submit();
			return true;
		}
		
		// return true;
	}

	function submit(){
		$this->setStatus('submitted');
		return $this;
	}

	function reject_page($page){
		$form= $page->add('Form_Stacked');
		if($form->isSubmitted()){
			$this->setStatus('redesign',$form['reason']);
			return true;
		}
	}

	function cancel_page($page){
		$form= $page->add('Form_Stacked');
		$str = "";
		//get all item_jobcard with status
		$ois = $this->orderItems();
		foreach ($ois as $oi) {
			// Related Jobcards
			$jcs = $oi->jobCards();
			foreach ($jcs as $jc) {
				$str.= " Item :: ".$oi['name']."<br>";
				$str.= "JobCard No. ".$jc['name']." Department ".$jc['to_department']." :: ". $jc['status']."<br>";
			}
		}
		if($str != ""){
			$form->addField('Readonly','JobCards')->set($str);
			$form->add('View_Warning')->set('ALL Jobcard will be Canceled');
		}

		$form->addField('text','reason');
		$form->addSubmit('cancel');
		if($form->isSubmitted()){
			foreach ($ois as $oi) {
				// $order_item = $this->add('xShop/Model_OrderDetails')->load($oi);
				$oi->jobCards()->setStatus('cancelled',$form['reason']);
			}
			$this->cancel($form['reason']);
			return true;
		}
	}

	function cancel($reason){
		$this->setStatus('cancelled',$reason);
	}

	function approve_page($page){

		$form = $page->add('Form_Stacked');
		$form->addField('text','comments');
		$form->addSubmit('Approve & Create Jobcards');

		$page->add('HtmlElement')->setElement('H3')->setHTML('<small>Approving Job Card will move this order to approved status and create JobCards to receive in respective FIRST Departments for EACH Item</small>');
		if($form->isSubmitted()){
			$this->approve($form['comments']);
			// $this->send_via_email_page($this);
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
		return $transaction;
	}

	function bankAdvance($amount, $cheque_no,$cheque_date,$bank_account_detail, $self_bank_account=null){
		if(!$self_bank_account) $self_bank_account = $this->add('xAccount/Model_Account')->loadDefaultBankAccount();

		$transaction = $this->add('xAccount/Model_Transaction');
		$transaction->createNewTransaction('ORDER ADVANCE BANK PAYMENT RECEIVED', $this, $transaction_date=$this->api->now, $Narration=null);
		
		$transaction->addCreditAccount($this->customer()->account(),$amount);
		$transaction->addDebitAccount($self_bank_account ,$amount);
		
		$transaction->execute();
		return $transaction;
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

	function setTermAndConditionEmpty(){
		if(!$this->loaded()) return;

		$this['termsandcondition_id'] = null;
		$this->save();
	}

}