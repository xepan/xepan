<?php
namespace xStore;

class Model_Warehouse extends \Model_Table{
	public $table="xstore_warehouse";
	function init(){
		parent::init();

			$this->hasOne('xHR/Department','department_id');
			$this->hasOne('xProduction/OutSourceParty','out_source_party_id');
			
			$this->addField('name');

			$this->hasMany('xStore/Stock','warehouse_id');
			
			$this->add('dynamic_model/Controller_AutoCreator');
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
		$m['from_warehouse_id'] = $this->id;
		$m['to_warehouse_id'] = $to_warehouse->id;

		if($material_request){
			$m['material_request_id']=$material_request->id;

			$m['related_root_document_name'] = $material_request['related_root_document_name']?: $material_request->root_document_name;
			$m['related_document_name'] = $material_request['related_document_name']?: $material_request->document_name;
			$m['related_document_id'] = $material_request['related_document_id']?: $material_request->id;

		}

		$m->save();
		return $m;
	}

	function addStockItem($item,$qty){
		$stock = $this->ref('xStore/Stock')->addCondition('item_id',$item->id)->tryLoadAny();
		$stock['qty'] = $stock['qty'] + $qty;
		$stock->save();
		return $this;
	}

	function deductItemStock($item,$qty){
		$stock = $this->ref('xStore/Stock')->addCondition('item_id',$item->id)->tryLoadAny();
		$stock['qty'] = $stock['qty'] - $qty;
		$stock->save();
		return $this;
	}
}		
