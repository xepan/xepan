<?php

class page_xAccount_page_owner_dashboard extends page_xAccount_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';

				$x = <<<EOF
		Todays Business (Total, Cash, Bank)
		Total Accounts Receivables
		Total Accounts Payable
		
		Cash In Hand
		Bank Status
		
		Recent Financial Transactions (From Day Book)

EOF;

		$this->add('View')->setHTML(nl2br($x));
	}
}