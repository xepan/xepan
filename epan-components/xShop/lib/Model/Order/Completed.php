<?php
namespace xShop;

class Model_Order_Completed extends Model_Order{
	public $actions=array(
			'can_view'=>array(),
			'can_forcedelete'=>array(),
			
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','completed');
	}
}