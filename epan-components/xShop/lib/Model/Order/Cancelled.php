<?php
namespace xShop;

class Model_Order_Cancelled extends Model_Order{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(cancel) this post can see'),
			
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','cancelled');
	}
}