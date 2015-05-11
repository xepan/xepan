<?php
namespace xStore;

class Model_MaterialRequest extends \Model_Document {
	
	public $table = 'xstore_material_request';

	public $root_document_name='xStore\MaterialRequest';
	public $status = array('draft','submitted','approved','assigned','processing','processed','forwarded',
							'completed','cancelled','return');
 
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/OrderDetails','orderitem_id')->sortable(true);
		$this->hasOne('xHR/Department','to_department_id')->sortable(true);
		$this->hasOne('xHR/Department','from_department_id')->sortable(true);
		$this->hasOne('xStore/Warehouse','dispatch_to_warehouse_id')->sortable(true);
		$this->hasOne('xShop/OrderItemDepartmentalStatus','orderitem_departmental_status_id')->sortable(true);
		
		$this->addField('type')->enum(array('JobCard','MaterialRequest','DispatchRequest'))->defaultValue('JobCard');
		$this->addField('name')->caption('Job Number')->sortable(true);
		$this->getElement('status')->defaultValue('submitted');
		
		$this->addExpression('outsource_party')->set(function($m,$q){
			$p = $m->add('xProduction/Model_OutSourceParty');
			$j=$p->join('xshop_orderitem_departmental_status.outsource_party_id');
			$j->addField('order_item_dept_status_id','id');
			$p->addCondition('order_item_dept_status_id',$q->getField('orderitem_departmental_status_id'));
			return $p->fieldQuery('name');
		})->sortable(true);

		$this->addExpression('order_no')->set(
				$this->add('xShop/Model_Order',array('table_alias'=>'order_no_als'))
					->addCondition('id',
						$this->add('xShop/Model_OrderDetails',array('table_alias'=>'od_4_order_no'))
						->addCondition('id',$this->getElement('orderitem_id'))
						->fieldQuery('order_id')
					)
				->fieldQuery('name')
			)->sortable(true);

		$this->addCondition('type','MaterialRequest');

		$this->getElement('status')->defaultValue('submitted');

		$this->hasMany('xStore/MaterialRequestItem','material_request_jobcard_id');
		$this->hasMany('xStore/StockMovement','material_request_jobcard_id');

		$this->addHook('beforeDelete',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		// print_r($this->ref('StockMovementForMaterialRequest')->getRows());

		$sm = $this->ref('xStore/StockMovement')->count()->getOne();
		if($sm)
			throw $this->exception('Cannot Delete, First Delete Stock Movement','Growl');

		$this->ref('xStore/MaterialRequestItem')->each(function($m){
			$m->delete();
		});
	}

	function forceDelete(){
		foreach($sm = $this->ref('xStore/StockMovement') as $junk){
			$sm->forceDelete();
		}

		$this->delete();
	}

	function itemrows(){
		return $this->add('xStore/Model_MaterialRequestItem')->addCondition('material_request_jobcard_id',$this->id);
	}

	function relatedChallan(){
		$challan =  $this->ref('xStore/StockMovement')->tryLoadAny();
		if($challan->loaded()) return $challan;

		return false;
	}

	// Called if direct order to store is required
	function createFromOrder($order_item, $order_dept_status ){
		$new_request = $this->add('xStore/Model_MaterialRequest');
		$new_request->addCondition('orderitem_id',$order_item->id);
		$new_request->tryLoadAny();

		if(!$new_request->loaded()){
			// Create Request From Next Department In Phases :: IMPORTANT
			$from_dept_status = $order_item->nextDeptStatus($order_dept_status->department());
			$from_dept = $from_dept_status->department();
			$new_request->create(
					$from_dept,
					$order_dept_status->department(),
					$related_document=$order_item->order(), 
					$order_item, 
					$items_array=array(), 
					$from_dept->warehouse()
				);
			$new_request['status']='approved'; // AUTO CREATED AND CONSIDERED APPROVED
			$new_request->save();
		}

		$new_request->addItem($order_item->ref('item_id'),$order_item['qty'], $order_item->ref('item_id')->get('qty_unit'),$order_item['custom_fields']);

	}

	function addItem($item,$qty,$unit,$custom_fields){
		$mr_item = $this->ref('xStore/MaterialRequestItem');
		$mr_item['item_id'] = $item->id;
		$mr_item['qty'] = $qty;
		$mr_item['unit'] = $unit;
		$mr_item['custom_fields'] = $custom_fields;
		$mr_item->save();
	}

