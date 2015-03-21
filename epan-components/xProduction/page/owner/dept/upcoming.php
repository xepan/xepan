<?php

class page_xProduction_page_owner_dept_upcoming extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		
		$departmental_status=$this->add('xShop/Model_OrderItemDepartmentalStatus');

		if($this->api->stickyGET('department_id'))
			$departmental_status->addCondition('department_id',$_GET['department_id']);
		
		// $departmental_status->addCondition('status',"Waiting");

		$crud=$this->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard','allow_add'=>false,'allow_del'=>false,'allow_edit'=>false));
		$crud->setModel($departmental_status,array('orderitem','status'));
		
		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addSno();
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}

		// $crud->add('xHR/Controller_Acl');

		//$this->add('xProduction/View_Jobcard',array('jobcard'=>$this->add('xProduction/Model_JobCard')->load(3)));
	}

}