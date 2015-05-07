<?php

namespace xShop;
class Model_TermsAndCondition extends \Model_Document{
	public $table="xshop_termsandcondition";
	public $status=array();
	public $root_document_name='xShop\TermsAndCondition';

	public $actions=array(
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
		);

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->addField('name')->caption('Terms Title');
		$this->addField('terms_and_condition')->type('text')->display(array('form'=>'RichText'));
		
		$this->hasMany('xShop/Quotation','termsandcondition_id');
		$this->hasMany('xShop/Order','termsandcondition_id');

		$this->addHook('beforeDelete',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
		
	}

	function beforeDelete(){
		$quotation = $this->ref('xShop/Quotation')->count()->getOne();
		$order = $this->ref('xShop/Order')->count()->getOne();
		
		if($quotation or $order)
			throw $this->exception('Cannot Delete, First Tax from Order or Quotaion');
	}


	function forceDelete(){
		$this->ref('xShop/Quotaion')->each(function($m){
			$m->setTermAndConditionEmpty();
		});

		$this->ref('xShop/Order')->each(function($m){
			$m->setTermAndConditionEmpty();
		});

		$this->delete();
	}

}