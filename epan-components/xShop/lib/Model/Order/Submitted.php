<?php
namespace xShop;

class Model_Order_Submitted extends Model_Order{

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Order(submit) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Order(submit) this post can edit'),
			'can_approve'=>array('caption'=>'Can this post Approve Order(submit)'),
			'can_reject'=>array('caption'=>'Can this post Reject Order(submit)'),
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','submitted');
	}
}