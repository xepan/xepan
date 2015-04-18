<?php

namespace xCRM;

class Model_Email extends \Model_Document{
	public $table = 'xcrm_emails';
	public $status = array();
	public $root_document_name='xCRM\Email';

	function init(){
		parent::init();
		$this->hasOne('xHR/Employee','read_by_employee_id');

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
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function createFromActivity($activity){
		$this['from'] = $activity['from'];
		$this['from_id'] = $activity['from_id'];

		$this['to'] = $activity['to'];
		$this['to_id'] = $activity['to_id'];

		$this['subject'] = $activity['subject'];
		$this['message'] = $activity['message'];
		
		$emails = explode(',', $activity['to_email']);
		$this['to_email'] = $emails[0];
		unset($emails[0]);
		$this['cc'] = implode(",",$emails);

		$this->relatedDocument($activity);
		$this->save();

		if($activity['send_email'])
			$this->send();
		
		if($activity['send_sms'])
			$this->sendSms();

		return $this;
	}

	function send(){
		$this->sendEmail($this['to_email'],$this['subject'],$this['message'],explode(","$this['cc']),$this['bcc']?explode(",",$this['bcc']):array());
	}

	function createActivity(){

	}

	function fetch(){
		// IMAP must be enabled in Google Mail Settings
		// define('GMAIL_EMAIL', 'developer@xavoc.com');
		// define('GMAIL_PASSWORD', 'Developer@67');
		// define('ATTACHMENTS_DIR', getcwd().'/upload');

		// $mailbox = new ImapMailbox('{sun.rightdns.com:993/imap/ssl/novalidate-cert}INBOX', GMAIL_EMAIL, GMAIL_PASSWORD, ATTACHMENTS_DIR, 'utf-8');
		// $mails = array();

		// // Get some mail
		// try{
		// 	$mailsIds = $mailbox->searchMailBox('SINCE "16-4-2015"');
		// 	if(!$mailsIds) {
		// 		$mailbox->disconnect();
		// 	}else{
		// 		$mailId = reset($mailsIds);
		// 		$mail = $mailbox->getMail($mailId);

		// 		var_dump($mail);
		// 		var_dump($mail->getAttachments());
		// 	}

		// }catch(\Exception $e){
		// 	$mailbox->disconnect();
		// }

	}
}