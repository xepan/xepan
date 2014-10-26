<?php

class page_owner_epansettings extends page_base_owner {
	public $tabs;
	function page_index(){
		// parent::init();

		$this->add( 'H3' )->setHTML( strtoupper($this->api->current_website['name']) . " General Settings <small>Your basic company details and outgoing email settings </small>" );
		$this->tabs = $tabs = $this->add('Tabs');
		$epan_info = $tabs->addTab('Information'); 		

		$epan_info_form = $epan_info->add('Form');
		$epan_info_form->setModel($this->api->current_website,array('category_id','company_name','contact_person_name','mobile_no','email_id','address','city','state','country','keywords','description'));
		$epan_info_form->addSubmit('Update');
		if($epan_info_form->isSubmitted()){
			$epan_info_form->update();
			$epan_info_form->js()->univ()->successMessage('Information Updated')->execute();
		}

		$email_tab = $tabs->addTab('Email Settings');
		$email_form = $email_tab->add('Form');
		$email_form->setModel($this->api->current_website,array('email_host','email_port','email_username','email_password','email_reply_to','email_reply_to_name','email_from','email_from_name','email_threshold'));
		$email_form->addSubmit('Update');

		// Add Placeholder values
		
		$email_form->getElement('email_host')->setAttr('placeholder','i.e. ssl://mail.domain.com');
		$email_form->getElement('email_port')->setAttr('placeholder','465');
		$email_form->getElement('email_username')->setAttr('placeholder','your email id');
		$email_form->getElement('email_password')->setAttr('placeholder','your email password');
		$email_form->getElement('email_reply_to')->setAttr('placeholder','i.e. info@domain.com');
		$email_form->getElement('email_reply_to_name')->setAttr('placeholder','Your Name');
		$email_form->getElement('email_from')->setAttr('placeholder','Your email id');
		$email_form->getElement('email_from_name')->setAttr('placeholder','Your Name');
		$email_form->getElement('email_threshold')->setAttr('placeholder','Maximum Emails allowed to send per hour for Mass Emaling');

		if($email_form->isSubmitted()){
			$email_form->update();
			$email_form->js()->univ()->successMessage('Information Updated')->execute();
		}
		
		
		

	}
}