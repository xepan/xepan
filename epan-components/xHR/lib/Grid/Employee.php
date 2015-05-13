<?php

namespace xHR;
class Grid_Employee extends \Grid{
	function init(){
		parent::init();

		$this->add('VirtualPage')->addColumn('Details','Details',array('icon'=>'users'),$this)->set(function($p){

				$selected_emp = $p->add('xHR/Model_Employee')->load($p->id);

				$tab = $p->add('Tabs');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_basic',array('employee_id'=>$p->id)),'Basic');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_qualification',array('employee_id'=>$p->id)),'Qualification');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_media',array('employee_id'=>$p->id)),'Media');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_workexperience',array('employee_id'=>$p->id)),'Work Experience');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_department',array('employee_id'=>$p->id)),'Department');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_account',array('employee_id'=>$p->id)),'User Account');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_employeeemail',array('employee_id'=>$p->id)),'Employee Email');

		});
	}

	function setModel($model,$fields=null){
		$m= parent::setModel($model,$fields);
		$this->addQuickSearch(array('name','mobile_no','personal_email'),null,'xHR/Filter_Employee');
		

		return $m;
	}


	function formatRow(){
		// $this->current_row_html['name']=$this->model['post']."klfgkhj ". $this->model['department_id'];
		parent::formatRow();
	}

	function recursiveRender(){
		parent::recursiveRender();
	}

}