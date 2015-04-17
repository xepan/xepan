<?php

class page_xShop_page_owner_dashboard extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-dashboard icon-gauge"></i> Sales Department Dashboard');
// TTODDOOOO
// 		$x = <<<EOF
// 		Sales Executive Performances (Distinct employee_id)
// 		Online Vs Offline Orders (Day Wise Graph)
// 		Prospected Sales
// EOF;

		// $this->add('View')->setHTML(nl2br($x));


		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		

		$col = $this->add('Columns');
		$col_1 = $col->addColumn(3);
		$col_2 = $col->addColumn(3);
		$col_3 = $col->addColumn(3);
		$col_4 = $col->addColumn(3);

		// TOTAL WORKING PROJECTS
		$running_orders = $this->add('xShop/Model_Order')->addCondition('status',array('approved','processing','processed'))->addCondition('order_from','online');
		$running_tile = $col_4->add('View_Tile')->addClass('atk-swatch-blue')->setStyle('box-shadow','');
		$running_tile->setTitle('Today Online Orders');
		$running_tile->setContent($running_orders->count()->getOne());

		if($is_superuser_login)
			$running_tile->setFooter(money_format('%!i', $running_orders->sum('net_amount')->getOne()),'icon-money');
		
		//TODAY APPROVE ORDERS WITH AMOUNTS
		$approved_order = $this->add('xShop/Model_Order');
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

		$approve_tile = $col_2->add('View_Tile')->addClass('atk-swatch-green');
		$approve_tile->setTitle('Today Sales');
		$approve_tile->setContent($approved_order->count()->getOne());
		if($is_superuser_login)
			$approve_tile->setFooter(money_format('%!i', $approved_order->sum('net_amount')->getOne()),'icon-money');

		// //TODAY Complete ORDERS WITH AMOUNTS
		$complete_order = $this->add('xShop/Model_Order');
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
		
		$complete_tile = $col_3->add('View_Tile')->addClass('atk-swatch-yellow');
		$complete_tile->setTitle('Today Delivered/Completed Orders');
		$complete_tile->setContent($complete_order->count()->getOne());
		if($is_superuser_login)
			$complete_tile->setFooter(money_format('%!i', $complete_order->sum('net_amount')->getOne()),'icon-money');

		// //TODAY CANCEL ORDERS WITH AMOUNTS
		$cancel_order = $this->add('xShop/Model_Order_Cancelled')->addCondition('updated_date',$this->api->today);
		$complete_tile = $col_1->add('View_Tile')->addClass('atk-swatch-ink');
		$complete_tile->setTitle('Today Canceled Orders');
		$complete_tile->setContent($cancel_order->count()->getOne());
		if($is_superuser_login)	
			$complete_tile->setFooter(money_format('%!i', $cancel_order->sum('net_amount')->getOne()),'icon-money');


		//Commitment Orders
		$commited_order = $this->add('xShop/Model_Order')->addCondition('status',array('approved','processing','processed'));
		$commited_order->addCondition('delivery_date','>=',$this->api->today);
		$commited_order->addCondition('delivery_date','<=',$this->api->nextDate($this->api->nextDate($this->api->today)));
		$commited_order->setOrder('delivery_date','desc');

		$this->add('View')->setElement('br');
		$col1 = $this->add('Columns')->addClass('atk-box atk-swatch-gray');
		$col_comit_tile = $col1->addColumn(3);
		$col_comit_grid = $col1->addColumn(9);
		$completed_tile = $col_comit_tile->add('View_Tile')->addClass('atk-swatch-red')->setStyle('height','220px');
		$completed_tile->setTitle('Commitments (Today+Tomorrow)');
		$completed_tile->setContent($commited_order->count()->getOne());
		if($is_superuser_login)
			$completed_tile->setFooter(money_format('%!i', $commited_order->sum('net_amount')->getOne()),'icon-money');

		$crud= $col_comit_grid->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->grid->ipp=5;
		$crud->setModel($commited_order,array('name','order_id','customer','created_at','net_amount','delivery_date','orderitem_count','member'));
		$crud->add('xHR/Controller_Acl',array('override'=>array('can_view'=>"All",'allow_edit'=>'No','can_forceDelete'=>'No')));

		$commited_order = $this->add('xShop/Model_Order')->addCondition('status',array('approved','processing','processed'));
		$commited_order->addCondition('delivery_date','<',$this->api->today);
		$commited_order->setOrder('delivery_date','desc');
		
		$this->add('View')->setHTML('<br>');

		//OverDues Order
		$col2 = $this->add('Columns')->addClass('atk-swatch-gray');
		$col_overdue_tile = $col2->addColumn(3);
		$col_overdue_grid = $col2->addColumn(9);
		
		$overdue_tile = $col_overdue_tile->add('View_Tile')->addClass('atk-swatch-gray');
		$overdue_tile->setTitle('Over Due Orders');
		$overdue_tile->setContent($commited_order->count()->getOne());
		if($is_superuser_login)
			$overdue_tile->setFooter(money_format('%!i', $commited_order->sum('net_amount')->getOne()),'icon-money');

		$crud= $col_overdue_grid->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->grid->ipp=5;
		$crud->setModel($commited_order,array('name','order_id','customer','created_at','net_amount','delivery_date','orderitem_count','member'));
		$crud->add('xHR/Controller_Acl',array('override'=>array('can_view'=>"All",'allow_edit'=>'No','can_forceDelete'=>'No')));
		
		//Hot Opportunities
		$this->add('View')->setHTML('<br>');
		$col3 = $this->add('Columns')->addClass('atk-swatch-gray');
		$col_hot_tile = $col3->addColumn(3);
		$col_hot_grid = $col3->addColumn(9);
		$hot_opportunities = $this->add('xShop/Model_Opportunity')->addCondition('status','active')->setOrder('created_at','desc');

		$hot_tile = $col_hot_tile->add('View_Tile')->addClass('atk-swatch-gray');
		$hot_tile->setTitle('Hot Opportunities');
		$hot_tile->setContent($hot_opportunities->count()->getOne());
		// if($is_superuser_login)
		// 	$overdue_tile->setFooter(money_format('%!i', $hot_opportunities->sum('net_amount')->getOne()),'icon-money');

		$opp_crud= $col_hot_grid->add('CRUD');
		$opp_crud->setModel($hot_opportunities,array('name','created_date','lead','customer'));
		if(!$opp_crud->isEditing()){
			$grid =  $opp_crud->grid;
			$grid->addMethod('format_from',function($g,$f){
				$g->current_row[$f] = $g->current_row['lead']? '(L) ' . $g->current_row['lead'] :  '(C) ' . $g->current_row['customer'];
			});

			$grid->addColumn('from','from');
			$grid->removeColumn('lead');
			$grid->removeColumn('customer');
		}
		
		$opp_crud->grid->addPaginator($ipp=5);
		$opp_crud->add('xHR/Controller_Acl',array('override'=>array('can_view'=>"All",'allow_edit'=>'No','can_forceDelete'=>'No')));
		// //Colors
		// //#e3c800(yellow),#004050(darkteal),#825a2c(brown),#003e00(DarkEmerald)
		// //#a4c400(lime),#6d8764(olive),#128023(drakGreen),#647687(steel),
		// //#bf5a15(dark-orange),#1b6eae(darkblue)
				
	}
}		