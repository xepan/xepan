<?php
namespace xStore;

class Model_Warehouse extends \Model_Table{
	public $table="xstore_warehouse";
	function init(){
		parent::init();

			$this->hasOne('xHR/Department','department_id');
			$this->hasOne('xProduction/OutSourceParty','out_source_party_id');
			
			$this->addField('name');
			$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
