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

		$this->addExpression('pending_items_to_dispatch')->set(function($m,$q){
			$depstat = $m->add('xShop/Model_OrderItemDepartmentalStatus');
			$depstat->join('xshop_orderDetails','orderitem_id')
			->addField('dsorder_id','order_id');

			$depstat->addCondition('status','Waiting');
			$depstat->addCondition('dsorder_id',$q->getField('order_id'));
			return $depstat->count();
		});

		$this->addHook('beforeInsert',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeInsert($obj){
		$obj['name'] = rand(1000,9999);
	}

	function itemRows(){
		return $this->ref('xDispatch/DispatchRequestItem');
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

		$new_request->addItem($order_item->ref('item_id'),$order_item['qty'],$order_item->ref('item_id')->get('qty_unit'),$order_item['custom_fields']);

	}

	function addItem($item,$qty,$unit,$custom_fields){
		$mr_item = $this->ref('xDispatch/DispatchRequestItem');
		$mr_item['item_id'] = $item->id;
		$mr_item['qty'] = $qty;
		$mr_item['unit'] = $unit;
		$mr_item['custom_fields'] = $custom_fields;
		$mr_item->save();
	}

	function order(){
		return $this->add('xShop/Model_Order')->load($this['order_id']);
	}

	function orderDetail(){
		return $this->add('xShop/Model_OrderDetails')->addCondition('order_id');
	}

	function mark_processed_page($p){//Mark Processd = Delivey in this case
		
		$form = $p->add('Form');
		$form->addField('line','delivery_from');
		$form->addField('line','delivery_docket_no');
		$form->addField('text','delivery_narration');

		
		//Get the Order of DispatchRequest
		
		$crud = $p->add('Grid');
		$crud->setModel($this->itemRows());



		$form->addSubmit('Dispatch the Order');
		if($form->isSubmitted()){
			//According to OrderDetail(Item) Select insert into DispatchRequestItem under single entry od dispatchRequest
			//and set Status of orderitem is dispatched
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
			$this->setStatus('received');
			return true;
		}
		return false;		
	}

	function submit(){

	}

}
