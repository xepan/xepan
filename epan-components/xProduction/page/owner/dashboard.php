<?php

class page_xProduction_page_owner_dashboard extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': Dashboard';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-dashboard icon-gauge"></i> Production Department Dashboard');

		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		
		$col = $this->add('Columns');
		$col_1 = $col->addColumn(3);
		$col_2 = $col->addColumn(3);
		$col_3 = $col->addColumn(3);
		$col_4 = $col->addColumn(3);

		//Commitments Orders
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

		// TOTAL WORKING PROJECTS
		$running_orders = $this->add('xShop/Model_Order')->addCondition('status',array('approved','processing','processed'));
		$running_tile = $col_1->add('View_Tile')->addClass('atk-swatch-blue');
		$running_tile->setTitle('Today Running Orders');
		$running_tile->setContent($running_orders->count()->getOne());
		if($is_superuser_login)
			$running_tile->setFooter(money_format('%!i', $running_orders->sum('net_amount')->getOne()),'icon-money');

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
		

		//OutSource Jobcards 
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


		//DEPARTMENT WISE JOBCARD
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

	}
}