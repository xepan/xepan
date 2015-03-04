<?php
namespace xPurchase;
class Model_PurchaseMaterialRequest_Submitted extends Model_PurchaseMaterialRequest{
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	