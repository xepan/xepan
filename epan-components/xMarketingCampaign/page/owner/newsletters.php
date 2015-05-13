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
		$newsletter_crud = $this->add('CRUD',array('grid_class'=>'xEnquiryNSubscription/Grid_NewsLetter'));
		$newsletter_crud->setModel($newsletter_model,null,array('category','is_active','name','email_subject','unsend_emails','created_by_app'));

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

		
	}

	function page_send(){
		$this->api->stickyGET('xenquirynsubscription_newsletter_id');

		$v= $this->add('View');
		$v->addClass('panel panel-default');
		$v->addStyle('padding','20px');

		// $tabs = $v->add('Tabs');
		// $mass_email_tab = $tabs->addTab('Mass Emails');
		// $mass_email_tab->add('View_Error')->set("This will add Emails to Queue to be processed by xMarketingCampain Application");

		// $form = $mass_email_tab->add('Form');
		
		// $mass_email_tab->add('H4')->set('Existing Queue');

		// $crud= $mass_email_tab->add('CRUD',array('allow_edit'=>false));
		// $crud->addClass('panel panel-default');
		// $crud->addStyle('margin-top','10px');

		// $subscription_field = $form->addField('DropDown','subscriptions');
		// $subscription_field->setModel('xEnquiryNSubscription/SubscriptionCategories');
		// $subscription_field->setEmptyText('Please select a category')->validateNotNull();
		// $form->addField('CheckBox','include_unsubscribed_members_too');
		// $form->addSubmit('Add To job');

		// $form->add('Controller_FormBeautifier');
		
		// if($form->isSubmitted()){
		// 	$subscribers = $this->add('xEnquiryNSubscription/Model_Subscription');
		// 	$asso_j = $subscribers->join('xenquirynsubscription_subscatass.subscriber_id');
		// 	$asso_j->addField('category_id');
		// 	$asso_j->addField('send_news_letters');

		// 	$subscribers->addCondition('category_id',$form['subscriptions']);
		// 	if(!$form['include_unsubscribed_members_too'])
		// 		$subscribers->addCondition('send_news_letters',true);
			
		// 	$new_job = $this->add('xEnquiryNSubscription/Model_EmailJobs');
		// 	$new_job['newsletter_id'] = $_GET['xenquirynsubscription_newsletter_id'];
		// 	$new_job['process_via']='xEnquiryNSubscription';
		// 	$new_job->save();

		// 	$q= $this->add('xEnquiryNSubscription/Model_EmailQueue');
		// 	foreach ($subscribers as $junk) {
		// 		$q['emailjobs_id'] = $new_job->id;
		// 		$q['subscriber_id'] = $subscribers->id;
		// 		$q->saveAndUnload();
		// 	}
		// 	if(!$crud->isEditing()) {
		// 		$crud->grid->js(null,$this->js()->_selector('.processing_btn')->trigger('reload'))->reload()->execute();
		// 	}
		// }


		// if(!$crud->isEditing()){
		// 	// $form=$crud->grid->add('Form',null,'grid_buttons',array('form_horizontal'));
		// 	// $form->addField('DropDown','top_1');
		// 	$crud->add_button->setIcon('ui-icon-plusthick');
		// 	$crud->grid->addPaginator(50);
		// 	$crud->grid->addQuickSearch(array('subscriber','email'));
		// }

		// ================ SINGLE EMAIL

		// $single_email_tab = $this->addTab('Send To Single');
		$existing_jobs = $this->add('xEnquiryNSubscription/Model_EmailQueue');
		$job_j = $existing_jobs->join('xenquirynsubscription_emailjobs','emailjobs_id');
		$job_j->addField('newsletter_id');
		$existing_jobs->addCondition('newsletter_id',$_GET['xenquirynsubscription_newsletter_id']);
		$existing_jobs->setOrder('id','desc');

		$subscriber_join = $existing_jobs->leftJoin('xenquirynsubscription_subscription','subscriber_id');
		// $subscriber_join->addField('subscriber','name');

		$subscriber_asso = $subscriber_join->leftJoin('xenquirynsubscription_subscatass.subscriber_id');
		$category_join = $subscriber_asso->leftJoin('xenquirynsubscription_subscription_categories','category_id');
		$category_join->addField('under_category','name')->sortable(true);
		
		$this->add('H3')->set('NewsLetters Queue');
		$crud = $this->add('CRUD',array('allow_add'=>false,'allow_edit'=>false));
		$crud->setModel($existing_jobs,array('subscriber','email','sent_at','is_sent','under_category'));

		if(!$crud->isEditing()){
			$crud->grid->addPaginator(50);
			$crud->grid->addQuickSearch(array('subscriber','email'));
		}

		$single_form = $v->add('Form');

		$crud->setModel($existing_jobs,array('subscriber','email','sent_at','is_sent','under_category'));
		

		$single_form->addField('line','email_id')->validateNotNull();
		$single_form->addField('CheckBox','also_add_to_category');
		$single_form->addField('DropDown','add_to_category')->setModel('xEnquiryNSubscription/SubscriptionCategories');
		$single_form->addSubmit('Send');

		if($single_form->isSubmitted()){
			
			if($single_form['also_add_to_category']){
				if(!$single_form['add_to_category'])
					$single_form->displayError('add_to_category','Select Category');

				$subs = $this->add('xEnquiryNSubscription/Model_Subscription');
				$subs->addCondition('email',$single_form['email_id']);
				$subs->tryLoadAny();

				if(!$subs->loaded()){
					// $subs['category_id'] = $single_form['add_to_category'];
					$subs['email'] = $single_form['email_id'];
					$subs->save();
				}

				$cat = $this->add('xEnquiryNSubscription/Model_SubscriptionCategories');
				$cat->load($single_form['add_to_category']);
				try{
					$cat->addSubscriber($subs);
				}catch(\Exception $e){
					// Might be already associated
				}

			}

			$new_job = $this->add('xEnquiryNSubscription/Model_EmailJobs');
			$new_job['process_via'] = 'xMarketingCampaign';
			$new_job['newsletter_id'] = $_GET['xenquirynsubscription_newsletter_id'];
			$new_job->save();

			$q= $this->add('xEnquiryNSubscription/Model_EmailQueue');
			$q['emailjobs_id'] = $new_job->id;
			$q['email'] = $single_form['email_id'];
			$q->save();
			if($q->processSingle())
				$single_form->js(null,$single_form->js()->univ()->successMessage('Done'))->reload()->execute();
			else
				$single_form->js(null,$single_form->js()->univ()->errorMessage('Error'))->reload()->execute();
		}

	}

}