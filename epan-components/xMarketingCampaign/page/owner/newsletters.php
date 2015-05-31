<?php

class page_xMarketingCampaign_page_owner_newsletters extends page_xMarketingCampaign_page_owner_main{

	function page_index(){
		$this->app->title=$this->api->current_department['name'] .': NewsLetters';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-bullhorn"></i> '.$this->component_name. '<small> NewsLetters </small>');

		$config_model=$this->add('xEnquiryNSubscription/Model_Config')->tryLoadAny();

		$bg=$this->add('View_BadgeGroup');
		$data=$this->add('xEnquiryNSubscription/Model_NewsLetter')->count()->getOne();
		$v=$bg->add('View_Badge')->set('Total NewsLetters')->setCount($data)->setCountSwatch('ink');

		$data=$this->add('xEnquiryNSubscription/Model_NewsLetter')->addCondition('created_by_app','xMarketingCampaign')->count()->getOne();
		$v=$bg->add('View_Badge')->set('By This App')->setCount($data)->setCountSwatch('ink');

		$newsletter_model = $this->add('xEnquiryNSubscription/Model_NewsLetter');
		$newsletter_model->addExpression('unsend_emails')->set(function($m,$q){
			$mq= $m->add('xEnquiryNSubscription/Model_EmailQueue');
			$mq->join('xenquirynsubscription_emailjobs','emailjobs_id')->addField('newsletter_id');
			return $mq->addCondition('newsletter_id',$q->getField('id'))->addCondition('is_sent',false)->count();
		})->sortable(true);

		$newsletter_model->getElement('created_by_app')->defaultValue('xMarketingCampaign');
		$newsletter_crud = $this->add('CRUD',array('grid_class'=>'xEnquiryNSubscription/Grid_NewsLetter','keep_open_on_submit'=>true));
		$newsletter_crud->setModel($newsletter_model,null,array('category','is_active','name','email_subject','unsend_emails','created_by_app'));

		if($newsletter_crud->isEditing('add') or $newsletter_crud->isEditing('edit')){
			$mf = $newsletter_crud->form->getElement('matter');
			$mf->options=array('templates'=> 'index.php?page=xMarketingCampaign_page_owner_newsletterstemplates&getjson=true'
			);
		}

		if(!$newsletter_crud->isEditing()){
		
			$newsletter_crud->add_button->setIcon('ui-icon-plusthick');
			
			$email_to_process = $this->add('xEnquiryNSubscription/Model_EmailQueue');
			$email_to_process->addCondition('is_sent',false);
			$email_to_process->setOrder('id','asc');
			$email_to_process->setOrder('emailjobs_id','asc');

			$job_j = $email_to_process->join('xenquirynsubscription_emailjobs','emailjobs_id');
			$job_j->addField('process_via');
			$email_to_process->addCondition('process_via','xMarketingCampaign');
		}

		$newsletter_crud->add('xHR/Controller_Acl');
	}

	function page_send(){
		$this->api->stickyGET('xenquirynsubscription_newsletter_id');

		$tabs = $this->add('Tabs');
		$tabs->addTabURL('../sendtosingle','Send To Single');
		$tabs->addTabURL('../massemail','Mass Email');
	}

}