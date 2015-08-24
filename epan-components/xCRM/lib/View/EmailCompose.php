<?php

namespace xCRM;

class View_EmailCompose extends \View{
	public $email_id;//User for Email Reply
	public $compose_email = true;
	function init(){
		parent::init();

			//For Compose/New Email
			if($this->compose_email){
				$tab = $this->add('Tabs');
				//Customer Tab
				$customer_tab = $tab->addTab('Customer');
				$customer_form=$customer_tab->add('Form');
				$cf =$customer_form->addField('autocomplete/Basic','customer');
				$cf->setModel('xShop/Model_Customer');
				$cf->other_field->on('blur',$customer_form->js()->submit());

				//Supplier Tab
				$supplier_tab = $tab->addTab('Supplier');
				$supplier_form = $supplier_tab->add('Form');
				$sf = $supplier_form->addField('autocomplete/Basic','supplier');
				$sf->setModel('xPurchase/Model_Supplier');
				$sf->other_field->on('blur',$supplier_form->js()->submit());

				//Affiliate Tab
				$affiliate_tab = $tab->addTab('Affiliate');
				$affiliate_form = $affiliate_tab->add('Form');
				$af = $affiliate_form->addField('autocomplete/Basic','affiliate');
				$af->setModel('xShop/Model_Affiliate');
				$af->other_field->on('blur',$affiliate_form->js()->submit());
			}


			$this->add('HR');
			//Official Email 
			$department = $this->add('xHR/Model_Department')->tryload($_GET['department_id']);
			$official_email = $department->officialEmails();

			$footer = "";
			$from_official_email = "";
			$attachments_array = array();


			//Email Form and Fields
			$form = $this->add('Form_Stacked');
			$to_f = $form->addField('line','to');
			$cc_f = $form->addField('line','cc');
			$bcc_f = $form->addField('line','bcc');
			$from_email_f = $form->addField('dropdown','from_email')->setEmptyText('Please Select');
			$from_email_f->setModel($official_email);

			$type_f = $form->addField('hidden','type');
			$id_f = $form->addField('hidden','to_id');

			$subject_f = $form->addField('line','subject');
			$message_f = $form->addField('RichText','message');
			$footer_view = $form->add('View');
			//Add Attachment
			$attachment_f = $form->addField('upload','attachment');
			$attachment_f->setModel('filestore/File');

			
			//Submit Button
			$submit_button = $form->addSubmit('Send');

			$official_email_model = $this->add('xHR/Model_OfficialEmail');

			//Form Field Chage Event
			$from_email_f->on('change',$footer_view->js()->reload(array('selected_from_email'=>$from_email_f->js()->val())));
			
			if(isset($_GET['selected_from_email']) && $_GET['selected_from_email']){
				$official_email_model->load($_GET['selected_from_email']);
				$footer_view->setHtml($official_email_model['footer']);
			}	

			//Load Previous Email Body
			if($this->email_id && !$this->compose_email){
				$reply_against_email = $this->add('xCRM/Model_Email')->tryLoad($this->email_id);
				$official_email = $reply_against_email->loadOfficialEmail();
				if($official_email){
					$footer = $official_email['footer'];
					$from_official_email = $official_email['email_username'];
				}
				$reply_message = '<p>On Date: '.$reply_against_email['created_at'].', '.$reply_against_email['from_name'].' <'.$reply_against_email['from_email'].'> Wrote </p>'.$reply_against_email['message'];
				$reply_message = '<p></p><br/><blockquote>'.$reply_message.'</blockquote>';
				$reply_message = $reply_message.'<br/>';

				$to_f->set($reply_against_email['from_email']);
				$cc_f->set($reply_against_email['cc']);
				$bcc_f->set($reply_against_email['bcc']);
				$subject_f->set("Re: ".$reply_against_email['subject']);
				$message_f ->set($reply_message);
				$submit_button->set('Reply');
			}


			if($form->isSubmitted()){
				
				$official_email_model = $this->add('xHR/Model_OfficialEmail');
				$official_email_model->load($form['from_email']);
				$footer = $official_email_model['footer'];
				
				$subject = $form['subject'];
				$email_body = $form['message'].$footer;

				$email_to = $form['to'].','.$form['cc'].$form['bcc'];
				if(isset($reply_against_email) and !$this->compose_email){//For Reply Email
					$related_activity = $reply_against_email->relatedDocument();
					$related_document = $related_activity->relatedDocument();
					//if this(Email) ka Related Document he to
					if( !($related_document instanceof \Dummy)){
						//Create karo Related Document Ki Activity
						$related_document->createActivity('email',$subject,$email_body,$reply_against_email['from'],$reply_against_email['from_id'], $reply_against_email['to'], $reply_against_email['to_id'],$email_to,true,true,$form['attachment'],$official_email_model->get());
					}else{//Create Karo Email
						$email = $this->add('xCRM/Model_Email');
						$email['from'] = "Employee";
						$email['from_name'] = $this->api->current_employee['name'];
						$email['from_id'] = $this->api->current_employee->id;
						$email['to_id'] = $reply_against_email['from_id'];
						$email['to'] = $reply_against_email['from'];
						$email['cc'] = $form['cc'];
						$email['bcc'] = $form['bcc'];
						$email['subject'] = $subject;
						$email['message'] = $email_body;
						$email['from_email'] = $from_official_email; 
						$email['to_email'] = $form['to'];
						$email['direction'] = "sent";
						$email->save();
						$email->addAttachment($form['attachment']);
						$email->send();
					}
				}else{//For Composer Email
					$to_type = explode('/',$form['type']);
					$to_type =  explode('_',$to_type[1]);
					$to_type = $to_type[1];

					$model = $this->add($form['type'])->load($form['to_id']);
					$model->createActivity('email',$subject,$email_body,null,null, $to_type, $form['to_id'],$email_to,true,false,$form['attachment'],$official_email_model->get());
				}

				$js_action = array($form->js()->reload(),$this->js()->univ()->closeDialog());
				$form->js(null,$js_action)->univ()->successMessage('Email Send Successfully')->execute();
			}
		 	
		 	if($this->compose_email){

				$customer_form->onSubmit(function($f)use($to_f,$cc_f,$type_f,$id_f){

					$customer = $f->add('xShop/Model_Customer')->addCondition('id',$f['customer'])->tryLoadAny();
					$emails = explode(',', $customer['customer_email']);
					$to_email = $emails[0];
					unset($emails[0]);
					$js = array(
							$to_f->js()->val($to_email),
							$type_f->js()->val('xShop/Model_Customer'),
							$id_f->js()->val($f['customer'])
						);
					return $cc_f->js(null,$js)->val(implode(',',$emails));
				});

				$supplier_form->onSubmit(function($f)use($to_f,$cc_f,$type_f,$id_f){
					$supplier = $f->add('xPurchase/Model_Supplier')->addCondition('id',$f['supplier'])->tryLoadAny();
					$emails = explode(',', $supplier['email']);
					$to_email = $emails[0];
					unset($emails[0]);
					$js = array(
							$to_f->js()->val($to_email),
							$type_f->js()->val('xPurchase/Model_Supplier'),
							$id_f->js()->val($f['supplier'])
						);
					return $cc_f->js(null,$js)->val(implode(',',$emails));
				});

				$affiliate_form->onSubmit(function($f)use($to_f,$cc_f,$type_f,$id_f){
					$affiliate = $f->add('xShop/Model_Affiliate')->addCondition('id',$f['affiliate'])->tryLoadAny();
					$emails = explode(',', $affiliate['email_id']);
					$to_email = $emails[0];
					unset($emails[0]);
					$js = array(
							$to_f->js()->val($to_email),
							$type_f->js()->val('xShop/Model_Affiliate'),
							$id_f->js()->val($f['affiliate'])
						);
					return $cc_f->js(null,$js)->val(implode(',',$emails));
				});
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