<?php
namespace xShop;

class Model_Order_Approved extends Model_Order{

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(approved) this post can see'),
			'can_reject'=>array('caption'=>'Can this post Reject Order(approved)')
		);
	

	function init(){
		parent::init();

		$this->addCondition('status','approved');
	}
}