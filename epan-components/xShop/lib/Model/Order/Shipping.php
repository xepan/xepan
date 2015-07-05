<?php
namespace xShop;

class Model_Order_Shipping extends Model_Order{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
			
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','shipping');
	}
}