<?php

namespace xCRM;

class View_EmailReply extends \View{
	public $email_id;
	function init(){
		parent::init();

			$email_id = $this->email_id;

			$m = $this->add('xCRM/Model_Email')->tryLoad($email_id);
			$official_email = $m->loadOfficialEmail();
			$footer = "";
			$from_official_email = "";
			if($official_email){
				$footer = $official_email['footer'];
				$from_official_email = $official_email['email_username'];
			}
						
			$reply_form = $this->add('Form_Stacked');
			//Load Official/Support Email According to,cc,bcc
			$reply_message = '<p>On Date: '.$m['created_at'].', '.$m['from_name'].' <'.$m['from_email'].'> Wrote </p>'.$m['message'];
			$reply_message = '<blockquote>'.$reply_message.'</blockquote>';
			$reply_message = $reply_message.'<br/>'.$footer;

			$reply_form->addField('line','to')->set($m['from_email']);
			$reply_form->addField('line','cc')->set($m['cc']);
			$reply_form->addField('line','bcc')->set($m['bcc']);
			$reply_form->addField('line','subject')->set("Re. ".$m['subject']);
			$reply_form->addField('RichText','message')->set($reply_message);
			$reply_form->addSubmit('Reply');

			if($reply_form->isSubmitted()){
				$related_activity = $m->relatedDocument();
				$related_document = $related_activity->relatedDocument();
				$email_body = $reply_form['message'];
				$subject = $reply_form['subject'];
				
				//if this(Email) ka Related Document he to
				if( !($related_document instanceof \Dummy)){
					//Create karo Related Document Ki Activity
					$email_to = $reply_form['to'].','.$reply_form['cc'].$reply_form['bcc'];
					$related_document->createActivity('email',$subject,$email_body,$m['from'],$m['from_id'], $m['to'], $m['to_id'],$email_to,true,true);
				}else{//Create Karo Email 
					$email = $this->add('xCRM/Model_Email');
					$email['from'] = "Employee";
					$email['from_name'] = $this->api->current_employee['name'];
					$email['from_id'] = $this->api->current_employee->id;
					$email['to_id'] = $m['from_id'];
					$email['to'] = $m['from'];
					$email['cc'] = $m['cc'];
					$email['bcc'] = $m['bcc'];
					$email['subject'] = $subject;
					$email['message'] = $email_body;
					$email['from_email'] = $from_official_email; 
					$email['to_email'] = $reply_form['to'];
					$email['direction'] = "sent";
					$email->save();
					$email->send();
					// $email->send($reply_form['to'],$subject,$email_body,explode(",",trim($reply_form['cc'])),explode(",",trim($reply_form['bcc'])),array(),$m->loadOfficialEmail());
				}

				$reply_form->js()->univ()->successMessage('Reply Message Send')->execute();
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
		return array('view/xcrm-emailreply');
	}


}