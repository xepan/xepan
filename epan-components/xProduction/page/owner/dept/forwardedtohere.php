<?php

class page_xProduction_page_owner_dept_forwardedtohere extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();

		//echo "all Order item depatment association jisme (department id self ki ho aur status - ho ) ya (pichla department agar hai to uska status forwarded ho) ";
		$this->api->stickyGET('department_id');
		
		$forwarded_to_me=$this->add('xProduction/Model_Jobcard_ToReceive');
		$forwarded_to_me->addCondition('department_id',$_GET['department_id']?:$this->api->current_employee->department()->get('id'));
		
		$crud=$this->add('CRUD',array('allow_add'=>false,'allow_del'=>false,'allow_edit'=>false));
		$crud->setModel($forwarded_to_me);
		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}
				
		$crud->add('xHR/Controller_Acl');

	}
}