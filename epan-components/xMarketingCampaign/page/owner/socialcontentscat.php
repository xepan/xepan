<?php

class page_xMarketingCampaign_page_owner_socialcontentscat extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Social Category Contents';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-bullhorn"></i> '.$this->component_name. '<small> Social Posts </small>');

		$model = $this->add('xMarketingCampaign/Model_SocialPostCategory');

		$crud=$this->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_SocialPostCategory'));

		$crud->setModel($model);


	}

}		