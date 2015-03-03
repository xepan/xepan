<?php
namespace xPurchase;

class Model_PurchaseMaterialRequest extends \Model_Table{
	public $table="xpurcahse_material_request";
	function init(){
		parent::init();
		$this->hasOne('xHR/Department','from_department_id');
		$this->hasOne('Document','related_document_id');
		$this->hasOne('xShop/Order','order_id');
		
		$this->addField('name');
		
		$this->hasMany('xPurchase/PurchaseMaterialRequestItem','purchase_material_request_id');
		
		$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
