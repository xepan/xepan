<?php

class page_xMarketingCampaign_page_owner_newsletters_massemail extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();

		$this->api->stickyGET('xenquirynsubscription_newsletter_id');

		$this->add('View_Error')->set("This will add Emails to Queue to be processed by xMarketingCampain Application");

		$form = $this->add('Form');
		
		$this->add('H4')->set('Existing Queue');

		$crud= $this->add('CRUD',array('allow_edit'=>false));
		$crud->addClass('panel panel-default');
		$crud->addStyle('margin-top','10px');

		$subscription_field = $form->addField('DropDown','subscriptions');
		$subscription_field->setModel('xEnquiryNSubscription/SubscriptionCategories');
		$subscription_field->setEmptyText('Please select a category')->validateNotNull();
		$form->addField('CheckBox','include_unsubscribed_members_too');
		$form->addSubmit('Add To job');

		$form->add('Controller_FormBeautifier');
		
		if($form->isSubmitted()){
			$subscribers = $this->add('xEnquiryNSubscription/Model_Subscription');
			$asso_j = $subscribers->join('xenquirynsubscription_subscatass.subscriber_id');
			$asso_j->addField('category_id');
			$asso_j->addField('send_news_letters');

			$subscribers->addCondition('category_id',$form['subscriptions']);
			$subscribers->addCondition('is_active',true);

			if(!$form['include_unsubscribed_members_too'])
				$subscribers->addCondition('send_news_letters',true);
			
			$new_job = $this->add('xEnquiryNSubscription/Model_EmailJobs');
			$new_job['newsletter_id'] = $_GET['xenquirynsubscription_newsletter_id'];
			$new_job['process_via']='xMarketingCampaign';
			$new_job->save();

			$q= $this->add('xEnquiryNSubscription/Model_EmailQueue');
			foreach ($subscribers as $junk) {
				$q['emailjobs_id'] = $new_job->id;
				$q['subscriber_id'] = $subscribers->id;
				$q->saveAndUnload();
			}
			if(!$crud->isEditing()) {
				$crud->grid->js(null,$this->js()->_selector('.processing_btn')->trigger('reload'))->reload()->execute();
			}
		}

		$new_job = $this->add('xEnquiryNSubscription/Model_EmailJobs');
		$new_job->addExpression('emails')->set($new_job->refSQL('xEnquiryNSubscription/EmailQueue')->count());
		$new_job->addCondition('newsletter_id',$_GET['xenquirynsubscription_newsletter_id']);
		$new_job['process_via']='xEnquiryNSubscription';
		$crud->setModel($new_job);

		if(!$crud->isEditing()){
			// $form=$crud->grid->add('Form',null,'grid_buttons',array('form_horizontal'));
			// $form->addField('DropDown','top_1');
			$crud->add_button->setIcon('ui-icon-plusthick');
			$crud->grid->addPaginator(50);
			$crud->grid->addQuickSearch(array('subscriber','email'));
		}
	}
}