<?php

namespace xShop;

class Model_Quotation_Submitted extends Model_Quotation{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_approve'=>array(),
			'can_reject'=>array(),
		);
	

	function init(){
		parent::init();

		$this->addCondition('status','submitted');
	}

	function approve(){
		$this['status'] = 'approved';
		$this->saveAndUnload();
		return "Quotation Approved";
	}

	function redesign(){
		$this['status'] = 'redesign';
		$this->saveAndUnload();
		return "Quotation Approved";
	}
}