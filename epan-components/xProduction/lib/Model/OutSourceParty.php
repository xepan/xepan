<?php
namespace xProduction;
class Model_OutSourceParty extends \Model_Table{
	public $table="xproduction_out_source_parties";
	function init(){
		parent::init();

		$this->addField('name')->Caption('Party')->sortable(true);
		$this->addField('code')->Caption('Party Code')->sortable(true);
		$this->addField('contact_no')->Caption('number')->sortable(true);
		$this->addField('address')->type('text')->sortable(true);
		$this->addField('maintain_stock')->type('boolean')->defaultValue(false)->group('a~4')->sortable(true);

		$this->hasMany('xProduction/OutSourcePartyDeptAssociation','out_source_party_id');
		$this->hasMany('xStore/Warehouse','out_source_party_id');

		$this->addHook('beforeDelete',$this);

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		throw $this->exception('Delete Warehouse');
	}

	function warehouse(){
		if(!$this['maintain_stock']) return false;
		$w = $this->ref('xStore/Warehouse')->tryLoadAny();
		if(!$w->loaded()){
			$w['name'] = $this['name'];
			$w['code'] = $this['name'];
			$w->save();
		}

		return $w;
	}

	function getAssociatedDepartments(){
		$associated_departments = $this->ref('xProduction/OutSourcePartyDeptAssociation')->_dsql()->del('fields')->field('department_id')->getAll();
		$array =  iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_departments)),false);

		if(!count($array)) $array = array(0);

		return $array;
	}
}