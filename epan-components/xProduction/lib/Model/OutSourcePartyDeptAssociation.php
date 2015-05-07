<?php
namespace xProduction;
class Model_OutSourcePartyDeptAssociation extends \Model_Table{
	public $table="xproduction_outsource_party_dept_associations";
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xHR/Department','department_id');
		$this->hasOne('xProduction/OutSourceParty','out_source_party_id');

			
		//$this->add('dynamic_model/Controller_AutoCreator'); 
	}
}