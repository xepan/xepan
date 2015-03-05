<?php
namespace xPurchase;

class Model_PurchaseMaterialRequest extends \Model_Document{
	public $table="xpurcahse_material_request";
	public $status=array('draft','approved','rejected','submitted','processed','completed');
	public $root_document_name='xStore\PurchaseMaterialRequest';
	function init(){
		parent::init();

		$this->hasOne('xHR/Department','from_department_id');
		$this->hasOne('xShop/Order','order_id');
		
		$this->addField('name');
		
		$this->hasMany('xPurchase/PurchaseMaterialRequestItem','purchase_material_request_id');
		
		$this->add('dynamic_model/Controller_AutoCreator');
	}
	
	function submit(){
		$this['status']='submitted';
		$this->saveAndUnload();
		return $this;
	}

	function itemrows(){
		return $this->ref('xPurchase/PurchaseMaterialRequestItem');
	}

	// Actually its Accepting send Goods
	function approve(){
		$this['status']='completed';
		$this->saveAndUnload();
	}

	function mark_processed_page($page){
		$form = $page->add('Form_Stacked');

		$cols = $form->add('Columns');
		$sno_cols= $cols->addColumn(1);
		$item_cols= $cols->addColumn(7);
		$req_qty_cols= $cols->addColumn(2);
		$alloted_qty= $cols->addColumn(2);

		$i=1;
		foreach($this->itemrows() as $ir){
			$sno_cols->add('View')->set($i);
			$item_cols->addField('Readonly','item_'.$i,'Item')->set($ir['item']);
			$req_qty_cols->addField('Readonly','req_qty_'.$i,'Qty')->set($ir['qty']);
			$alloted_qty->addField('Number','alloted_qty_'.$i,'Alloted Qty')->set($ir['qty']);
			$i++;
		}

		$form->addSubmit('Transfer');

		if($form->isSubmitted()){
			$i=1;
			
			$from_warehouse = $this->add('xStore/Model_Warehouse')->loadPurchase();
			
			// Always to any warehouse/department
			// this is material request :: never to send directly to customer from here
			$to_warehouse = $this->ref('from_department_id')->warehouse();

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

}		
