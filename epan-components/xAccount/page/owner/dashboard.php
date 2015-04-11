<?php

class page_xAccount_page_owner_dashboard extends page_xAccount_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';

		$this->add('View_Info')->set('Total Accounts Receivables');
		$this->add('View_Info')->set('Total Accounts Payables');
		$this->add('View_Info')->set('Cash In Hand');
		$this->add('View_Info')->set('Banks Status');

	}
}