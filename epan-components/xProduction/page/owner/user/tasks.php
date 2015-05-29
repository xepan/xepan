<?php

class page_xProduction_page_owner_user_tasks extends page_xProduction_page_owner_main{

	function init(){
		parent::init();

		$this->app->title = 'xEpan: Tasks';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Tasks Management <small> Manage your outsource parties </small>');

		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xProduction/page/owner/task_draft','TODO/Notes '.$this->add('xProduction/Model_Task_Draft')->myCounts());
		$tabs->addTabURL('xProduction/page/owner/task_assigned','Assigned By me '.$this->add('xProduction/Model_Task_Assigned')->myCounts());
		$tabs->addTabURL('xProduction/page/owner/task_processing','Processing '.$this->add('xProduction/Model_Task_Processing')->myCounts());
		$tabs->addTabURL('xProduction/page/owner/task_processed','Processed '.$this->add('xProduction/Model_Task_Processed')->myCounts());
		$tabs->addTabURL('xProduction/page/owner/task_completed','Completed'.$this->add('xProduction/Model_Task_Completed')->myCounts(true,false));
		$tabs->addTabURL('xProduction/page/owner/task_cancelled','Cancelled '.$this->add('xProduction/Model_Task_Cancelled')->myCounts(true,false));
		$tabs->addTabURL('xProduction/page/owner/task_rejected','Rejected '.$this->add('xProduction/Model_Task_Rejected')->myCounts(true,false));

		$this->js(true)->_selector('span')->xtooltip();
		
	}
}