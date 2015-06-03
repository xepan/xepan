<?php

namespace xShop;

class Model_Tax extends \Model_Document{
	public $table="xshop_taxs";
	public $status=array();
	public $root_document_name='xShop\Tax';

	public $actions=array(
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
		);

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->addField('name')->mandatory(true);
		$this->addField('value')->caption('Tax in %')->mandatory(true);

		$this->hasMany('xShop/ItemTaxAssociation','tax_id');
		$this->hasMany('xShop/OrderDetails','tax_id');
		$this->hasMany('xShop/InvoiceItem','tax_id');
		
		$this->addHook('beforeDelete',$this);
		$this->addHook('beforeSave',$this);
		$this->addHook('afterInsert',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
		
	}

	function beforeSave(){
		$account = $this->account();
				
		if($account->loaded())
			$account->set('name',$this['name'])->save();
	}

	function afterInsert($obj,$new_id){
		$tax_m = $this->newInstance()->load($new_id);

		$acc = $this->add('xAccount/Model_Account');
		$acc->addCondition('group_id',$this->add('xAccount/Model_Group')->loadDutiesAndTaxes()->fieldQuery('id'));
		$acc->addCondition('name',$tax_m['name']);
		$acc->tryLoadAny();
		$acc->save();

		$this['tax_account_id']=$acc['id'];
		$this->save();
	}

	function beforeDelete($m){
		if($this->ref('xShop/ItemTaxAssociation')->count()->getOne())
			throw $this->exception('Cannot Delete, First delete Item Tax Included','Growl');		
	}

	function forceDelete(){
		$this->ref('xShop/ItemTaxAssociation')->each(function($m){
			$m->forceDelete();
		});
		$this->delete();
	}
	
}