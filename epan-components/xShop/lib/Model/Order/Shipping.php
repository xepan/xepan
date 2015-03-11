<?php
namespace xShop;

class Model_Order_Shipping extends Model_Order{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(shipping) this post can see'),
			
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','shipping');
	}
}