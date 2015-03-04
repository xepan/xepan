<?php
namespace xPurchase;
class Model_PurchaseMaterialRequest_Draft extends Model_PurchaseMaterialRequest{
	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	