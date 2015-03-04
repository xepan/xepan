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
		$this->hasOne('xShop/Order','order_id');

		$this->getElement('status')->defaultValue('submitted');

		$this->hasMany('xStore/MaterialRequestItem','material_request_id');
		$this->hasMany('xStore/StockMovement','material_request_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function relatedChallan(){
		$challan =  $this->ref('xStore/StockMovement')->tryLoadAny();
		if($challan->loaded()) return $challan;

		return false;
	}

	function createFromOrder($order_item, $order_dept_status ){
		$new_request = $this->add('xStore/Model_MaterialRequest');
		$new_request->addCondition('order_id',$order_item['order_id']);
		$new_request->tryLoadAny();

		$sales_dept = $this->add('xHR/Model_Department')->loadBy('related_application_namespace','xShop');
		$new_request['from_department_id'] = $sales_dept->id;
		$new_request['name']=rand(1000,9999);

		$order= $order_item->ref('order_id');

		$new_request['related_document_id'] = $order_item['order_id'];
		$new_request['related_root_document_name'] = $order->root_document_name;
		$new_request['related_document_name'] = $order->document_name;


		if(!$new_request->loaded()) $new_request->save();

		$new_request->addItem($order_item->ref('item_id'),$order_item['qty']);

	}

	function addItem($item,$qty){
		$mr_item = $this->ref('xStore/MaterialRequestItem');
		$mr_item['item_id'] = $item->id;
		$mr_item['qty'] = $qty;
		$mr_item->save();
	}

	function mark_processed_page($page){

		$form = $page->add('Form_Stacked');
		$form->addField('DropDown','from_warehouse')->setModel('xStore/Warehouse');
		$form->addField('DropDown','to_warehouse')
			->setFieldHint('TODO :Check if from order only shipping here or if from any department.. that department nly here')
			->setModel('xStore/Warehouse');

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
			
			$from_warehouse = $this->add('xStore/Model_Warehouse')->load($form['from_warehouse']);
			
			// Always to any warehouse/department
			// this is material request :: never to send directly to customer from here
			$to_warehouse = $this->add('xStore/Model_Warehouse')->load($form['to_warehouse']);

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

					$movement_challan->addItem($item,$form['alloted_qty_'.$i]);
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

		// echo "ask from wherehouse <br/>";
		// echo "ask to wherehouse <br/>";
		// echo "show all items in request with demand qty <br/>";
		// echo "what you are fulfilling <br/>";
		// echo "onsubmit varify stock and  execute <br/>";
		// echo "Create StockMovement and mark this as related Document <br/>";


		$page->add('View')->set('stock se minus kar do ... status processed kar do');
	}

	function approve_page($p){
		$p->add('View_Success')->set('Show Related Challan HEre');
		$form = $p->add('Form');
		$accept_btn = $form->addSubmit('Accept');
		$reject_btn = $form->addSubmit('Reject');

		if($form->isSubmitted()){
			if($form->isClicked($accept_btn)){
				$this->relatedChallan()->acceptMaterial();
			}else{
				throw new \Exception("Rejected", 1);

			}
		}

	}

	
}		
