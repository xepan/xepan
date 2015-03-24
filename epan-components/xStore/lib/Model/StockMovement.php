<?php

namespace xStore;
class Model_StockMovement extends \Model_Document{
	public $table="xstore_stock_movement_master";
	public $status = array('draft','submitted','accepted','rejected');
	public $root_document_name="xStore\StockMovement";

	function init(){
		parent::init();

		$this->hasOne('xStore/Warehouse','from_warehouse_id');
		$this->hasOne('xStore/Warehouse','to_warehouse_id');

		$this->hasOne('xPurchase/Supplier','from_supplier_id');
		$this->hasOne('xPurchase/Supplier','to_supplier_id');
		
		$this->hasOne('xShop/MemberDetails','from_memberdetails_id');
		$this->hasOne('xShop/MemberDetails','to_memberdetails_id');

		$this->hasOne('xStore/MaterialRequest','material_request_jobcard_id');
		$this->hasOne('xProduction/JobCard','jobcard_id');
		$this->hasOne('xPurchase/PurchaseOrder','po_id');
		$this->hasOne('xDispatch/DispatchRequest','dispatch_request_id');
		
		$this->addField('name');

		$this->addField('type')->enum(array('StockTransfer','Sales','Purchase','SalesReturn','PurchaseReturn','ProductionConsume'));

		$this->getElement('status')->defaultValue('submitted');

		$this->hasMany('xStore/StockMovementItem','stock_movement_id');

		// $this->add('dynamic_model/Controller_AutoCreator');	
	}

	function fromWarehouse($warehouse=false){
		if($warehouse)
			$this['from_warehouse_id'] = $warehouse->id;
		else
			return $this->ref('from_warehouse_id');
	}

	function toWarehouse($warehouse=false){
		if($warehouse)
			$this['to_warehouse_id'] = $warehouse->id;
		else
			return $this->ref('to_warehouse_id');
	}

	function itemrows(){
		return $this->ref('xStore/StockMovementItem')->addCondition('stock_movement_id',$this->id);
	}

	function addItem($item,$qty,$unit,$custom_fields){
		$new_item = $this->ref('xStore/StockMovementItem');
		$new_item['item_id'] = $item->id;
		$new_item['qty'] = $qty;
		$new_item['unit'] = $unit;
		$new_item['custom_fields'] = $custom_fields;
		$new_item->save();

		return $this;
	}

	function execute(){

	}

	function executeStockTransfer(){
		foreach ($this->itemrows() as $itemrow) {
			if($itemrow->item()->isMantainInventory()){
				$this->fromWarehouse()->deductItemStock($itemrow->item(),$itemrow['qty']);
			}
		}
	}

	function executePurchase($add_to_stock=false){
		if($add_to_stock){
			$this->acceptMaterial();
		}
	}

	function executeSales(){

	}

	function executeConsume(){
		foreach ($this->itemrows() as $itemrow) {
			if($itemrow->item()->isMantainInventory()){
				$this->fromWarehouse()->deductItemStock($itemrow->item(),$itemrow['qty']);
			}
		}
		$this->setStatus('accepted');
	}

	function acceptMaterial(){
		foreach ($this->itemrows() as $ir) {
			
			if($ir->item()->isMantainInventory()){
				$this->toWarehouse()->addStockItem($ir->item(),$ir['qty'],$ir['custom_fields']);
				// throw new \Exception("Error Processing Request", 1);
			}
		}
		$this->setStatus('accepted');
		return true;
	}
}