<?php

namespace xProduction;

class Model_MaterialRequirment extends \Model_Document{
	public $table ="xproduction_material_requirment";
	public $status=array('draft','approved','reject','submit');
	function init(){
		parent::init();

		$this->hasOne('xProduction/Model_JobCard','jobcard_id');
		$this->hasOne('xShop/OrderDetails','orderitem_id');
		$this->hasOne('xHR/Department','department_id');
		
		$this->addField('name')->type('line')->caption('Name Of Required Item');
		$this->addField('qty')->type('line')->caption('Quantity');
		$this->addField('narration')->type('text')->caption('Naration');
		
		$this->add('dynamic_model/Controller_AutoCreator');

	}
}	