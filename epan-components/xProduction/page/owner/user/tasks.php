<?php

class page_xProduction_page_owner_user_tasks extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();

		$tabs=$this->app->layout->add('Tabs');
		$tab->addTabURL('xProduction/page/owner/task_assigned','Assigned to me'.$this->add('xProduction/Model_Task_Assigned')->myUnRead());
		$tab->addTabURL('xProduction/page/owner/task_processing','Processing'.$this->add('xProduction/Model_Task_Processing')->myUnRead());
		$tab->addTabURL('xProduction/page/owner/task_processed','Processed '.$this->add('xProduction/Model_Task_Processed')->myUnRead());
		$tab->addTabURL('xProduction/page/owner/task_completed','Completed By Me '.$this->add('xProduction/Model_Task_Completed')->myUnRead());
		$tab->addTabURL('xProduction/page/owner/task_cancelled','Redesign '.$this->add('xProduction/Model_Task_Redesign')->myUnRead());

		
	}
}