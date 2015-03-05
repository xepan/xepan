<?php
namespace xPurchase;
class Model_PurchaseMaterialRequest_Completed extends Model_PurchaseMaterialRequest{
	function init(){
		parent::init();
		$this->addCondition('status','completed');
	}

		
}	

