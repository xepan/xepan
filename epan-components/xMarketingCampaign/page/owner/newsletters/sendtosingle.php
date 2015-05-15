<?php

class page_xMarketingCampaign_page_owner_newsletters_sendtosingle extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();

		$this->api->stickyGET('xenquirynsubscription_newsletter_id');
		
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
		
		$single_form = $this->add('Form');
		$single_form->addField('line','email_id')->validateNotNull();
		$single_form->addField('CheckBox','also_add_to_category');
		$single_form->addField('DropDown','add_to_category')->setModel('xEnquiryNSubscription/SubscriptionCategories');
		$single_form->addSubmit('Send');


		$this->add('H3')->set('NewsLetters Queue');
		$crud = $this->add('CRUD',array('allow_add'=>false,'allow_edit'=>false));
		$crud->setModel($existing_jobs,array('subscriber','email','sent_at','is_sent','under_category'));

		if(!$crud->isEditing()){
			$crud->grid->addPaginator(50);
			$crud->grid->addQuickSearch(array('subscriber','email'));
		}


		$crud->setModel($existing_jobs,array('subscriber','email','sent_at','is_sent','under_category'));
		

		
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