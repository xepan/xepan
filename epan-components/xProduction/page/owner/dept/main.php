<?php

class page_xProduction_page_owner_dept_main extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		$this->api->stickyGET('department_id');

		$this->app->title=$this->api->current_department['name'] .': JobCards';

		$dept = $this->add('xHR/Model_Department')->load($_GET['department_id']?:$this->api->current_employee->department()->get('id'));

		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '. $dept['name']. '<small> Job Cards :: Manager View</small>');

		$tabs=$this->add('Tabs');

		$document = $this->add($dept->defaultDocument());

		$counts = $this->add('xProduction/Model_JobCard');
		$counts->addCondition('to_department_id',$this->api->current_department->id);
		$counts->_dsql()->del('fields')->field('count(*) cnt')->field('status')->group('status');

		$counts = $counts->_dsql()->get();
		$counts_array=array();
		foreach ($counts as $cnt) {
			$counts_array[$cnt['status']] = $cnt['cnt'];
		}

		// $tabs->addTabURL('xProduction_page_owner_dept_upcoming','UpComings');

		// foreach ($document->status as $st) {
		// 	if($st=='approved'){
		// 		$tabs->addTabURL('xProduction_page_owner_dept_'.$st,'Approved / To Receive '. $this->add('xProduction/Model_Jobcard_'.ucwords($st))->myUnRead() );
		// 	}else{
		// 		$tabs->addTabURL('xProduction_page_owner_dept_'.$st,ucwords($st).$this->add('xProduction/Model_Jobcard_'.ucwords($st))->myUnRead());
		// 	}
		// }
		$tab = $this->add('Tabs');
			// $tab->addTabURL('xProduction_page_owner_dept_upcoming','UpComings'.$this->add('xShop/Model_OrderItemDepartmentalStatus')->addCondition('department_id',$_GET['department_id']));
			// $tab->addTabURL('xProduction/page/owner/dept_draft','Draft '.$this->add('xProduction/Model_Jobcard_Draft')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
			// $tab->addTabURL('xProduction/page/owner/dept_submitted','Submitted '.$this->add('xProduction/Model_Jobcard_Submitted')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
			$tab->addTabURL('xProduction/page/owner/dept_approved','Approved / To Receive '.$this->add('xProduction/Model_Jobcard_Approved')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
			$tab->addTabURL('xProduction/page/owner/dept_received','Received '.$this->add('xProduction/Model_Jobcard_Received')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
			// $tab->addTabURL('xProduction/page/owner/dept_assigned','Assigned '.$this->add('xProduction/Model_Jobcard_Assigned')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
			$tab->addTabURL('xProduction/page/owner/dept_processing','Processing '.$this->add('xProduction/Model_Jobcard_Processing')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
			$tab->addTabURL('xProduction/page/owner/dept_processed','Processed '.$this->add('xProduction/Model_Jobcard_Processed')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
			$tab->addTabURL('xProduction/page/owner/dept_forwarded','Forwarded '.$this->add('xProduction/Model_Jobcard_Forwarded')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
			$tab->addTabURL('xProduction/page/owner/dept_completed','Complete '.$this->add('xProduction/Model_Jobcard_Completed')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
			$tab->addTabURL('xProduction/page/owner/dept_cancelled','Cancel'.$this->add('xProduction/Model_Jobcard_Cancelled')->addCondition('to_department_id',$this->api->current_department->id)->myCounts(true,false));
	}
}