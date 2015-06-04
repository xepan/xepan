<?php

namespace xShop;

class Model_Quotation_Processed extends Model_Quotation{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_send_via_email'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','processed');

	}

	

}