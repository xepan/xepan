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

		//today approved Order
		$approved_order = $this->add('xPurchase/Model_PurchaseOrder');
		$approved_order->addExpression('approved_on')->set(function($m,$q){
			$act = $m->add('xCRM/Model_Activity')
				->addCondition('action','approved')
				->addCondition('related_root_document_name',$m->root_document_name)
				->addCondition('related_document_id',$q->getField('id'))
				->setOrder('updated_at','desc')
				->setLimit(1);
			return $act->fieldQuery('created_at');
		});
		$approved_order->addCondition('approved_on','>',$this->api->today);
		$approved_order->addCondition('approved_on','<=',$this->api->nextDate($this->api->today));
		$today_approve_tile = $col_1->add('View_Tile')->addClass('atk-swatch-green img-rounded');
		$today_approve_tile->setTitle('Today Approved');
		$today_approve_tile->setContent($approved_order->count()->getOne());
		if($is_superuser_login)
			$today_approve_tile->setFooter(money_format('%!i',00000),'icon-money');
		
		
		//Today complete Order
		$complete_order = $this->add('xPurchase/Model_PurchaseOrder');
		$complete_order->addExpression('complete_on')->set(function($m,$q){
			$act = $m->add('xCRM/Model_Activity')
				->addCondition('action','completed')
				->addCondition('related_root_document_name',$m->root_document_name)
				->addCondition('related_document_id',$q->getField('id'))
				->setOrder('updated_at','desc')
				->setLimit(1);
			return $act->fieldQuery('created_at');
		});

		$complete_order->addCondition('complete_on','>',$this->api->today);
		$complete_order->addCondition('complete_on','<=',$this->api->nextDate($this->api->today));
		
		$complete_tile = $col_2->add('View_Tile')->addClass('atk-swatch-yellow');
		$complete_tile->setTitle('Today Delivered/Completed Orders');
		$complete_tile->setContent($complete_order->count()->getOne());
		if($is_superuser_login)
			$complete_tile->setFooter(money_format('%!i', $complete_order->sum('net_amount')->getOne()),'icon-money');
	
		//Rejected Orders
		$cancel_order = $this->add('xPurchase/Model_PurchaseOrder_Rejected')->addCondition('updated_date',$this->api->today);
		$cancel_tile = $col_3->add('View_Tile')->addClass('atk-swatch-ink');
		$cancel_tile->setTitle('Today Rejected Orders');
		$cancel_tile->setContent($cancel_order->count()->getOne());
		if($is_superuser_login)	
			$cancel_tile->setFooter(money_format('%!i', $cancel_order->sum('net_amount')->getOne()),'icon-money');
		
		//Today Material Request To Purchase
		$this->add('View')->setElement('br');
		$material_req = $this->add('xStore/Model_MaterialRequest')->addCondition('status',array('approved'));
		$material_req->addCondition('created_at',$this->api->today);
		$po = $this->add('xPurchase/Model_PurchaseOrder');
		$material_req->setOrder('created_at','desc');
		
		// $related_material_req = $material_req->loadWhoseRelatedDocIs($po);

		$col2 = $this->add('Columns')->addClass('atk-swatch-gray');
		$col_material_req_tile = $col2->addColumn(3);
		$col_material_req_grid = $col2->addColumn(9);
		
		$material_req_tile = $col_material_req_tile->add('View_Tile')->addClass('atk-swatch-gray');
		$material_req_tile->setTitle('Toady Material request');
		$material_req_tile->setContent($material_req->count()->getOne());
		$crud= $col_material_req_grid->add('CRUD',array('grid_class'=>'xStore/Grid_MaterialRequest'));
		$crud->grid->ipp=5;
		$crud->setModel($material_req,array('name','from_dept','created_at'));
		$crud->add('xHR/Controller_Acl',array('override'=>array('can_view'=>"All",'allow_edit'=>'No','can_forceDelete'=>'No')));
	
		
		//Today Short Items
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