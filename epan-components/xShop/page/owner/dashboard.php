<?php

class page_xShop_page_owner_dashboard extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';

		//Basic HTML Structurer
		$cols = $this->add('Columns');
		$col1 = $cols->addColumn(3);

		$html = '<div class="tile bg-cyan" style="background-color:{bgcolor};width:100%;height:150px;position:relative;">
                        <div class="brand">
                        	<h2 style="color:white;" class="text-center">{heading}</h2>
                            <div style="display:block;background-color:{bgcolor};position:absolute;" class="badge">
                            	<i class="icon-box">
                            	</i>
                            </div>
                            <div style="bottom:0;right:0;display:block;position:relative;background-color:{bgcolor};position:absolute;" class="badge">
                            	<i class="icon-money">
                            		2000
                            	</i>
                            </div>
                        </div>
                    </div>';


		// TOTAL WORKING PROJECTS
		$running_orders = $this->add('xShop/Model_Order')->addCondition('status',array('approved','processing','processed'));
		$t_app_order = $this->add('View_Info')->setHtml('Running Works:'.$running_orders->count()->getOne() ." Amount :".$running_orders->sum('net_amount'));
        $col1_html = str_replace('{bgcolor}', '#1ba1e2', $html);
		$col1->add('View')->setHtml($col1_html);
		
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
		$cols = $this->add('Columns');
		$col1 = $cols->addColumn(3);

		$approved_order->addCondition('approved_on','>',$this->api->today);
		$approved_order->addCondition('approved_on','<=',$this->api->nextDate($this->api->today));

		$t_app_order = $this->add('View_Info')->setHtml('Today Approved Orderd:'.$approved_order->count()->getOne() ." Amount :".$approved_order->sum('net_amount'));

		//TODAY Complete ORDERS WITH AMOUNTS
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

		$this->add('View_Info')->setHtml('Today Complete Orders:'.$complete_order->count()->getOne()." Amount :".$complete_order->sum('net_amount'));

		//TODAY CANCEL ORDERS WITH AMOUNTS
		$cancel_order = $this->add('xShop/Model_Order_Cancelled')->addCondition('updated_date',$this->api->today);		
		$this->add('View_Info')->setHtml('Today Canceled Orders:'.$cancel_order->MyCounts(true,false)." Amount :".$cancel_order->sum('net_amount'));


		//DEPARTMENT WISE JOBCARD
		$dept_jobcard_v = $this->Add('View_Info');
		$depts = $this->add('xHR/Model_Department');
		$str = "";
		foreach ($depts as $dept) {
			//CREATED JOBCRAD
			$jcs_created = $this->add('xProduction/Model_JobCard');
			$jcs_created->addCondition('created_date',$this->api->today);
			$jcs_created->addCondition('to_department_id',$dept->id);

			//COMPLETED JOBCRADS
			$jcs_completed = $this->add('xProduction/Model_Jobcard_Completed');
			$jcs_completed->addCondition('updated_date',$this->api->today);
			$jcs_completed->addCondition('to_department_id',$dept->id);
			
			//CHECK FOR THE JOBCARD HE TO SHOW DEPARTMENT 
			if($jcs_created->count()->getOne() and $jcs_completed->count()->getOne()){
				$str .= $dept['name']."<br>";
				$str .= "&thinsp;&ensp;&emsp;"."Jobcards Created: ".$jcs_created->count()->getOne()."<br>";
				$str .= "&thinsp;&ensp;&emsp;"."Jobcards Completed: ".$jcs_completed->count()->getOne()."<br>";
			}
		}

		$dept_jobcard_v->setHtml($str);

		$commited_order = $this->add('xShop/Model_Order')->addCondition('status',array('approved','processing','processed'));
		$commited_order->addCondition('delivery_date','>=',$this->api->today);
		$commited_order->addCondition('delivery_date','<=',$this->api->nextDate($this->api->nextDate($this->api->today)));
		$commited_order->setOrder('delivery_date','desc');

		$t_app_order = $this->add('View_Info')->setHtml('Commitments (Today+Tomorrow):'.$commited_order->count()->getOne() ." Amount :".$commited_order->sum('net_amount'));
		$crud= $this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->grid->ipp=5;
		$crud->setModel($commited_order);
		$crud->add('xHR/Controller_Acl',array('override'=>array('can_view'=>"All",'allow_edit'=>'No','can_forceDelete'=>'No')));

		$commited_order = $this->add('xShop/Model_Order')->addCondition('status',array('approved','processing','processed'));
		$commited_order->addCondition('delivery_date','<',$this->api->today);
		$commited_order->setOrder('delivery_date','desc');

		$t_app_order = $this->add('View_Info')->setHtml('Over Due Orders:'.$commited_order->count()->getOne() ." Amount :".$commited_order->sum('net_amount'));
		$crud= $this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->grid->ipp=5;
		$crud->setModel($commited_order);
		$crud->add('xHR/Controller_Acl',array('override'=>array('can_view'=>"All",'allow_edit'=>'No','can_forceDelete'=>'No')));
	
		
        $col2_html = str_replace('{bgcolor}', '#fa6800', $html);
		$col2 = $cols->addColumn(3);
		$col2->add('View')->setHtml($col2_html);
		
        $col3_html = str_replace('{bgcolor}', '#bf5a15', $html);
		$col3 = $cols->addColumn(3);
		$col3->add('View')->setHtml($col3_html);
		
        $col4_html = str_replace('{bgcolor}', '#9a1616', $html);
		$col4 = $cols->addColumn(3);
		$col4->add('View')->setHtml($col4_html);

		//Colors
		//#e3c800(yellow),#004050(darkteal),#825a2c(brown),#003e00(DarkEmerald)
		//#a4c400(lime),#6d8764(olive),#128023(drakGreen),#647687(steel),
		//#bf5a15(dark-orange),#1b6eae(darkblue)

		$html1='<div style="position:relative;">
				<div style="color:{color};background-color:{bgcolor};height:{height};" class="text-center">
                    <h1 style="font-size: 100px; line-height: 80px; margin-bottom: 30px;color:{color}">{count}</h1>
                    <p>Today Promised Order</p>
                </div>
                <span style="position:absolute;right:0;top:0;" class="caret"></span>
                </div>';

        $this->add('View')->setHtml('<br>');

        $cols2 = $this->add('Columns')->addClass('well');
        $grid_col4 = $cols2->addColumn(4);
        $grid_col8 = $cols2->addColumn(8);
        $g1_html = str_replace('{bgcolor}', '#6d8764', $html1);
        $g1_html = str_replace('{height}', '325px', $g1_html);
        $g1_html = str_replace('{count}', '99', $g1_html);
        $g1_html = str_replace('{color}', 'white', $g1_html);
        $grid_col4->add('View')->setHtml($g1_html)->addStyle('height','400px');
        
        $m = $this->add('xShop/Model_Order')->setLimit(5);
        $grid_col8->add('xShop/Grid_Order')->setModel($m);
	}
}		