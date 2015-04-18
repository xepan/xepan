<?php
class page_xHR_page_owner_xmail extends page_xHR_page_owner_main{
	function init(){
		parent::init();


		$id= $this->api->stickyGET('department_id');

		$model = $this->add('xHR/Model_OfficialEmail');
		$model->addCondition('department_id',$id);
		$this->add('View_Success')->set($id);

		$crud=$this->add('Grid');
		$crud->setModel($model,array('email_username'));
	}
}