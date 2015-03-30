<?php
class page_xAccount_page_owner_ledgers extends page_xAccount_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Ledgers/Groups';

		$group = $this->add('xAccount/Model_Account');
		$crud = $this->app->layout->add('CRUD');
		$crud->setModel($group,array('name','group_id','OpeningBalanceCr','OpeningBalanceDr'),array('name','group','CurrentBalanceCr','CurrentBalanceDr'));
	}
}