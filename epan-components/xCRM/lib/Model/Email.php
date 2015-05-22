<?php

namespace xCRM;

class Model_Email extends \Model_Document{
	public $table = 'xcrm_emails';
	public $status = array();
	public $root_document_name='xCRM\Email';
	public $actions=array(
			'can_view'=>array(),
			// 'allow_add'=>array(),
			// 'allow_edit'=>array(),
			// 'allow_del'=>array(),
			'can_create_activity'=>array('caption'=>'Action'),
			// 'can_create_ticket'=>array(),
			'can_see_activities'=>false,
			'can_manage_attachments'=>false
		);	

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xHR/Employee','read_by_employee_id');

		$this->addField('uid');
		$this->addField('from'); // Customer, Employee, Supplier ... string
		$this->addField('from_id');

		$this->addField('to');
		$this->addField('to_id');

		$this->addField('from_email');
		$this->addField('from_name');
		$this->addField('to_email');
		$this->addField('cc')->type('text');
		$this->addField('bcc')->type('text');

		$this->addField('subject');
		$this->addField('message')->type('text');
		$this->addField('attachments')->type('text');
		
		$this->addField('keep_unread')->type('boolean')->defaultValue(false);
		
		$this->addField('direction')->enum(array('sent','received'))->defaultValue('sent');

		$this->addHook('beforeDelete',$this);

		$this->hasMany('xCRM/EmailAttachment','related_document_id',null,'Attachments');

		$this->setOrder('created_at','desc');

