<?php

namespace xProduction;

class Model_MaterialRequirment extends \Model_Document{
	public $table ="xproduction_material_requirment";
	public $status=array('draft','approved','reject','submit');
	public $root_document_name='xStore\MaterialRequirment';
	function init(){
		parent::init();

		$this->hasOne('xProduction/Model_JobCard','jobcard_id');
		$this->hasOne('xShop/OrderDetails','orderitem_id');
		$this->hasOne('xHR/Department','department_id');
		
		$this->addField('name');
		$this->addField('qty');
		$this->addField('narration');
		
		//$this->add('dynamic_model/Controller_AutoCreator');

	}
}	