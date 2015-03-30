<?php
class page_xAccount_page_owner_transactionrow extends page_xAccount_page_owner_main{
	function init(){
		parent::init();

	$transaction_row = $this->add('xAccount/Model_TransactionRow');
		$crud = $this->app->layout->add('CRUD');
		$crud->setModel($transaction_row);
	}
}