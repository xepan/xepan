<?php 

class page_xShop_page_owner_termsandcondition extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Terms & Conditions';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Terms And Condition Management <small> Manage your terms and conditions </small>');


		$crud = $this->add('CRUD');
		$crud->setModel('xShop/Model_TermsAndCondition',array('name','terms_and_condition'));
        $crud->add('xHR/Controller_Acl');
	}
}