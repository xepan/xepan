<?php
namespace xShop;

class Model_Order_Draft extends Model_Order{
	
	public $actions=array(
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'can_submit'=>array(),
			'allow_del'=>array(),
			'can_manage_attachments'=>array(),
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','draft');
	}
}