	function mark_processed_page($page){

		if($oi=$this->orderItem()){
			if($oi->nextDeptStatus())
				$page->add('View_Success')->set('Created By Order, Adding JobCard to '.$oi->nextDeptStatus()->department()->get('name'));
			else
				$page->add('View_Success')->set('Created By Order, Not creating further jobcards');
		}

		$form = $page->add('Form_Stacked');

		$cols = $form->add('Columns');
		$sno_cols= $cols->addColumn(1);
		$item_cols= $cols->addColumn(7);
		$req_qty_cols= $cols->addColumn(2);
		$alloted_qty= $cols->addColumn(2);

		$i=1;
		foreach($this->ref('xStore/MaterialRequestItem') as $requested_item){
			$sno_cols->add('View')->set($i);
			$item_cols->addField('Readonly','item_'.$i,'Item')->set($requested_item['item']);
			$req_qty_cols->addField('Readonly','req_qty_'.$i,'Qty')->set($requested_item['qty']);
			$alloted_qty->addField('Number','alloted_qty_'.$i,'Alloted Qty')->set($requested_item['qty']);
			$i++;
		}

		$form->addSubmit('Issue');

		if($form->isSubmitted()){
			$i=1;
			
			$from_warehouse = $this->ref('to_department_id')->warehouse();
			
			if($this['dispatch_to_warehouse_id']){
				$to_warehouse = $this->add('xStore/Model_Warehouse')->load($this['dispatch_to_warehouse_id']);
			}else{
				$to_warehouse = $this->ref('from_department_id')->warehouse();
			}

			if($from_warehouse->id == $to_warehouse->id){
				$form->displayError('to_warehouse','Must Be Different');
			}

			try{
				$movement_challan = $from_warehouse->newStockTransfer($to_warehouse,$this);
				foreach($this->ref('xStore/MaterialRequestItem') as $requested_item){
					$item = $requested_item->item();
					
					if($item->isMantainInventory() AND !$item->allowNegativeStock()){
						if(($avl_qty=$from_warehouse->getStock($item)) < $form['alloted_qty_'.$i])
							throw $this->exception('Not Sufficient Qty Available ['.$avl_qty.']','ValidityCheck')->setField('req_qty_'.$i);
					}

					$movement_challan->addItem($item,$form['alloted_qty_'.$i], $requested_item['unit'],$requested_item['custom_fields']);
					$i++;
				}
				// commit
				$movement_challan->executeStockTransfer();

				if(($this->toDepartment()->isPurchase() OR $this->toDepartment()->isStore()) AND $this->isCreatedFromOrder() AND $department_association = $this->orderItem()->nextDeptStatus($this->toDepartment())){
					$department_association->createJobCardFromOrder();
				}

				// if($this->fromDepartment()->isDispatch()){
				// 	$department_association = $this->orderItem()->deptartmentalStatus($this->fromDepartment());
				// 	$department_association->createJobCardFromOrder();
				// }

				$this->setStatus('processed');
				
				return true;

			}catch(\Exception $e){
				if($e instanceof \Exception_ValidityCheck)
					$form->displayError($e->getField(), $e->getMessage());

				throw $e;
			}

		}

		$page->add('View')->set('stock se minus kar do ... status processed kar do');
	}

	function receive_page($p){
		$p->add('View_Success')->set('What to do here');
		$form = $p->add('Form_Stacked');
		$form->addSubmit('Receive');

		if($form->isSubmitted()){
			$this->receive();
			return true;
		}
	}

	function receive(){
		if($this['orderitem_id']){
			$this->orderItem()->order()->setStatus('processing','Material Request Received at '.$this->department()->get('name'). ' for ' . $this->orderItem()->get('name'));
		}
		$this->setStatus('received');
	}

	function submit_page($p){
		$form = $p->add('Form');
		$form->addSubmit();

		if($form->isSubmitted()){
			$this->setStatus('submitted');
			return true;
		}
		return false;
	}

	function accept_page($p){
		
		$p->add('xStore/View_StockMovement',array('stockmovement'=>$this->relatedChallan()));
		
		$form = $p->add('Form');
		$accept_btn = $form->addSubmit('Accept');
		$reject_btn = $form->addSubmit('Reject');

		if($form->isSubmitted()){
			if($form->isClicked($accept_btn)){
				$this->accept();
				return true;
			}else{
				throw new \Exception("Rejected", 1);
			}
		}
	}

	function accept(){
		$this->relatedChallan()->acceptMaterial();
		$this->setStatus('completed');
	}

	
}