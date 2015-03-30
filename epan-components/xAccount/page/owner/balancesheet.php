<?php
class page_xAccount_page_owner_balancesheet extends page_xAccount_page_owner_main{
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Balance Sheet';
	$balance_sheet = $this->add('xAccount/Model_BalanceSheet');
		$crud = $this->app->layout->add('CRUD');
		$crud->setModel($balance_sheet);
		$crud->add('xHR/Controller_Acl');
		
	}
}