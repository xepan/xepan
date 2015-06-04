<?php
namespace xProduction;
class Model_OutSourceParty extends \Model_Document{
	public $table="xproduction_out_source_parties";
	public $root_document_name='xProduction\OutSourceParty';
	public $status = array();
 	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_see_activities'=>array(),
		);

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->addField('name')->Caption('Party')->sortable(true)->group('a~5~Basic Info');
		$this->addField('contact_person')->sortable(true)->group('a~5');
		$this->addField('code')->Caption('Party Code')->sortable(true)->group('a~2');
		
		$this->addField('contact_no')->sortable(true)->group('b~4~ Contact Detail');
		$this->addField('email_id')->sortable(true)->group('b~4');
		$this->addField('address')->type('text')->sortable(true)->group('b~4');
		
		$this->addField('bank_detail')->type('text')->group('c~12~ Bank Detail');
		
		$this->addField('pan_it_no')->caption('Pan / IT No.')->group('d~4~ Company Detail');//type('text');
		$this->addField('tin_no')->caption('TIN / CST No.')->group('d~4~');
		
		$this->addField('maintain_stock')->type('boolean')->defaultValue(false)->group('e~4~MaintainStock')->sortable(true);

		$this->hasMany('xProduction/OutSourcePartyDeptAssociation','out_source_party_id');
		$this->hasMany('xStore/Warehouse','out_source_party_id');
		$this->hasMany('xAccount/Account','out_source_party_id');

		$this->addHook('beforeDelete',$this);
		$this->addHook('beforeSave',$this);
		$this->addHook('afterInsert',$this);
		$this->add('Controller_Validator');
		$this->is(array(
							'code|unique'
						)
				);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		$warehouse = $this->ref('xStore/Warehouse')->count()->getOne();
		$account = $this->ref('xAccount/Account')->count()->getOne();
		
		if($warehouse or $account)
			throw $this->exception('Cannot Delete, First Delete OutSourceParty Warehouse or Account');
		
		$this->ref('xProduction/OutSourcePartyDeptAssociation')->each(function($m){
			$m->forceDelete();
		});
	}
	
	function forceDelete_page($page){
		$form = $page->add('Form_Stacked');
		$form->add('View_Warning')->set('All Department Association, Warehouse and Account will be deleted');

		$str = "";
		$this->account()->each(function($m){
			$str = $m['name']." ".$m['account_type']." Opening Balance Dr = ".$m['OpeningBalanceDr']." Opening Balance Cr = ".$m['OpeningBalanceCr']." Current Balance Dr =".$m['CurrentBalanceDr']." Current Balance Cr".$m['CurrentBalanceCr'];
		});

		$form->addSubmit('Force Delete');
		
		if($form->isSubmitted()){
			$this->forceDelete();
		}

	}

	function forceDelete(){
		$this->ref('xStore/Warehouse')->each(function($m){
			$m->forceDelete();
		});

		$this->ref('xAccount/Account')->each(function($m){
			$m->forceDelete();
		});

		$this->delete();
	}
	
	function beforeSave(){
		if($this->loaded()){
			$account = $this->account();
			if($account->loaded() and $this->dirty['name'])
				$account->set('name',$this['name'])->save();		
		}
	}

	function account(){
		return $this->ref('xAccount/Account')->addCondition('group_id',$this->add('xAccount/Model_Group')->loadSundryCreditor()->fieldQuery('id'))->tryLoadAny();
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

	function afterInsert($obj,$new_id){		
		$out_source_party_model=$this->add('xProduction/Model_OutSourceParty')->load($new_id);
		$out_source_party_model_value = array($out_source_party_model);
		$this->api->event('new_out_source_party_registered',$out_source_party_model_value);
	}
}
