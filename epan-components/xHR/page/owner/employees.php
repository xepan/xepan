<?php
class page_xHR_page_owner_employees extends page_xProduction_page_owner_main{
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Employee';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Employee Management <small> Manage companies employees </small>');

		$emp_model=$this->add('xHR/Model_Employee');
		$emp_crud = $this->add('CRUD',array('grid_class'=>'xHR/Grid_Employee'));
		$emp_crud->setModel($emp_model);
		
	}
}