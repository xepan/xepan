<?php
namespace xPurchase;
class Model_PurchaseMaterialRequest_Approved extends Model_PurchaseMaterialRequest{
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	