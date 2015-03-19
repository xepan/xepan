<?php

class page_xProduction_page_owner_user_tasks extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();

		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xProduction/page/owner/task_assigned','Assigned to me'.$this->add('xProduction/Model_Task_Assigned')->myUnRead());
		$tabs->addTabURL('xProduction/page/owner/task_processing','Processing'.$this->add('xProduction/Model_Task_Processing')->myUnRead());
		$tabs->addTabURL('xProduction/page/owner/task_processed','Processed '.$this->add('xProduction/Model_Task_Processed')->myUnRead());
		$tabs->addTabURL('xProduction/page/owner/task_completed','Completed By Me '.$this->add('xProduction/Model_Task_Completed')->myUnRead());
		$tabs->addTabURL('xProduction/page/owner/task_cancelled','Cancelled '.$this->add('xProduction/Model_Task_Cancelled')->myUnRead());

		
	}
}