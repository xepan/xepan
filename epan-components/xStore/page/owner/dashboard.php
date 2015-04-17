<?php

class page_xStore_page_owner_dashboard extends page_xStore_page_owner_main{
	
	function init(){
		parent::init();

					$x = <<<EOF
		Short Qty Items
		TODO : Conversion


		

EOF;

		$this->add('View')->setHTML(nl2br($x));		

	}
}