<?php
namespace xPurchase;
class Model_PurchaseMaterialRequest_Processed extends Model_PurchaseMaterialRequest{
	function init(){
		parent::init();
		$this->addCondition('status','processed');
	}
}	