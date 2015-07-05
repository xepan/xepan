<?php

namespace xShop;

class Model_Quotation_Approved extends Model_Quotation{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'can_send_via_email'=>array(),
			'can_cancel'=>array(),
			'can_see_activities'=>array(),
		);

	function init(){
		parent::init();

		$this->addCondition('status','approved');

	}

	function creatOrder(){
		if(!$this->loaded())
			throw new \Exception("Model Must be Loaded before create Order",'Approved');
			
		$order = $this->add('xShop/Model_Order');
		if($order->placeOrderFromQuotation($this['id']));
			return "Order Created ";
			
		return "Something Gone Wrong";
	}

}