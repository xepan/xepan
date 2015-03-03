<?php

namespace xStore;
class Model_StockMovement extends \Model_Document{
	public $table="xstore_stock_movement_master";
	public $status = null;
	public $root_document_name="xStore\StockMovement";
	function init(){
		parent::init();

		$this->hasOne('Document','related_document_id');
		$this->addField('root_document_name');
		$this->addField('document_name');

		$this->hasOne('xStore/Warehouse','from_wherehouse_id');
		$this->hasOne('xStore/Warehouse','to_wherehouse_id');

		$this->hasOne('xPurchase/Supplier','from_supplier_id')
		$this->hasOne('xPurchase/Supplier','to_supplier_id')
		
		$this->hasOne('xShop/MemberDetails','from_memberdetails_id')
		$this->hasOne('xShop/MemberDetails','to_memberdetails_id')

		$this->hasOne('xStore/MaterialRequest','material_request_id');
		$this->hasOne('xHR/Department','to_department_id');



		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));

		$this->hasMany('xStoreStockMovementItem','stock_movement_id');

		$this->add('dynamic_model/Controller_AutoCreator');	
	}
}