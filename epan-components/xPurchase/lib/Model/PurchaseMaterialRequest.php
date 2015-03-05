<?php
namespace xPurchase;

class Model_PurchaseMaterialRequest extends \Model_Document{
	public $table="xpurcahse_material_request";
	public $status=array('draft','approved','rejected','submitted');
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

}		
