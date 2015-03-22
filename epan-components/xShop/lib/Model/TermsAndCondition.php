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
		
		$this->addField('name')->caption('Terms Title');
		$this->addField('terms_and_condition')->type('text')->display(array('form'=>'RichText'));
		
		$this->hasMany('xShop/Quotation','termsandcondition_id');
		$this->hasMany('xShop/Order','termsandcondition_id');

		// $this->add('dynamic_model/Controller_AutoCreator');
		
	}
}