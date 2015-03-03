<?php
namespace xStore;

class Model_MaterialRequest extends \xProduction\Model_JobCard{
	public $root_document_name='xStore\MaterialRequest';
	function init(){
		parent::init();

		$this->hasOne('xHR/Department','from_department_id');
		$this->hasOne('Document','related_document_id');
		$this->hasOne('xShop/Order','order_id');

		$this->hasMany('xStore/MaterialRequestItem','material_request_id');
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function receive(){
		throw new \Exception("Receiving", 1);
		
		parent::receive();
	}
}		
