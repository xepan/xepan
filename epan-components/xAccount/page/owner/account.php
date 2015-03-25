<?php
class page_xAccount_page_owner_account extends page_xAccount_page_owner_main{
	function init(){
		parent::init();

	$account = $this->add('xAccount/Model_Account');
		$crud = $this->app->layout->add('CRUD');
		$crud->setModel($account);
	}
}