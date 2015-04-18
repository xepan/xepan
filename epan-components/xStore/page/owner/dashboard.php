<?php

class page_xStore_page_owner_dashboard extends page_xStore_page_owner_main{
	
	function init(){
		parent::init();

// 					$x = <<<EOF
// 		Short Qty Items
// 		TODO : Conversion


		

// EOF;

// 		$this->add('View')->setHTML(nl2br($x));	
		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		

		$col = $this->add('Columns');
		$col_1 = $col->addColumn(3);
		$col_2 = $col->addColumn(3);
		

		// Short Qty Items
		$short_qty_items_tile = $col_1->add('View_Tile')->addClass('atk-swatch-blue')->setStyle('box-shadow','');
		$short_qty_items_tile->setTitle('Short qty Items');

		

	}
}