<?php

namespace xShop;

class Model_Quotation_Approved extends Model_Quotation{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Quotation(approved) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Quotation(approved) this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create Quotation(approved)'),
			'allow_del'=>array('caption'=>'Whose Created Quotation(approved) this post can delete'),
			'can_approve'=>array('caption'=>'Whose Created Quotation(approved) this post can approved'),
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