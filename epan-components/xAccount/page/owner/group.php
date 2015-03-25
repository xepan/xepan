<?php
class page_xAccount_page_owner_group extends page_xAccount_page_owner_main{
	function init(){
		parent::init();

	$group = $this->add('xAccount/Model_Group');
		$crud = $this->app->layout->add('CRUD');
		$crud->setModel($group);
	}
}