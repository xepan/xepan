<?php
namespace xStore;

class Model_Warehouse extends \Model_Table{
	public $table="xstore_warehouse";
	function init(){
		parent::init();

			$this->hasOne('xHR/Department','department_id')->sortable(true);
			$this->hasOne('xProduction/OutSourceParty','out_source_party_id')->sortable(true);
			
			$this->addField('name')->sortable(true);

			$this->addHook('beforeDelete',$this);
			$this->hasMany('xStore/Stock','warehouse_id');
			
			//$this->add('dynamic_model/Controller_AutoCreator');
	}
	function beforeDelete(){
		if($this->ref('xStore/Stock')->count()->getOne() > 0)
			throw $this->exception('Stock Contains of WareHouse.. Please Delete First Warehouse','Growl');
			
	}

	function getStock($item){
		$stock = $this->ref('xStore/Stock')->addCondition('item_id',$item->id)->tryLoadAny();
		if(!$stock->loaded()){
			return 0;
		}
		return $stock['qty'];
	}

	function newStockTransfer($to_warehouse, $material_request=null){
		if(!$to_warehouse instanceof \xStore\Model_Warehouse)
			throw $this->exception('=> Stock Transfer can only be between warehouses.. argument is of type '. get_class($to_warehouse));

		$m = $this->add('xStore/Model_StockMovement');
		$m['type'] = 'StockTransfer';

		$m['from_warehouse_id'] = $this->id;
		$m['to_warehouse_id'] = $to_warehouse->id;

		if($material_request){
			$m['material_request_jobcard_id']=$material_request->id;
			$m->relatedDocument($material_request);
		}

		$m->save();
		return $m;
	}

	function newPurchaseReceive($purchase_order){
		$m = $this->add('xStore/Model_StockMovement');
		$m['type'] = 'Purchase';

		$m['from_supplier_id'] = $purchase_order['supplier_id'];
		$m['to_warehouse_id'] = $this->id;

		$m['po_id']=$purchase_order->id;

		$m['related_root_document_name'] = $purchase_order['related_root_document_name']?: $purchase_order->root_document_name;
		$m['related_document_name'] = $purchase_order['related_document_name']?: $purchase_order->document_name;
		$m['related_document_id'] = $purchase_order['related_document_id']?: $purchase_order->id;

		$m->save();
		return $m;
	}

	function addItemStock($item,$qty,$custom_fields_json){$this->addStockItem($item,$qty,$custom_fields_json);}
	function addStockItem($item,$qty,$custom_fields_json){
		if(!(is_string($custom_fields_json) && is_object(json_decode($custom_fields_json)) && (json_last_error() == JSON_ERROR_NONE)))
			throw $this->exception('Custom Fields Not Defined','Growl');
			
		$stock = $this->ref('xStore/Stock');
		$stock->addCondition('item_id',$item->id);
		$cf_string = "";

		foreach (json_decode($custom_fields_json) as $department) {
			foreach($department as $cf_id => $cf_value_id) {
				//check for custom filed value
				$cf_string .= "".$cf_id.":".$cf_value_id." ";
				$stock->addCondition('custom_fields','like',"%$cf_id:$cf_value_id%");
			}
		}


		$stock->tryLoadAny();
		$stock['custom_fields'] = $cf_string;
		$stock['qty'] = $stock['qty'] + $qty;
		$stock->saveAs('xStore/Model_Stock');
		return $this;
	}

	function deductStockItem($item,$qty){$this->deductItemStock($item,$qty);}
	function deductItemStock($item,$qty){
		$stock = $this->ref('xStore/Stock')->addCondition('item_id',$item->id)->tryLoadAny();
		if($stock['qty'] - $qty < 0 AND ! $item->allowNegativeStock()){
			throw $this->exception('Stock Insufficient '. $stock['qty']);
		}
		$stock['qty'] = $stock['qty'] - $qty;
		$stock->save();
		return $this;
	}

	function loadPurchase(){
		if($this->loaded())
			throw $this->exception('Already loaded. cannot load purchase warehouse');

		$this->addCondition('department_id',$this->add('xHR/Model_Department')->loadPurchase()->get('id'));
		$this->tryLoadAny();
		if(!$this->loaded()) {
			$this['name']='Purchase';
			$this->save();
		}

		return $this;
	}

	function deleteIfOK(){
		throw $this->exception('WareHouse DeleteIfOK','Growl');
	}

	function department(){
		return $this->ref('department_id');
	}
}		
