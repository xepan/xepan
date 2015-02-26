<?php
namespace xStore;

class Model_MaterialRequest extends \Model_Table{
	public $table="xstore_material_request";
	function init(){
		parent::init();

		$this->addField('name');
		
			$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
