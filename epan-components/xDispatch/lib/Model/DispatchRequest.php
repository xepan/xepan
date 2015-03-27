<?php
namespace xDispatch;

class Model_DispatchRequest extends \xProduction\Model_JobCard {
	
	public $table = 'xdispatch_dispatch_request';

	public $root_document_name='xDispatch\DispatchRequest';
	public $status = array('approved','assigned','processing','processed','forwarded',
							'completed','cancelled','return','redesign','received');

	function init(){
		parent::init();

		$this->addCondition('type','DispatchRequest');
		$this->hasOne('xShop/Order','order_id')->sortable(true);

		$this->getElement('status')->defaultValue('submitted');

		$this->hasMany('xDispatch/DispatchRequestItem','dispatch_request_id');
		$this->hasMany('xStore/StockMovement','dispatch_request_id');

		$this->addExpression('recent_items_to_receive')->set(function($m,$q){
			return $m->refSQL('xDispatch/DispatchRequestItem')->addCondition('status','to_receive')->count();
		})->sortable(true);

		$this->addExpression('item_under_process')->set(function($m,$q){
			$depstat = $m->add('xShop/Model_OrderItemDepartmentalStatus');
			$depstat->join('xshop_orderDetails','orderitem_id')
			->addField('dsorder_id','order_id');

			$depstat->addCondition('department_id',$m->add('xHR/Model_Department')->loadDispatch()->get('id'));
			$depstat->addCondition('status','Waiting');
			$depstat->addCondition('dsorder_id',$q->getField('order_id'));
			return $depstat->count();
		})->sortable(true);

		$this->addExpression('pending_items_to_deliver')->set(
			$this->refSQL('xDispatch/DispatchRequestItem')->addCondition('status','received')->count()
		)->sortable(true);


		$this->addHook('beforeInsert',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeInsert($obj){
		$obj['name'] = rand(1000,9999);
	}

	function itemRows(){
		return $this->add('xDispatch/Model_DispatchRequestItem')->addCondition('dispatch_request_id',$this->id);
	}

	function relatedChallan(){
		$challan =  $this->ref('xStore/StockMovement')->tryLoadAny();
		if($challan->loaded()) return $challan;

		return false;
	}


	// Called if direct order to store is required
	function createFromOrder($order_item, $order_dept_status ){
		$new_request = $this->add('xDispatch/Model_DispatchRequest');
		$new_request->addCondition('order_id',$order_item->order()->get('id'));
		$new_request->tryLoadAny();

		if(!$new_request->loaded()){

			$from_dept_status = $order_item->nextDeptStatus($order_dept_status->department());
			if($from_dept_status){
				$from_dept = $from_dept_status->department();
			}else{
				$from_dept_status = $order_item->prevDeptStatus($order_dept_status->department());
				$from_dept = $from_dept_status->department();
			}

			$new_request->create(
					$from_dept,
					$order_dept_status->department(),
					$related_document=$order_item->order(), 
					$order_item, 
					$items_array=array(),
					false,
					'approved'
				);
		}

		$new_request->addItem($order_item,$order_item->ref('item_id'),$order_item['qty'],$order_item->ref('item_id')->get('qty_unit'),$order_item['custom_fields']);

	}

	function addItem($order_item,$item,$qty,$unit,$custom_fields){
		$mr_item = $this->ref('xDispatch/DispatchRequestItem');
		$mr_item['orderitem_id'] = $order_item->id;
		$mr_item['item_id'] = $item->id;
		$mr_item['qty'] = $qty;
		$mr_item['unit'] = $unit;
		$mr_item['custom_fields'] = $custom_fields;
		$mr_item->save();
	}

	function order(){
		return $this->add('xShop/Model_Order')->load($this['order_id']);
	}


	function mark_processed_page($p){//Mark Processd = Delivey in this case
		
		$p->add('H3')->set('Items to Deliver');
		$grid = $p->add('Grid');
		$grid->setModel($this->itemRows()->addCondition('status','received'),array('dispatch_request','item_with_qty_fields','qty','unit','custom_fields','item'));

		$grid->removeColumn('custom_fields');
		$grid->removeColumn('item');
		
		$form = $p->add('Form_Stacked');
		$form->addField('line','delivery_via');
		$form->addField('line','delivery_docket_no','Docket No / Person name / Other Reference');
		$form->addField('text','billing_address');
		$form->addField('text','shipping_address');
		$form->addField('text','delivery_narration');
		// $form->addField('Checkbox','generate_invoice');
		// $form->addField('DropDown','include_items')->setValueList(array('Selected'=>'Selected Only','All'=>'All Ordered Items'));
		$form->addField('Checkbox','send_invoice_via_email');
		$form->addField('line','email_to');


		$include_field = $form->addField('hidden','include_items');

		$grid->addSelectable($include_field);
		
		//Get the Order of DispatchRequest


		$form->addSubmit('Dispatch the Order');

		$p->add('H3')->set('Items Delivered');
		$grid = $p->add('Grid');
		$grid->setModel($this->itemRows()->addCondition('status','delivered'),array('dispatch_request','item_with_qty_fields','qty','unit','custom_fields','item'));


		if($form->isSubmitted()){
			$items_selected = json_decode($form['include_items'],true);


			// TODO : A LOT OF CHECKINGS REGARDING INVOICE ETC ...
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

			//According to OrderDetail(Item) Select insert into DispatchRequestItem under single entry od dispatchRequest
			//and set Status of orderitem is dispatched
			
			$new_delivery_note = $this->add('xDispatch/Model_DeliverNote');
			$new_delivery_note->create($order,$from_warehouse,$shipping_address,$shipping_via,$docket_no,$narration,$items_array);
			
			foreach ($items_selected as $itm) {
				$itm_model = $this->add('xDispatch/Model_DispatchRequestItem')->load($itm);
				$itm_model->setStatus('delivered');
				$new_delivery_note->addItem($itm_model->orderItem(), $itm_model->item(),$itm_model['qty'],$itm_model['unit'],$itm_model['custom_fields']);
			}

			if(!$this->ref('xDispatch/Model_DispatchRequestItem')->addCondition('status','<>','delivered')->count()->getOne())
				$this->setStatus('submitted');//submitted Equal to Dispatched but not received by customer
				
			// create the DeliveryNote
			return true;
		}

		return false;
	}

	function submit_page($p){
		$p->add('View')->set('Hello');
		$form = $p->add('Form');
		$form->addSubmit();

		if($form->isSubmitted()){
			$this->setStatus('submitted');
			return true;
		}
		return false;
	}

	function accept_page($p){
		$p->add('View_Success')->set('Show Related Challan HEre');
		$form = $p->add('Form');
		$accept_btn = $form->addSubmit('Accept');
		$reject_btn = $form->addSubmit('Reject');

		if($form->isSubmitted()){
			if($form->isClicked($accept_btn)){
				$this->relatedChallan()->acceptMaterial();
				$this->setStatus('completed');
			}else{
				throw new \Exception("Rejected", 1);
			}
		}
	}

	function receive_page($p){
		$p->add('View_Info')->set('Dispatch Request To Received');
		$p->add('View_Warning')->set('add here meterial request received also');
		$form = $p->add('Form');
		$form->addSubmit();
		if($form->isSubmitted()){
			$this->receive();
			return true;
		}
		return false;		
	}

	function receive(){
		$this->setStatus('received');
		if($pre_dept_job_card = $this->previousDeptJobCard()){
			$pre_dept_job_card->complete();
		}
		$ds = $this->orderItem()->deptartmentalStatus($this->department());
		if($ds) {
			$ds->setStatus(ucwords('received') .' in ' . $this->department()->get('name'));
		}
	}

	function submit(){

	}

}
