<?php
namespace xShop;

class Model_Order_Redesign extends Model_Order{

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(approved) this post can see'),
			'can_submit'=>array('caption'=>'Can this post reS Submit Order(approved)')
		);
	

	function init(){
		parent::init();

		$this->addCondition('status','redesign');
	}
}