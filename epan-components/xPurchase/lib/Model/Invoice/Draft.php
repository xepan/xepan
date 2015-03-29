<?php

namespace xPurchase;
class Model_Invoice_Draft extends Model_PurchaseInvoice{
	public $actions=array(
			'can_view'=>array(),
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_submit'=>array()
		);

	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	