	//	$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		$this->ref('Attachments')->each(function($m){
			$m->forceDelete();
		});
	}

	function createFromActivity($activity){
		$this['from'] = $activity['from'];
		$this['from_id'] = $activity['from_id'];

		$this['to'] = $activity['to'];
		$this['to_id'] = $activity['to_id'];

		$notification_prefix="";
		if($activity['action']!='email'){
			$notification_prefix="Activity Notification @ ";
			$activity['notify_via_email']=false;
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

	function addAttachment($attach_id,$name=null){
		if(!$attach_id) return;
		$attach = $this->add('xCRM/Model_EmailAttachment');
		$attach['attachment_url_id'] = $attach_id;
		$attach['related_document_id'] = $this->id;
		if($name)
			$attach['name'] = $name;

		$attach->save();

		return $attach;
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
		// if(!$this->loaded())
		// 	return new \Dummy();
		
		return $this->ref('Attachments')->addCondition('related_document_id',$this->id);

	}

	function getAttachments(){
		$attach_arry = array();
		if($this->loaded()){
			foreach ($this->attachment() as $attach) {
				$attach_arry[] = $attach['id'];
			}

		}
		
		return $attach_arry;
	}


	function create_Activity_page($page){
		
		$form = $page->add('Form_Stacked');
		$col = $form->add('Columns');
		
		$from_field = $form->addField('DropDownNormal','from')->setValueList(
								array('Customer'=>'Customer',
										'Supplier'=>'Supplier',
										'Affiliate'=>'Affiliate'
								))->setEmptyText('Select From');
	
		$from_name_field = $form->addField('autocomplete/Basic','from_name');
		
		$from_field->js('change',$form->js()->atk4_form('reloadField','from_name',array($this->api->url(),'from'=>$from_field->js()->val())));
		
		// $from_name_field->send_other_fields = array($_GET['from']);
		// if($from_selected = $_GET['o_'.$from_field->name]){

		// 	switch ($from_selected) {
		// 			case 'Customer':
		// 				$m = $this->add('xShop/Model_Customer');
		// 				$from_name_field->setModel($m);	
		// 			break;						
		// 		}
		// 	// $from_name_field->model->addCondition('member_id',$member_selected);
		// 	// $loan_against_account_field->model->addCondition('ActiveStatus',true);
		// 	// $loan_against_account_field->model->addCondition('LockingStatus',false);
		// }


		$to_field = $form->addField('DropDownNormal','to')->setValueList(
						array('Customer'=>'Customer',
								'Supplier'=>'Supplier',
								'Affiliate'=>'Affiliate'
						))->setEmptyText('Select To');
		
		$to_name_field = $form->addField('autocomplete/Basic','to_name');

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
			$conditions = $conditions?:'SINCE '.date('d-M-Y',strtotime('-1 day'));
			$mailsIds = $mailbox->searchMailBox($conditions);
			if(!$mailsIds) {
				$mailbox->disconnect();
			}else{
				$mail_m = $this->add('xCRM/Model_Email');
				$i=1;
				$fetch_email_array = array();
				foreach ($mailsIds as $mailId) {
					$mail = $mailbox->getMail($mailId);
					// var_dump($mail);
					// var_dump($mail->getAttachments());
					$mail_m['uid']= $mail->id;
					$fetched = $this->add('xCRM/Model_Email')
							->addCondition('uid',$mail->id)
							->addCondition('from_email',$mail->fromAddress)
							->addCondition('to_email',is_array($mail->to)?implode(",", array_keys($mail->to)):$mail->to)
							->addCondition('created_at',$mail->date)
							->tryLoadAny();
							;
					if($fetched->loaded()) continue;

					$mail_m['created_at']= $mail->date;
					$mail_m['from_email'] = $mail->fromAddress;
					$mail_m['to_email'] = is_array($mail->to)?implode(",", array_keys($mail->to)):$mail->to;
					$mail_m['cc'] = is_array($mail->cc)?implode(",", array_keys($mail->cc)):$mail->cc;
					$mail_m['subject'] = $mail->subject;
					$mail_m['message'] = $mail->textHtml;
					$mail_m['uid'] = $mail->id;
					$mail_m['direction'] = 'received';
					$mail_m['from_name'] = $mail->fromName;
					$mail_m->save();
					$fetch_email_array[] = $mail_m->id;
					
					//MAIL ATTACHMENT 
					$attachments = $mail->getAttachments();
					foreach ($attachments as $attach) {
						$file =	$this->add('filestore/Model_File',array('policy_add_new_type'=>true,'import_mode'=>'move','import_source'=>$attach->filePath));
						$file['filestore_volume_id'] = $file->getAvailableVolumeID();
						$file['original_filename'] = $attach->name;
						$file->save();
						$mail_m->addAttachment($file->id,$attach->name);
					}

					$mail_m->unload();
					$i++;
				}

				//FOR EMAIL FROM AND DOCUMENT GUESS
				if(count($fetch_email_array) > 0){
					$email = $this->add('xCRM\Model_Email');
					foreach ($fetch_email_array as $email_id) {
						$email->load($email_id);
						$email->populateFromAndToIds();
						$email->unload();
					}
				}

			}

		}catch(\Exception $e){
			$mailbox->disconnect();
			throw $e;
		}
	}

	function populateFromAndToIds(){
		$this->guessFrom();
		$doc = $this->guessDocumentAndCreateActivityOrTicket();
		$this->guessTo($doc);
	}

	function guessFrom(){
		if(!$this->loaded())
			return false;

		if(!$this['from_email'])
			return false;

		//GUESS CUSTOMER
		if($customer = $this->customer()){
			$this['from'] = "Customer";
			$this['from_id'] = $customer['id'];
		}elseif($supplier = $this->supplier()){
			//guess Supplier
			$this['from'] = "Supplier";
			$this['from_id'] = $supplier['id'];
		}elseif($emp = $this->employee()){
			$this['from'] = "Employee";
			$this['from_id'] = $emp['id'];
		}
		
		$this->save();
	}

	function fromMemberName(){
		
		if(!$this->loaded()) return;
		switch ($this['from']) {
			case 'Customer':
				$c = $this->add('xShop/Model_Customer')->addCondition('id',$this['from_id'])->tryLoadAny();
				if($c->loaded())					
					return $c['customer_name'];
			break;			
			case 'Supplier':
				$s = $this->add('xPurchase/Model_Supplier')->addCondition('id',$this['from_id'])->tryLoadAny();
				if($s->loaded())
					return $s['name'];
			break;
			case 'Employee':
				$e = $this->add('xHR/Model_Employee')->addCondition('id',$this['from_id'])->tryLoadAny();
				if($e->loaded())
					return $e['name'];
			break;
		}
	}

	function toMemberName(){
		
		if(!$this->loaded()) return;
		switch ($this['to']) {
			case 'Customer':
				$c = $this->add('xShop/Model_Customer')->addCondition('id',$this['from_id'])->tryLoadAny();
				if($c->loaded())					
					return $c['customer_name'];
			break;			
			case 'Supplier':
				$s = $this->add('xPurchase/Model_Supplier')->addCondition('id',$this['from_id'])->tryLoadAny();
				if($s->loaded())
					return $s['name'];
			break;
			case 'Employee':
				$e = $this->add('xHR/Model_Employee')->addCondition('id',$this['from_id'])->tryLoadAny();
				if($e->loaded())
					return $e['name'];
			break;
		}
	}
	function guessTo($doc=false){
		if($doc){
			$to = $doc->getTo();
			if($to instanceof \xShop\Model_Customer){
				$this['to'] = 'Customer';
				$this['to_id'] = $to->id;
			
			}elseif($to instanceof \xHR\Model_Employee){
				$this['to'] = 'Employee';
				$this['to_id'] = $to->id;
			
			}elseif($to instanceof \xPurchase\Model_Supplier) {
				$this['to'] = 'Supplier';
				$this['to_id'] = $to->id;
			}
		}else{

		}

		$this->save();
	}

	function guessDocumentAndCreateActivityOrTicket(){
		if(!$this['subject'])
			return false;

		//get ticket no from subject
		preg_match_all('/([a-zA-Z]+[\\\\][a-zA-Z]+[ ]+[0-9]+)/',$this['subject'],$preg_match_array);
		// throw new \Exception($this['subject'].  var_dump($preg_match_array[1][0]), 1);
		if(!count($preg_match_array[1])) return;
		

		//Guess Ticket
		$relatedDocument = $preg_match_array[1][0];
		$document_array_all = explode(" ", $relatedDocument);
		$document_array = explode("\\", $document_array_all[0]);

		$document = $this->add($document_array[0].'\Model_'.$document_array[1]);
		$document->tryLoadBy('name',$document_array_all[1]);

		if($document->loaded()){
			$new_activity = $document->createActivity('Email',$this['subject'],$this['message'],$this['from'],$this['from_id'], $this['to'], $this['to_id']);
			// $new_activity->relatedDocument($document);

			foreach ($this->attachment() as $attachment) {
				$new_att = $this->add('Model_Attachment');
				$new_att['related_document_id'] = $new_activity->id;
				$new_att['related_root_document_name'] = $new_activity->root_document_name;
				$new_att['name'] = $attachment['name'];
				$new_att['attachment_url_id'] = $attachment['attachment_url_id'];
				$new_att->save();
			}			
			return $document;
		}

		// if(i m sent to one of support emails and FROM is known){
			// Create a new ticket send autoreply (set in config ???)

		// }

		return false;

	}

	function customer(){
		$cstmr = $this->add('xShop/Model_Customer');
		$cstmr->addCondition('customer_email','like','%'.$this['from_email'].'%');
		
		if($cstmr->count()->getOne() > 1)
			return false;

		$cstmr->tryLoadAny();
		if($cstmr->loaded())
			return $cstmr;

		return false;
	}

	function supplier(){
		$supplr = $this->add('xPurchase/Model_Supplier'); 
		$supplr->addCondition('email','like','%'.$this['from_email'].'%');

		if($supplr->count()->getOne() > 1)
			return false;

		$supplr->tryLoadAny();
		if($supplr->loaded())
			return $supplr;

		return false;
	}

	function employee(){
		$emp = $this->add('xHR/Model_Employee');
		$emp->addCondition('personal_email','like','%'.$this['from_email'].'%');
		
		if($emp->count()->getOne() > 1)
			return false;

		$emp->tryLoadAny();
		if($emp->loaded())
			return $emp;

		return false;
	}


	function loadDepartmentEmails($dept_id=null){
		if(!$dept_id)
			$dept_id = $this->api->stickyGET('department_id');
		
		$official_emails = $this->add('xHR/Model_OfficialEmail');
		$official_emails->addCondition('department_id',$dept_id);
		
		if(!$official_emails->count()->getOne())
			return false;
		
		$or_cond = $this->dsql()->orExpr();


		$official_email_array = array();
		foreach ($official_emails as $official_email) {
			$official_email_array[] = $official_email['email_username'];
			$official_email_array[] = $official_email['imap_email_username'];
			
			$or_cond->where('cc','like','%'.$official_email['email_username'].'%');
			$or_cond->where('cc','like','%'.$official_email['imap_email_username'].'%');
		}

		$or_cond->where('from_email','in',$official_email_array)
				->where('to_email','in',$official_email_array);


		$this->addCondition(
					$or_cond
					);

		// $this->tryLoadAny();
		return $this;
	}

	function isReceive(){

		$dept = $this->api->current_department;
		$official_emails = $dept->officialEmails();

		// if(!$official_emails->count()->getOne())
		// 	return false;		
		foreach ($official_emails as $official_email) {
			if(in_array($official_email['imap_email_username'], explode(",", $this['to_email'])))
				return true;
		}

		
		return false;

	}

	function isSent(){
		$dept = $this->api->current_department;
		$official_emails = $dept->officialEmails();

		// if(!$official_emails->count()->getOne())
		// 	return false;

		foreach ($official_emails as $official_email) {
			if(in_array($official_email['email_username'], explode(",", $this['from_email']))){
				return true;
			}
		return false;		
		}

	}

	function setReadByEmployeeNull(){
		$this['read_by_employee_id'] = null;
		$this->save();
	}


	function markRead(){
		if(!$this['read_by_employee_id']){
			$this['read_by_employee_id'] = $this->api->current_employee->id;
			$this->save();
		}

		return $this;
	}

}