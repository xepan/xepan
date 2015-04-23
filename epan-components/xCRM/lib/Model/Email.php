<?php

namespace xCRM;

class Model_Email extends \Model_Document{
	public $table = 'xcrm_emails';
	public $status = array();
	public $root_document_name='xCRM\Email';
	public $actions=array(
			'can_view'=>array(),
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_create_activity'=>array(),
			'can_create_ticket'=>array(),
		);	

	function init(){
		parent::init();
		$this->hasOne('xHR/Employee','read_by_employee_id');

		$this->addField('uid');
		$this->addField('from'); // Customer, Employee, Supplier ... string
		$this->addField('from_id');

		$this->addField('to');
		$this->addField('to_id');

		$this->addField('from_email');
		$this->addField('to_email');
		$this->addField('cc')->type('text');
		$this->addField('bcc')->type('text');

		$this->addField('subject');
		$this->addField('message')->type('text');

		$this->hasMany('xCRM/EmailAttachment','related_document_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function createFromActivity($activity){
		$this['from'] = $activity['from'];
		$this['from_id'] = $activity['from_id'];

		$this['to'] = $activity['to'];
		$this['to_id'] = $activity['to_id'];

		$notification_prefix="";
		if($activity['action']!='email'){
			$notification_prefix="Activity Notification @ ";
			$this['notify_via_email']=false;
		}

		//GET ACTIVITY AGAINATS MODEL/name
		$rdoc = $activity->relatedDocument();
		$this['subject'] = $notification_prefix."[".$rdoc->root_document_name." ".$rdoc['name']."] ".$activity['subject'];
		$this['message'] = $activity['message'];
			
		$emails = explode(',', $activity['email_to']);
		$this['to_email'] = $emails[0];

		if(count($emails)>1)
			unset($emails[0]);
		$this['cc'] = implode(",",$emails);

		$this->relatedDocument($activity);
		$this->save();

		if($activity['attachment_id']){
			$this->addAttachment($activity['attachment_id']);
		}
			
		// if($activity['send_sms'])
		// 	$this->sendSms();

		return $this;

	}

	function addAttachment($attach_id){
		if(!$attach_id) return;
		$attach = $this->add('xCRM/Model_EmailAttachment');
		$attach['attachment_url_id'] = $attach_id;
		$attach['related_document_id'] = $this->id;
		$attach->save();
	}

	function send(){		
		$attachments_array = array();
		foreach ($this->attachment() as $attach) {
			$file_model = $this->add('filestore/Model_File')->tryLoad($attach['attachment_url_id']);
			$attachments_array[$file_model['filename']] = getcwd().'/upload/'.$file_model['filename'];
		}
		
		$this->sendEmail($this['to_email'],$this['subject'],$this['message'],explode(",",$this['cc']),$this['bcc']?explode(",",$this['bcc']):array(),$attachments_array);
	}	

	function attachment(){
		if(!$this->loaded())
			return new \Dummy();
		
		return $this->add('xCRM/Model_EmailAttachment')->addCondition('related_document_id',$this->id);

	}

	function create_Activity_page($page){
		$form= $page->add('Form_Stacked');

		$form->addSubmit('Create Activity');
		if($form->isSubmitted()){
			
			return true;
		}
		
	}


	function create_Activity(){
		if(!$this->loaded()) return false;

		$activity = $this->add('xCRM/Model_Activity');
		$activity['from'] = $this['from'];
		$activity['from_id'] = $this['from_id'];

		$activity['to'] = $this['to'];
		$activity['to_id'] = $this['to_id'];

		//GET ACTIVITY AGAINATS MODEL/name
		$rdoc = $this->relatedDocument();
		$activity['subject'] = $rdoc['related_document_name']." [ ".$rdoc['name']." ] ".$this['subject'];
		$activity['message'] = $this['message'];
			
		$emails = explode(',', $this['email_to']);
		$activity['to_email'] = $emails[0];

		if(count($emails)>1)
			unset($emails[0]);
		$activity['cc'] = implode(",",$emails);

		$activity->relatedDocument($this);
		$activity->save();
		$activity->addAttachment($this);

		return $activity;
	}


	function create_Ticket(){

	}

	function fetchDepartment($department,$conditions=null){
		foreach ($department->officialEmails() as $officialEmail) {
			$this->fetch(
				$officialEmail['imap_email_host'],
				$officialEmail['imap_email_port'],
				$officialEmail['imap_email_username'],
				$officialEmail['imap_email_password'],
				$officialEmail['imap_flags'],
				'INBOX',
				// $officialEmail['mailbox'],
				$conditions
				);
		}
	}

	function fetch($imap_email_host,$imap_email_port,$imap_email_username,$imap_email_password,$imap_flags,$mailbox, $conditions=null){
		$mailbox = new \ImapMailbox('{'.$imap_email_host.':'.$imap_email_port.$imap_flags.'}'.$mailbox, $imap_email_username, $imap_email_password, "upload", 'utf-8');
		$mails = array();
		// var_dump($mailbox->getMailboxInfo());
		// return;
		// Get some mail
		try{
			$mailsIds = $mailbox->searchMailBox('SINCE '.date('d-M-Y',strtotime('-1 month')));
			if(!$mailsIds) {
				echo "oops";
				$mailbox->disconnect();
			}else{
				$mail_m = $this->add('xCRM/Model_Email');
				$i=1;
				foreach ($mailsIds as $mailId) {
					$mail = $mailbox->getMail($mailId);
					// var_dump($mail);
					// var_dump($mail->getAttachments());
					$mail_m['uid']= $mail->id;
					$fetched = $this->add('xCRM/Model_Email')
							->addCondition('uid',$mail->id)
							->addCondition('from_email',$mail->fromAddress)
							->addCondition('to_email',is_array($mail->to)?implode(",", $mail->to):$mail->to)
							->addCondition('created_at',$mail->date)
							->tryLoadAny();
							;
					if($fetched->loaded()) continue;

					$mail_m['created_at']= $mail->date;
					$mail_m['from_email'] = $mail->fromAddress;
					$mail_m['subject'] = $mail->subject;
					$mail_m['to_email'] = is_array($mail->to)?implode(",", $mail->to):$mail->to;
					$mail_m['cc'] = is_array($mail->cc)?implode(",", $mail->cc):$mail->cc;
					$mail_m['message'] = $mail->textHtml;
					$mail_m->saveAndUnload();
					$i++;
				}
			}

		}catch(\Exception $e){
			throw $e;
			$mailbox->disconnect();
		}

		function populateFromAndToIds(){
			if(!$this['from_id']){
				// from email search in customers first
				$cust = $this->add('xShop/Model_Customer')->addCondition('customer_email','like','%'.$this['from_email'].'%');
				if($cust->loaded()){
					$this['from']='Customer';
					$this['from_id'] = $cust->id;
				}else{
				// then in suppliers
				// then in employees
				}
			}
		}

	}
}