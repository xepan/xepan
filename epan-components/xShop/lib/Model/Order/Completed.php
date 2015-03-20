<?php
namespace xShop;

class Model_Order_Completed extends Model_Order{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(complete) this post can see'),
			
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','completed');
	}
}