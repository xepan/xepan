<?php

namespace xEnquiryNSubscription;


class Model_NewsLetter extends \Model_Document {
	public $table ='xenquirynsubscription_newsletter';
	public $status = array();
	public $root_document_name = 'xEnquiryNSubscription\NewsLetter';
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_send_via_email'=>array(),
			
		);


	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xEnquiryNSubscription/NewsLetterCategory','category_id')->mandatory(true)->sortable(true);

		$f=$this->addField('name')->mandatory(true)->group('a1~6~Internal Name')->sortable(true);
		$f->icon='fa fa-adn~red';
		$f = $this->addField('is_active')->type('boolean')->defaultValue(true)->group('a1~2');
		$f->icon='fa fa-exclamation~blue';
		// $this->addField('short_description')->display(array('grid'=>'shorttext,wrap'));//->hint('255 Characters Msg for social and tweets');
		$this->addField('email_subject')->mandatory(true)->group('a~12~<i/> NewsLetter')->sortable(true);
		$this->addField('matter')->type('text')->display(array('form'=>'RichText'))->defaultValue('<p></p>')->group('a~12~bl')->mandatory(true);
		$this->hasMany('xEnquiryNSubscription/EmailJobs','newsletter_id');
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);

		//$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'))->system(true);
		//$this->addField('updated_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'))->system(true);
		$this->addField('created_by_app')->system(true)->defaultValue('xEnquiryNSubscription')->sortable(true);

		$this->setOrder('created_at','desc');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){
		if($this['matter']=='<p></p>')
			throw $this->exception('Matter is mandatory field','ValidityCheck')->setField('matter');

		$this['updated_at'] = date('Y-m-d H:i:s');

	}

	function beforeDelete(){
		$jobs=$this->ref('xEnquiryNSubscription/EmailJobs');
		foreach($jobs as $junk){
			$jobs->delete();
		}
		
		$this->api->event('xenq_n_subs_newletter_before_delete',$this);
	}
	
		function page_newsletter_send_page($p){
		$p->api->stickyGET('xenquirynsubscription_newsletter_id');

		$v= $p->add('View');
		$v->addClass('panel panel-default');
		// $v->addStyle('padding','20px');

		$tabs = $v->add('Tabs');
		$mass_email_tab = $tabs->addTab('Mass Emails');
		// $mass_email_tab->add('View_Error')->set("This will add Emails to Queue to be processed by xMarketingCampain Application");

		$form = $mass_email_tab->add('Form');
		
		$mass_email_tab->add('H4')->set('Existing Queue');

		$crud= $mass_email_tab->add('CRUD',array('allow_edit'=>false));
		$crud->addClass('panel panel-default');
		$crud->addStyle('margin-top','10px');

		$subscription_field = $form->addField('DropDown','subscriptions');
		$subscription_field->setModel('xEnquiryNSubscription/SubscriptionCategories');
		$subscription_field->setEmptyText('Please select a category')->validateNotNull();
		$form->addField('CheckBox','include_unsubscribed_members_too');
		$form->addSubmit('Add To job');

		// $form->add('Controller_FormBeautifier');
		
		if($form->isSubmitted()){
			$subscribers = $this->add('xEnquiryNSubscription/Model_Subscription');
			$asso_j = $subscribers->join('xenquirynsubscription_subscatass.subscriber_id');
			$asso_j->addField('category_id');
			$asso_j->addField('send_news_letters');

			$subscribers->addCondition('category_id',$form['subscriptions']);
			if(!$form['include_unsubscribed_members_too'])
				$subscribers->addCondition('send_news_letters',true);
			
			$new_job = $this->add('xEnquiryNSubscription/Model_EmailJobs');
			$new_job['newsletter_id'] = $_GET['xenquirynsubscription_newsletter_id'];
			$new_job['process_via']='xEnquiryNSubscription';
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

}
}