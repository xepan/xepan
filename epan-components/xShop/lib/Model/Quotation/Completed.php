<?php

namespace xShop;

class Model_Quotation_Completed extends Model_Quotation{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','completed');

	}

	

}