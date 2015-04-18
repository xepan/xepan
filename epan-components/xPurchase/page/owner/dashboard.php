<?php

class page_xPurchase_page_owner_dashboard extends page_xPurchase_page_owner_main {
	
	function initMainPage(){

		$this->app->title=$this->api->current_department['name'] .': Dashboard';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-dashboard icon-gauge"></i> Purchase Department Dashboard');

		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		

		$col = $this->add('Columns');
		$col_1 = $col->addColumn(3);
		$col_2 = $col->addColumn(3);
		$col_3 = $col->addColumn(3);
		$col_4 = $col->addColumn(3);

		$today_approve_tile = $col_1->add('View_Tile')->addClass('atk-swatch-green img-rounded');
		$today_approve_tile->setTitle('Today Approved');
		$today_approve_tile->setContent('ToDo');
		if($is_superuser_login)
			$today_approve_tile->setFooter(money_format('%!i',00000),'icon-money');
	
		$today_complete_tile = $col_2->add('View_Tile')->addClass('atk-swatch-green img-rounded');
		$today_complete_tile->setTitle('Today Deliverd/Completed Orders');
		$today_complete_tile->setContent('TODO');
		if($is_superuser_login)
			$today_complete_tile->setFooter(money_format('%!i',00000),'icon-money');
	
		$today_cancel_tile = $col_3->add('View_Tile')->addClass('atk-swatch-green img-rounded');
		$today_cancel_tile->setTitle('Today Canceled Orders');
		$today_cancel_tile->setContent('TODO');
		if($is_superuser_login)
			$today_cancel_tile->setFooter(money_format('%!i',00000),'icon-money');

		$today_material_request_tile = $col_4->add('View_Tile')->addClass('atk-swatch-green img-rounded');
		$today_material_request_tile->setTitle('Today Material Request to Purchase');
		$today_material_request_tile->setContent('TODO');
		if($is_superuser_login)
			$today_material_request_tile->setFooter(money_format('%!i',00000),'icon-money');

		$this->add('View')->setElement('br');
		$col = $this->add('Columns');
		$col_5 = $col->addColumn(3);

		$today_short_item_tile = $col_5->add('View_Tile')->addClass('atk-swatch-green img-rounded');
		$today_short_item_tile->setTitle('Today Short Items');
		$today_short_item_tile->setContent('TODO');
		if($is_superuser_login)
			$today_short_item_tile->setFooter(money_format('%!i',00000),'icon-money');

	}	

}