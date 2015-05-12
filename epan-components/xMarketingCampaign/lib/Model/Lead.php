<?php

namespace xMarketingCampaign;

class Model_Lead extends \xEnquiryNSubscription\Model_Subscription{
	// public $table="xmarketingcampaign_leads";
	public $status=array();
	public $root_document_name="xMarketingCampaign\Lead";

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_start_processing'=>array(),
		);
	
	function init(){
		parent::init();
		$this->getElement('from_app')->defaultValue('Manual Feed');

		$this->addExpression('total_opportunity')->set(function($m,$q){
			return $m->refSQL('xShop/Opportunity')->count();
		})->sortable(true);

		$this->addExpression('total_quotation')->set(function($m,$q){
			return $m->refSQL('xShop/Quotation')->count();
		})->sortable(true);

	}

	function start_processing_page($page){
		$form = $page->add('Form_Stacked');
		$form->addField('text','opportunity');
		$form->addSubmit('Create Opportunity');
		if($form->isSubmitted()){
			$this->start_processing($form['opportunity']);
			return true;
		}

		return false;
	}

	//Actual Creating the Opportunity
	function start_processing($opportunity_text){
		$opportunity = $this->add('xShop/Model_Opportunity');
		$opportunity['lead_id'] = $this->id;
		$opportunity['status']='active';
		$opportunity['opportunity']=$opportunity_text;
		$opportunity->save();

	}

}