<?php
namespace xPurchase;
class Model_PurchaseMaterialRequest_Rejected extends Model_PurchaseMaterialRequest{
	function init(){
		parent::init();
		$this->addCondition('status','rejected');
	}
}	