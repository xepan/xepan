<?php

class page_xPurchase_page_owner_purchasematerialrequest_processed extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$model = $this->add('xPurchase/Model_PurchaseMaterialRequest_Processed');

		$crud=$this->add('CRUD');
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');

	}
}