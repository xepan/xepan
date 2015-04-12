<?php

class page_xShop_page_owner_dashboard extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';

		//TODAY APPROVE ORDERS WITH AMOUNTS
		$submit_order = $this->add('xShop/Model_Order_Submitted')->addCondition('created_date',$this->api->today);
		$t_app_order = $this->add('View_Info')->setHtml('Today Approved Orderd:'.$submit_order->MyCounts(true,false)." Amount :".$submit_order->sum('net_amount'));

		//TODAY Complete ORDERS WITH AMOUNTS
		$complete_order = $this->add('xShop/Model_Order_Completed')->addCondition('created_date',$this->api->today);		
		$this->add('View_Info')->setHtml('Today Complete Orderd:'.$complete_order->MyCounts(true,false)." Amount :".$complete_order->sum('net_amount'));

		//TODAY CANCEL ORDERS WITH AMOUNTS
		$cancel_order = $this->add('xShop/Model_Order_Cancelled')->addCondition('created_date',$this->api->today);		
		$this->add('View_Info')->setHtml('Today Canceled Orderd:'.$cancel_order->MyCounts(true,false)." Amount :".$cancel_order->sum('net_amount'));


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

	}
}		