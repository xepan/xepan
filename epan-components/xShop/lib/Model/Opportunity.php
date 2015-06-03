<?php

namespace xShop;

class Model_Opportunity extends \Model_Document {
	public $table="xshop_opportunity";
	public $status=array('active','dead','converted');
	public $root_document_name="xShop\Opportunity";

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_manage_attachments'=>array(),
			'can_see_activities'=>array(),
		);
	
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xMarketingCampaign/Lead','lead_id')->sortable(true)->group('a~6~Opportunity From');
		$this->hasOne('xShop/Customer','customer_id')->sortable(true)->group('a~6');
		// $this->hasOne('xHR/Employee','employee_id')->caption('Handled By')->sortable(true);
		
		$this->addField('opportunity')->type('text')->hint('New Sales of Any product')->mandatory(true);

		$this->addExpression('name')->set(function($m,$q){
				return "
						IF(
							".$q->getField('lead_id')." is not null,
							CONCAT('(L) ',(".$m->add('xMarketingCampaign/Model_Lead')->addCondition('id',$q->getField('lead_id'))->_dsql()->del('fields')->field('name')->render().")),
							IF(
								".$q->getField('customer_id')." is not null,
								CONCAT('(C) ',(".$m->add('xShop/Model_Customer')->addCondition('id',$q->getField('customer_id'))->_dsql()->del('fields')->field('name')->render().")),
								'UNKNOWN'
								)
						)";
		});

		$this->getElement('status')->enum($this->status)->defaultValue('active');

		$this->hasMany('xShop/Quotation','opportunity_id');

		$this->addHook('beforeSave',$this);
		$this->addHook('afterInsert',$this);
		$this->addHook('beforeDelete',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterInsert($obj,$new_id){
		// $obj->load($new_id);
		// $obj->setStatus('active');
	}

	function beforeSave(){
		if( !($this['lead_id'] or $this['customer_id']) )
			throw $this->exception('Lead or Customer Required','ValidityCheck')->setField('lead_id');
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