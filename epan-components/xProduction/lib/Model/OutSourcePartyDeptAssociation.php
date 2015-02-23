<?php
namespace xProduction;
class Model_OutSourcePartyDeptAssociation extends \Model_Table{
	public $table="xhr_outsource_party_dept_associations";
	function init(){
		parent::init();

		$this->hasOne('xHR/Department','department_id');
		$this->hasOne('xProduction/OutSourceParty','out_source_party_id');

			
		$this->add('dynamic_model/Controller_AutoCreator'); 
	}
}