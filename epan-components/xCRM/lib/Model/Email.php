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
			$attachments_array[$file_model['filename']] = $file_model['url'];
		}
		
		$this->sendEmail($this['to_email'],$this['subject'],$this['message'],explode(",",$this['cc']),$this['bcc']?explode(",",$this['bcc']):array(),$attachments_array);
	}	

	function attachment(){
		if(!$this->loaded())
			return new \Dummy();
		
		return $this->add('xCRM/Model_EmailAttachment')->addCondition('related_document_id',$this->id);

	}

	function create_Activity(){

	}

	function create_Ticket(){

	}

	function fetchDepartment($department,$conditions=null){
		foreach ($department->officialEmails() as $officialEmail) {
			$this->fetch(
				$officialEmail['imap_email_host'],
				$officialEmail['imap_email_port'],
				$officialEmail['imap_encryption'],
				$officialEmail['imap_email_username'],
				$officialEmail['imap_email_password'],
				'INBOX',
				// $officialEmail['mailbox'],
				$conditions
				);
		}
	}

	function fetch($imap_email_host,$imap_email_port,$imap_encryption,$imap_email_username,$imap_email_password,$mailbox, $conditions=null){
		$mailbox = new \ImapMailbox('{'.$imap_email_host.':'.$imap_email_port.'/imap/'.$imap_encryption.'/novalidate-cert}'.$mailbox, $imap_email_username, $imap_email_password, "upload", 'utf-8');
		$mails = array();
		var_dump($mailbox->statusMailbox());
		return;
		// Get some mail
		try{
			$mailsIds = $mailbox->searchMailBox('SINCE "16-4-2015"');
			if(!$mailsIds) {
				$mailbox->disconnect();
			}else{
				$mail_m = $this->add('xCRM/Model_Email');
				foreach ($mailsIds as $mailId) {
					$mail = $mailbox->getMail($mailId);
					// var_dump($mail);
					// var_dump($mail->getAttachments());
					$mail_m['created_at']= $mail->date;
					$mail_m['from_email'] = $mail->fromAddress;
					$mail_m['subject'] = $mail->subject;
					$mail_m->saveAndUnload();
				}
			}

		}catch(\Exception $e){
			throw $e;
			// $mailbox->disconnect();
		}

	}
}