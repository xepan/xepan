<?php

namespace xShop;

class Model_Quotation_Redesign extends Model_Quotation{

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_submit'=>array(),
			'can_cancel'=>array(),
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','redesign');

	}
}