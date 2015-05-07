<?php

namespace xShop;

class Model_Opportunity extends \Model_Document {
	public $table="xshop_opportunity";
	public $status=array('active','dead','converted');
	public $root_document_name="xShop\Opportunity";

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Opportunity this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Opportunity this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Opportunity'),
			'allow_del'=>array('caption'=>'Whose Created Opportunity this post can delete'),
		);
	
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xMarketingCampaign/Lead','lead_id')->sortable(true);
		$this->hasOne('xShop/Customer','customer_id')->sortable(true);
		$this->hasOne('xHR/Employee','employee_id')->caption('Handled By')->sortable(true);
		

		$this->addField('name')->caption('Opportunity')->hint('New Sales of X product')->sortable(true);

		$this->getElement('status')->enum($this->status)->defaultValue('active');

		$this->hasMany('xShop/Quotation','opportunity_id');

		$this->addHook('afterInsert',$this);
		$this->addHook('beforeDelete',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterInsert($obj,$new_id){
		$obj->load($new_id);

		$obj->setStatus('active');
		
	}

	function beforeDelete(){
		$quotation = $this->ref('xShop/Quotation')->count()->getOne();
		if($quotation)
			throw $this->exception('Cannot Delete, First Delete it\'s Quotation','Growl');
	}

	function forceDelete(){
		$this->ref('xShop/Quotation')->each(function($q){
			$q->forceDelete();
		});

		$this->delete();
	}

	function mark_dead($reason){
		return "Quotation";
	}
}