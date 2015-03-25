<?php
class page_xAccount_page_owner_transaction extends page_xAccount_page_owner_main{
	function init(){
		parent::init();

	$transaction = $this->add('xAccount/Model_Transaction');
		$crud = $this->app->layout->add('CRUD');
		$crud->setModel($transaction);
	}
}