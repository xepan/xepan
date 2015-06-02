<?php
class page_xDispatch_page_owner_stockmanagement extends page_xDispatch_page_owner_main {
	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': Stock Management';

		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->api->current_department['name']. '<small> Stock Management </small>');
		$dept_id = $this->api->stickyGET('department_id');
		$warehouse = $this->api->current_department->warehouse();
		$this->add('PageHelp',array('page'=>'stockmanagement'));

		$stock = $this->add('xStore/Model_Stock')->addCondition('warehouse_id',$warehouse->id);
		$crud = $this->add('CRUD',array('allow_edit'=>false,'allow_del'=>false,'allow_add'=>false));
		$crud->setModel($stock);
		
		if(!$crud->isEditing()){
			$g = $crud->grid;
			$g->addMethod('format_custom_fields',function($g,$f){
				$g->current_row_html[$f] = $g->model->genericRedableCustomFiledAndValue();
			});
			$g->addFormatter('custom_fields','custom_fields');
		}
	}

}