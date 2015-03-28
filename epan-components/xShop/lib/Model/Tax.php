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
		
		$this->addField('name')->mandatory(true);
		$this->addField('value')->caption('Tax in %')->mandatory(true);

		$this->hasMany('xShop/ItemTaxAssociation','tax_id');
		$this->addHook('beforeDelete',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
		
	}

	function beforeDelete($m){
		if($this->ref('xShop/ItemTaxAssociation')->count()->getOne())
			throw $this->exception('Canot Delete, First delete Item Tax Included','Growl');		
	}

	
}