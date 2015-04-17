<?php

class page_xShop_page_owner_dashboard extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-dashboard icon-gauge"></i> Sales Department Dashboard');


				$x = <<<EOF
		Todays Approved Order => Todays Sales
		Todays Delived/Completed ORders
		Todays ORder Canceled

		Sales Executive Performances (Distinct employee_id)
		Online Vs Offline Orders (Day Wise Graph)
		Hot Oppertunities (By Age)
		Prospected Sales
		

EOF;

		$this->add('View')->setHTML(nl2br($x));


		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		

		$col = $this->add('Columns');
		$col_1 = $col->addColumn(3)->set('11');
		$col_2 = $col->addColumn(3)->set('22');
		$col_3 = $col->addColumn(3)->set('33');
		$col_4 = $col->addColumn(3)->set('44');

		// TOTAL WORKING PROJECTS
		$running_orders = $this->add('xShop/Model_Order')->addCondition('status',array('approved','processing','processed'));
		$running_tile = $col_1->add('View_Tile')->addClass('atk-swatch-blue')->setStyle('box-shadow','');
		$running_tile->setTitle('Running Works');
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
		$approve_tile->setTitle('Today Approved Orderd');
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
		$complete_tile->setTitle('Today Complete Orders');
		$complete_tile->setContent($complete_order->count()->getOne());
		if($is_superuser_login)
			$complete_tile->setFooter(money_format('%!i', $complete_order->sum('net_amount')->getOne()),'icon-money');

		// //TODAY CANCEL ORDERS WITH AMOUNTS
		$cancel_order = $this->add('xShop/Model_Order_Cancelled')->addCondition('updated_date',$this->api->today);
		$complete_tile = $col_4->add('View_Tile')->addClass('atk-swatch-ink');
		$complete_tile->setTitle('Today Canceled Orders');
		$complete_tile->setContent($cancel_order->count()->getOne());
		if($is_superuser_login)	
			$complete_tile->setFooter(money_format('%!i', $cancel_order->sum('net_amount')->getOne()),'icon-money');

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
	
		
		// //DEPARTMENT WISE JOBCARD
		$this->add('View')->setHtml('<br>');
		$depts = $this->add('xHR/Model_Department');
		$str = "";
		foreach ($depts as $dept) {
			//CREATED JOBCRAD
			$jcs_created = $this->add('xProduction/Model_JobCard');
			$jcs_created->addCondition('created_date',$this->api->today);
			$jcs_created->addCondition('to_department_id',$dept->id);

		// 	//COMPLETED JOBCRADS
			$jcs_completed = $this->add('xProduction/Model_Jobcard_Completed');
			$jcs_completed->addCondition('updated_date',$this->api->today);
			$jcs_completed->addCondition('to_department_id',$dept->id);
			
		// 	//CHECK FOR THE JOBCARD HE TO SHOW DEPARTMENT 
			if($jcs_created->count()->getOne() and $jcs_completed->count()->getOne()){
				$str .= $dept['name']."<br>";
				$str .= "&thinsp;&ensp;&emsp;"."Jobcards Created: ".$jcs_created->count()->getOne()."<br>";
				$str .= "&thinsp;&ensp;&emsp;"."Jobcards Completed: ".$jcs_completed->count()->getOne()."<br>";
			}
		}
		if($str){
			$columns = $this->add('Columns');
			$dept_col = $columns->addColumn(12);
			$dept_jobcard_v = $dept_col->add('View_Tile')->addClasS('atk-swatch-gray');
			$dept_jobcard_v->setTitle($str);
		}
 		

		$this->add('View')->setElement('br');
		$outsource_jobcards = $this->add('xProduction/Model_JobCard')->outsource();

		$col1 = $this->add('Columns')->addClass('atk-box atk-swatch-gray');
		$col_outsource_tile = $col1->addColumn(3);
		$col_outsource_grid = $col1->addColumn(9);

		$outsource_tile_v = $col_outsource_tile->add('View_Tile')->addClass('atk-swatch-gray');
		$outsource_tile_v->setTitle('Outsource Jobcards');
		$outsource_tile_v->setContent($outsource_jobcards->count()->getOne());
	
		$crud= $col_outsource_grid->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard'));
		$crud->grid->ipp=5;
		$crud->setModel($outsource_jobcards);
		$crud->add('xHR/Controller_Acl',array('override'=>array('can_view'=>"All",'allow_edit'=>'No','can_forceDelete'=>'No')));

		// //Colors
		// //#e3c800(yellow),#004050(darkteal),#825a2c(brown),#003e00(DarkEmerald)
		// //#a4c400(lime),#6d8764(olive),#128023(drakGreen),#647687(steel),
		// //#bf5a15(dark-orange),#1b6eae(darkblue)
		
		//Running Jobcards
		$this->add('View')->setElement('br');
		$jobcards = $this->add('xProduction/Model_JobCard')
					->addCondition('outsource_party',null)
					->addCondition('status','<>',array('completed','cancelled','draft','submitted'));
		$jobcards->setOrder('created_at','desc');
		$col1 = $this->add('Columns')->addClass('atk-box atk-swatch-gray');
		$col_jobcard_tile = $col1->addColumn(3);
		$col_jobcard_grid = $col1->addColumn(9);

		$jobcrad_tile_v = $col_jobcard_tile->add('View_Tile')->addClass('atk-swatch-gray');
		$jobcrad_tile_v->setTitle('Running Jobcards');
		$jobcrad_tile_v->setContent($jobcards->count()->getOne());
	
		$crud= $col_jobcard_grid->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard'));
		$crud->grid->ipp=5;
		$crud->setModel($jobcards);
		$crud->add('xHR/Controller_Acl',array('override'=>array('can_view'=>"All",'allow_edit'=>'No','can_forceDelete'=>'No')));
	}
}		