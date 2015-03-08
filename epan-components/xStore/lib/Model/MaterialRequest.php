<?php
namespace xStore;

class Model_MaterialRequest extends \Model_Document {
	
	public $table = 'xstore_material_request';

	public $root_document_name='xStore\MaterialRequest';
	public $status = array('draft','submitted','assigned','processing','processed','forwarded',
							'complete','cancel','return');

	function init(){
		parent::init();

		$this->hasOne('xHR/Department','from_department_id');
		$this->hasOne('xHR/Department','to_department_id');
		$this->hasOne('xStore/Warehouse','dispatch_to_warehouse_id');
		$this->hasOne('xShop/OrderDetails','orderitem_id');

		$this->getElement('status')->defaultValue('submitted');

		$this->hasMany('xStore/MaterialRequestItem','material_request_id');
		$this->hasMany('xStore/StockMovement','material_request_id');

		$this->addHook('beforeInsert',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeInsert($obj){
		$obj['name'] = rand(1000,9999);
	}

	function relatedChallan(){
		$challan =  $this->ref('xStore/StockMovement')->tryLoadAny();
		if($challan->loaded()) return $challan;

		return false;
	}

	function create($from_department, $to_department, $items_array, $related_document=array(), $order_item=false,  $dispatch_to_warehouse=false){
		$this['from_department_id'] = $from_department->id;
		$this['to_department_id'] = $to_department->id;

		if(count($related_document)){
			$this['related_document_id'] = $related_document['related_document_id'];
			$this['related_root_document_name'] = $related_document['related_root_document_name'];
			$this['related_document_name'] = $related_document['related_document_name'];
		}

		if($order_item){
			$this['orderitem_id'] = $order_item->id;
		}

		if($dispatch_to_warehouse){
			$this['dispatch_to_warehouse_id'] = $dispatch_to_warehouse->id;
		}else{
			$this['dispatch_to_warehouse_id'] = $from_department->warehouse()->get('id');
		}

		$this->save();

		foreach ($items_array as $item) {
			$this->addItem($this->add('xShop/Model_Item')->load($item['id']),$item['qty'],$item['unit']);
		}
		return $this;
	}

	// Called if direct order to store is required
	function createFromOrder($order_item, $order_dept_status ){
		$new_request = $this->add('xStore/Model_MaterialRequest');
		$new_request->addCondition('orderitem_id',$order_item->id);
		$new_request->tryLoadAny();

		$sales_dept = $this->add('xHR/Model_Department')->loadSales();
		$new_request['from_department_id'] = $sales_dept->id;
		$new_request['to_department_id'] = $order_dept_status['department_id'];
		$new_request['dispatch_to_warehouse_id'] = $this->add('xHR/Model_Department')->loadDispatch()->get('id');

		$order= $order_item->ref('order_id');

		$new_request['related_document_id'] = $order_item['order_id'];
		$new_request['related_root_document_name'] = $order->root_document_name;
		$new_request['related_document_name'] = $order->document_name;


		if(!$new_request->loaded()) $new_request->save();

		$new_request->addItem($order_item->ref('item_id'),$order_item['qty']);

	}

	function addItem($item,$qty,$unit='Nos'){
		$mr_item = $this->ref('xStore/MaterialRequestItem');
		$mr_item['item_id'] = $item->id;
		$mr_item['qty'] = $qty;
		$mr_item['unit'] = $unit;
		$mr_item->save();
	}

	function mark_processed_page($page){

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
				// start transection
				$this->api->db->beginTransaction();
				$movement_challan = $from_warehouse->newStockTransfer($to_warehouse,$this);
				foreach($this->ref('xStore/MaterialRequestItem') as $requested_item){
					$item = $requested_item->item();
					
					if(!$item->allowNegativeStock()){
						if(($avl_qty=$from_warehouse->getStock($item)) < $form['alloted_qty_'.$i])
							throw $this->exception('Not Sufficient Qty Available ['.$avl_qty.']','ValidityCheck')->setField('req_qty_'.$i);
					}

					$movement_challan->addItem($item,$form['alloted_qty_'.$i], $requested_item['unit']);
					$i++;
				}
				// commit
				$movement_challan->executeStockTransfer();

				$this['status']='processed';
				$this->saveAs('xStore/MaterialRequest_Processed');

				$this->api->db->commit();
			}catch(\Exception $e){
				$this->api->db->rollback();
					// rollback
				if($e instanceof \Exception_ValidityCheck)
					$form->displayError($e->getField(), $e->getMessage());

				throw $e;
			}
		}

		$page->add('View')->set('stock se minus kar do ... status processed kar do');
	}

	function submit_page($p){
		$p->add('View')->set('Hello');
		$form = $p->add('Form');
		$form->addSubmit();

		if($form->isSubmitted()){
			$this['status']='submitted';
			$this->saveAndUnload();
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
				$this['status']='completed';
				$this->saveAs('xStore/Model_MaterialRequest_Completed');
			}else{
				throw new \Exception("Rejected", 1);
			}
		}
	}	
}