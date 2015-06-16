<?php

namespace xShop;

class Model_Quotation_Cancelled extends Model_Quotation{

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_see_activities'=>array(),
		);

	function init(){
		parent::init();

		$this->addCondition('status','cancelled');

	}

	

}