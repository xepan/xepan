<?php

class page_xProduction_page_owner_dashboard extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		$this->app->title="Production" .': Dashboard';		

				$x = <<<EOF
		Running Works (from sales dash)
		Commitments (from sales dash)
		Over Due Orders (@ both sales also)
		Out Source Job Cards (from sales order)
		Running Job Cards (from sales Order)
		

EOF;

		$this->add('View')->setHTML(nl2br($x));


	}
}