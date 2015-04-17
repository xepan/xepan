<?php

class page_xPurchase_page_owner_dashboard extends page_xPurchase_page_owner_main {
	
	function initMainPage(){
		$this->app->title="xPurchase" .': Dashboard';
						$x = <<<EOF
		Todays Approved Order => Todays Sales
		Todays Delived/Completed ORders
		Todays ORder Canceled

		Material Requests to Purchase

		Short Qty Items

EOF;

		$this->add('View')->setHTML(nl2br($x));
	}

}