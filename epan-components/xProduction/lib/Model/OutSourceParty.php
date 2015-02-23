<?php
namespace xProduction;
class Model_OutSourceParty extends \Model_Table{
	public $table="xproduction_out_source_parties";
	function init(){
		parent::init();

		$this->addField('name')->Caption('Party');
		$this->addField('code')->Caption('Party Code');
		$this->addField('maintain_stock')->type('boolean')->defaultValue(false)->group('a~4');

		$this->hasMany('xProduction/OutSourcePartyDeptAssociation','out_source_party_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}