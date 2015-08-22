<?php

namespace xCRM;

class View_EmailCompose extends \View{
	function init(){
		parent::init();

			$tab = $this->add('Tabs');
			$customer_tab = $tab->addTab('Customer');
			$supplier_tab = $tab->addTab('Supplier');
			$affiliate_tab = $tab->addTab('Affiliate');
			$other_tab = $tab->addTab('Other');

			$department = $this->add('xHR/Model_Department')->tryload($_GET['department_id']);
			$official_email = $department->officialEmails();

			$footer ="";
			$from_official_email ="";
			$attachments_array = array();

			$form = $this->add('Form_Stacked');
			$form->addField('autocomplete/Basic','to_customer','to');
			$form->addField('autocomplete/Basic','to_supplier','to');
			$form->addField('autocomplete/Basic','to_affiliate','to');
			$form->addField('line','to_other','to');

			$form->addField('line','cc');
			$form->addField('line','bcc');
			$official_email_field = $form->addField('dropdown','from_email');
			$official_email_field->setModel($official_email);
			$form->addField('line','subject');
			$form->addField('RichText','message');
			$form->addSubmit('Send');	

			if($form->isSubmitted()){

				$send_successfully = true;
				$subject = $form['subject'];
				$email_body = $form['message'] . $footer;	

				$email = $this->add('xCRM/Model_Email');
				$email['from'] = "Employee";
				$email['from_name'] = $this->api->current_employee['name'];
				$email['from_id'] = $this->api->current_employee->id;
				$email['to_id'] = $form['to'];
				$email['to'] = $form['to'];
				$email['cc'] = $form['cc'];
				$email['bcc'] = $form['bcc'];
				$email['subject'] = $subject;
				$email['message'] = $email_body;
				$email['from_email'] = $from_official_email; 
				$email['to_email'] = $form['to'];
				$email['direction'] = "sent";

				// $document = $this->add('xHR/Model_Document');
				try{
					$email->sendEmail($form['to'],$subject,$email_body,explode(",",$form['cc']),$form['bcc']?explode(",",$form['bcc']):array(),$attachments_array);
				}catch( phpmailerException $e ) {
					$send_successfully = false;	
					// throw $this->exception($e->errorMessage(),'Growl');
				}catch( Exception $e ) {
					$send_successfully = false;	
					// throw $e;
				}

				if(!$send_successfully){
					$form->js()->univ()->errorMessage('Something happen wrong')->execute();
				}
				
				$email->save();
				$form->js(null,$this->js()->univ()->closeDialog())->univ()->successMessage('Email Send Successfully')->execute();
			}
		 


		// $this->js(true)->_selector('.xcrm-emailreply')->xtooltip();
	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		return array('view/xcrm-emailcompose');
	}


}