<?php
namespace xPurcahse;

class Model_PurchaseMaterialRequest extends \Model_Table{
	public $table="xpurcahse_material_request";
	function init(){
		parent::init();

		$this->addField('name');
		
			$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
