<?php


class page_xMarketingCampaign_page_owner_mrkt_dtgrb_dtgrb extends page_xMarketingCampaign_page_owner_main {

	function page_index(){
		$this->app->title=$this->api->current_department['name'] .': Data Grabbeer';
		$bg=$this->app->layout->add('View_BadgeGroup');
		$data =$this->add('xMarketingCampaign/Model_DataSearchPhrase')->count()->getOne();
		$v=$bg->add('View_Badge')->set('Total Phrases')->setCount($data)->setCountSwatch('ink');

		$data =$this->add('xMarketingCampaign/Model_DataSearchPhrase')->addCondition('is_grabbed',false)->count()->getOne();
		$v=$bg->add('View_Badge')->set('Un Grabbed Phrases')->setCount($data)->setCountSwatch('red');
				
		$crud = $this->app->layout->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_DataGrabber'));
		$m = $this->add('xMarketingCampaign/Model_DataGrabber');
		$m->addExpression('total_phrases')->set(function($m,$q){
			return $m->refSQL('xMarketingCampaign/DataSearchPhrase')->count();
		});

		$m->addExpression('ungrabbed_phrases')->set(function($m,$q){
			return $m->refSQL('xMarketingCampaign/DataSearchPhrase')->addCondition('is_grabbed',false)->count();
		});

		$crud->setModel($m,null);

		if(!$crud->isEditing()){
			$g = $crud->grid;
			$crud->add_button->setIcon('ui-icon-plusthick');
			$g->addColumn('expander','phrases');
		}
		$crud->grid->addQuickSearch(array('name','is_active','site_url','created_at','last_run_at'));
		$crud->grid->addPaginator($ipp=50);
		// $crud->add('Controller_FormBeautifier');

	}

	function page_phrases(){
		$this->api->stickyGET('xmarketingcampaign_data_grabber_id');

		$data_grabber_model = $this->add('xMarketingCampaign/Model_DataGrabber');
		$data_grabber_model->load($_GET['xmarketingcampaign_data_grabber_id']);

		$crud = $this->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_Phrases'));

		$phrases = $data_grabber_model->ref('xMarketingCampaign/DataSearchPhrase');
		$phrases->addExpression('emails_count')->set(function($m,$q){
			$subs = $m->add('xEnquiryNSubscription/Model_Subscription',array('table_alias'=>'emc'));
			$subs->addCondition('from_app','DataGrabberPhrase');
			$subs->addCondition('from_id',$q->getField('id'));

			return $subs->count();
		});

		$phrases->setOrder('id','desc');

		$crud->setModel($phrases ,null);

		if(!$crud->isEditing()){
			$crud->add_button->setIcon('ui-icon-plusthick');
		}

		// $crud->add('Controller_FormBeautifier');

	}
}