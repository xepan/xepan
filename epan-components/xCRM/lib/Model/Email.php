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
			'can_see_activities'=>false,
			'can_manage_attachments'=>false
		);	

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('xProduction/Task','task_id');

		$this->hasOne('xHR/Employee','read_by_employee_id');
		
		$this->addField('task_status');

		
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
		$this->addHook('beforeSave',$this);

		$this->hasMany('xCRM/EmailAttachment','related_document_id',null,'Attachments');

		$this->addExpression('to_member_name')->set(function(){
			return '"to_member_1111"';
		});

		// $this->addExpression('from_member_name')->set(function(){
		// 	return '"from_member_1111"';
		// });

		$this->setOrder('created_at','desc');

		$this->addExpression('from_detail')->set(function($m,$q){
			return $q->expr("
					CASE [0]
						WHEN 'Customer' THEN [1]
						WHEN 'Supplier' THEN [2]
						WHEN 'Employee' THEN [3]
						WHEN 'Affiliate' THEN [4]
						ELSE
							'Others'
					END
				",
				[
					$m->getElement('from'),
					$m->add('xShop/Model_Customer')->addCondition('id',$q->getField('from_id'))->fieldQuery('customer_name'),
					$m->add('xPurchase/Model_Supplier')->addCondition('id',$q->getField('from_id'))->fieldQuery('name'),
					$m->add('xHR/Model_Employee')->addCondition('id',$q->getField('from_id'))->fieldQuery('name'),
					$m->add('xShop/Model_Affiliate')->addCondition('id',$q->getField('from_id'))->fieldQuery('name'),

				]);
		});


	//	$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		$this->ref('Attachments')->each(function($m){
			$m->forceDelete();
		});
	}

	function beforeSave(){
		if(!$this['from_email'])
			$this['from_email'] =$this->api->current_website['email_username'];
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
	
		$col = $page->add('Columns');
		$col_left = $col->addColumn(3);
		$col_midleft = $col->addColumn(3);
		$col_midright = $col->addColumn(3);
		$col_right = $col->addColumn(3);
		
		//Model____________________________	
		$customer_model = $page->add('xShop/Model_Customer');
		$supplier_model = $page->add('xPurchase/Model_Supplier');
		$affiliate_model = $page->add('xShop/Model_Affiliate');
		$lead_model = $page->add('xMarketingCampaign/Model_Lead');
		$employee_model = $page->add('xHR/Model_Employee');
	
		//From____________________________________________________	
		$col_left->add('H4')->set('From')->addClass('atk-swatch-ink atk-padding-small');
		
		$from_form = $col_left->add('Form_Stacked');

		$from_lead_field = $from_form->addField('autocomplete/Basic','from_lead');
		$from_lead_field->setModel($lead_model);
		
		$from_customer_field = $from_form->addField('autocomplete/Basic','from_customer');
		$from_customer_field->setModel($customer_model);

		$from_supplier_field = $from_form->addField('autocomplete/Basic','from_supplier');
		$from_supplier_field->setModel($supplier_model);

		$from_affiliate_field = $from_form->addField('autocomplete/Plus','from_affiliate');
		$from_affiliate_field->setModel($affiliate_model);
		
		$from_employee_field = $from_form->addField('autocomplete/Basic','from_employee');
		$from_employee_field->setModel($employee_model);

		$from_form->addField('Checkbox','store_email');
		$from_form->addSubmit('Set From');
		
		if($this['from']){

			switch ($this['from']) {
				case 'Customer':
					$from_filed_to_fill = $from_customer_field;
				break;

				case 'Employee';
					$from_filed_to_fill = $from_employee_field;
				break;

				case 'Lead';
					$from_filed_to_fill = $from_lead_field;
				break;

				case 'Supplier';
					$from_filed_to_fill = $from_supplier_field;
				break;

				case 'Affiliate';
					$from_filed_to_fill = $from_affiliate_field;
				break;
			}

			if(isset($from_filed_to_fill))
				$from_filed_to_fill->set($this['from_id']);
		}

		if($from_form->isSubmitted()){
			if( ($from_form['from_customer']?1:0) + ($from_form['from_supplier']?1:0) + ($from_form['from_affiliate']?1:0) + ($from_form['from_lead']?1:0) > 1 )
				throw $this->exception('Please Select Any One From','Growl');
			
			$from = "";
			$from_id = "";

			if($from_form['from_customer']){
				$from = "Customer";
				$from_id = $from_form['from_customer'];

			}elseif ($from_form['from_supplier']) {
				$from = "Supplier";
				$from_id = $from_form['from_supplier'];

			}elseif($from_form['from_lead']){
				$from = "Lead";
				$from_id = $from_form['from_lead'];

			}elseif($from_form['from_employee']){
				$from = "Employee";
				$from_id = $from_form['from_employee'];

			}elseif($from_form['from_affiliate']){
				$from = "Affiliate";
				$from_id = $from_form['from_affiliate'];				
			}

			$this->setFrom($from_id, $from);
			if($from_form['store_email'])
				$this->updateFromEmail();

			return true;

		}

		//TO Updatee________________________________________________________
		$col_midleft->add('H4')->set('To')->addClass('atk-swatch-ink atk-padding-small');
		
		$to_form = $col_midleft->add('Form_Stacked');
		
		$to_lead_field = $to_form->addField('autocomplete/Basic','to_lead');
		$to_lead_field->setModel($lead_model);
		
		$to_customer_field = $to_form->addField('autocomplete/Basic','to_customer');
		$to_customer_field->setModel($customer_model);
		
		$to_supplier_field = $to_form->addField('autocomplete/Basic','to_supplier');
		$to_supplier_field->setModel($supplier_model);
		
		$to_affiliate_field = $to_form->addField('autocomplete/Basic','to_affiliate');
		$to_affiliate_field->setModel($affiliate_model);
		
		$to_employee_field = $to_form->addField('autocomplete/Basic','to_employee');
		$to_employee_field->setModel($employee_model);
		
		$to_form->addField('Checkbox','store_email');
		$to_form->addSubmit('Set To');
		
		if($this['to']){
			switch ($this['to']) {
				case 'Customer':
					$to_filed_to_fill = $to_customer_field;
				break;

				case 'Employee';
					$to_filed_to_fill = $to_employee_field;
				break;

				case 'Lead';
					$to_filed_to_fill = $to_lead_field;
				break;

				case 'Supplier';
					$to_filed_to_fill = $to_supplier_field;
				break;

				case 'Affiliate';
					$to_filed_to_fill = $to_affiliate_field;
				break;
			}

			if(isset($to_filed_to_fill))
				$to_filed_to_fill->set($this['to_id']);
		}

		if($to_form->isSubmitted()){
			
			if( ($to_form['to_customer']?1:0) + ($to_form['to_supplier']?1:0) + ($to_form['to_affiliate']?1:0) + ($to_form['to_lead']?1:0) > 1 )
				throw $this->exception('Please Select Any One To','Growl');
			
			$to = "";
			$to_id = "";

			if($to_form['to_customer']){
				$to = "Customer";
				$to_id = $to_form['from_customer'];

			}elseif ($to_form['to_supplier']) {
				$to = "Supplier";
				$to_id = $to_form['to_supplier'];

			}elseif($to_form['to_lead']){
				$to = "Lead";
				$to_id = $to_form['to_lead'];

			}elseif($to_form['to_employee']){
				$to = "Employee";
				$to_id = $to_form['to_employee'];

			}elseif($from_form['to_affiliate']){
				$to = "Affiliate";
				$to_id = $to_form['to_affiliate'];				
			}

			if($to_form['store_email']){
				$this->updateToEmail();
			}

			$this->setTo($to_id, $to);
			return true;
			// $to_form->js()->univ()->successMessage('To Update Successfully')->execute();
			// }
		}

		//Document ___________________________________________________
		$col_midright->add('H4')->set('Document')->addClass('atk-swatch-ink atk-padding-small');
		$document_form = $col_midright->add('Form_Stacked');
		$document_form->addField('autocomplete/Basic','opportunity')->setModel('xShop/Model_Opportunity');
		$document_form->addField('autocomplete/Basic','quotation')->setModel('xShop/Model_Quotation');
		$document_form->addField('autocomplete/Basic','sale_order')->setModel('xShop/Model_Order');
		$document_form->addField('autocomplete/Basic','purchase_order')->setModel('xPurchase/Model_PurchaseOrder');
		$document_form->addField('autocomplete/Basic','sale_invoice')->setModel('xShop/Model_SalesInvoice');
		$document_form->addField('autocomplete/Basic','purchase_invoice')->setModel('xPurchase/Model_PurchaseInvoice');
		$document_form->addSubmit('Set Document');
		if($document_form->isSubmitted()){

		}

		//Task_______________________________________________

		$col_right->add('H4')->set('Create Task')->addClass('atk-swatch-ink atk-padding-small');
		$task_form = $col_right->add('Form_Stacked');
		$narration_field = $task_form->addField('text','narration')->set($this['subject']);
		$employee_field = $task_form->addField('autocomplete/Basic','employee','Assign To Employee');
		$employee_field->setModel($employee_model);
		$task_end_date_field = $task_form->addField('DatePicker','expected_end_date');
		$task_priority_field = $task_form->addField('DropDown','priority')->setValueList(array('Low'=>'Low','Medium'=>'Medium','High'=>'High','Urgent'=>'Urgent'))->set('Medium');
		$task_form->addSubmit('Create Task & Assign');
		
		$pre_task = $this->task();
		if($pre_task->loaded()){
			$narration_field->set($pre_task['subject']);
			$employee_field->set($pre_task['employee_id']);
			$task_end_date_field->set($pre_task['expected_end_date']);
			$task_priority_field->set($pre_task['Priority']);
		}

		if($task_form->isSubmitted()){
			$this->createTask($task_form['narration'],$task_form['employee'],$task_form['expected_end_date'],$task_form['priority']);
			return true;
		}

	}	

	//Create Task and Assign To Employee
	function createTask($narration,$assing_to_employee_id,$expected_end_date=null,$priority='Medium'){
		if(!$this->loaded()) return false;

		$task = $this->add('xProduction/Model_Task');
		if($this['task_id'])
			$task->load($this['task_id']);
		
		$task['status']= 'assigned';
		$task['employee_id']= $assing_to_employee_id;
		$task['subject'] = $narration;
		$task['content'] = $this['subject'].'<br/>'.$this['message'];
		$task['expected_end_date'] = $expected_end_date;
		$task['Priority'] = $priority;
		$task->relatedDocument($this);
		$task->save();

		//Update Email Task Id
		$this['task_id'] = $task->id;
		$this['task_status'] = $task['status'];
		$this->save();


		foreach ($this->attachment() as $attach) {
			$task_attach = $this->add('xCRM/Model_TaskAttachment');
			$task_attach['attachment_url_id'] = $attach->id;
			$task_attach['related_document_id'] = $task->id;
			$task_attach['name'] = $attach['name'];
			$task_attach->save();
		}
		
	}

	function start_processing($remark=null){
		$this['task_status'] = 'processing';
		$this->save();
	}

	function mark_processed($remark){
		$this['task_status'] = 'processed';
		$this->save();
	}

	function approve(){
		$this['task_status'] = 'completed';
		$this->save();	
	}

	function task(){
		return $this->ref('task_id');
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
		$t = $this->add('xCRM/Model_Ticket');
		$t['status'] = "Submitted";
		$t['uid'] = $this['uid'];
		$t['from'] = $this['from'];
		$t['from_id'] = $this['from_id'];
		$t['from_email'] = $this['from_email'];
		$t['from_name'] = $this['from_name'];
		$t['to'] = $this['to'];
		$t['to_id'] = $this['to_id'];
		$t['to_email'] = $this['to_email'];
		$t['cc'] = $this['cc'];
		$t['subject'] = $this['subject'];
		$t['message'] = $this['message'];
		
		if($this['from']=="Customer")
			$t['customer_id'] = $this['from_id'];

		$t->relatedDocument($this);
		$t->save();
		foreach ($this->attachment() as $attach) {
			$t->addAttachment($attach['attachment_url_id'],$attach['name']);	
		}
		$t->autoReply();

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
					$mail_m['message'] = $mail->textHtml?:$mail->textPlain;
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
						if(!($email->hasDocument()) AND $email->forSupport()){
							$email->create_Ticket();
						}
						$email->unload();
					}
				}

			}

		}catch(\Exception $e){
			$mailbox->disconnect();
			throw $e;
		}
	}

	function forSupport(){
		$off_email = $this->add('xHR/Model_OfficialEmail');
		$support_emails = $off_email->supportEmails();
		
		foreach ($support_emails as $support_email) {
			if(	in_array($support_email['imap_email_username'],explode(',', $this['to_email'].','.$this['cc'].','.$this['bcc'])) )
				return true;
		}

		return false;
	}

	function populateFromAndToIds(){
		$this->guessFrom();
		$doc = $this->guessDocumentAndCreateActivityOrTicket();
		$this->guessTo();
	}

	function guessFrom(){
		if(!$this->loaded())
			return false;

		if(!$this['from_email'])
			return false;
		
		//GUESS CUSTOMER
		if($customer = $this->customer($this['from_email'])){
			$this['from'] = "Customer";
			$this['from_id'] = $customer['id'];
		}elseif($supplier = $this->supplier($this['from_email'])){
			//guess Supplier
			$this['from'] = "Supplier";
			$this['from_id'] = $supplier['id'];
		}elseif($afiliate = $this->afiliate($this['from_email'])){
			$this['from'] = "Affiliate";
			$this['from_id'] = $afiliate['id'];
		}elseif($emp = $this->employee($this['from_email'])){
			$this['from'] = "Employee";
			$this['from_id'] = $emp['id'];
		}
		
		$this->save();
	}

	function fromMemberName(){
		
		if(!$this->loaded()) return;
		return $this['from_detail'];
	}

	function toMemberName(){
		
		if(!$this->loaded()) return;
		switch ($this['to']) {
			case 'Customer':
				$c = $this->add('xShop/Model_Customer')->addCondition('id',$this['to_id'])->tryLoadAny();
				if($c->loaded())					
					return $c['customer_name'];
			break;			
			case 'Supplier':
				$s = $this->add('xPurchase/Model_Supplier')->addCondition('id',$this['to_id'])->tryLoadAny();
				if($s->loaded())
					return $s['name'];
			break;
			case 'Employee':
				$e = $this->add('xHR/Model_Employee')->addCondition('id',$this['to_id'])->tryLoadAny();
				if($e->loaded())
					return $e['name'];
			break;
			case 'Affiliate':
				$a = $this->add('xShop/Model_Affiliate')->addCondition('id',$this['to_id'])->tryLoadAny();
				if($a->loaded())
					return $a['name'];
			break;
		}
	}
	
	function guessTo(){
		if(!$this->loaded())
			return false;

		if(!$to_email = $this['to_email'])
			return false;

		$to_email = $to_email.",".$this['cc'].",".$this['bcc'];

		//GUESS CUSTOMER
		if( ($customer = $this->customer($to_email) )AND $this['from']!='Customer'){
			$this['to'] = "Customer";
			$this['to_id'] = $customer['id'];
		}elseif( ($supplier = $this->supplier($to_email)) AND $this['from']!='Supplier'){
			//guess Supplier
			$this['to'] = "Supplier";
			$this['to_id'] = $supplier['id'];
		}elseif( ($afiliate = $this->afiliate($to_email))  AND $this['from']!='Affiliate'){
			$this['to'] = "Affiliate";
			$this['to_id'] = $afiliate['id'];
		}elseif( ($emp = $this->employee($to_email))  AND $this['from']!='Employee'){
			$this['to'] = "Employee";
			$this['to_id'] = $emp['id'];
		}
		
		$this->save();
	}

	function hasDocument(){
		preg_match_all('/([a-zA-Z]+[\\\\][a-zA-Z]+[ ]+[0-9]+)/',$this['subject'],$preg_match_array);
		// throw new \Exception($this['subject'].  var_dump($preg_match_array[1][0]), 1);
		if(!count($preg_match_array[1])) return false;
		

		//Guess Ticket
		$relatedDocument = $preg_match_array[1][0];
		$document_array_all = explode(" ", $relatedDocument);
		$document_array = explode("\\", $document_array_all[0]);

		$document = $this->add($document_array[0].'\Model_'.$document_array[1]);
		$document->tryLoadBy('name',$document_array_all[1]);

		if($document->loaded())
			return $document;

		return false;
	}

	function guessDocumentAndCreateActivityOrTicket(){
		if(!$this['subject'])
			return false;

		//get ticket no from subject
		preg_match_all('/([a-zA-Z]+[\\\\][a-zA-Z]+[ ]+[0-9]+)/',$this['subject'],$preg_match_array);
		// throw new \Exception($this['subject'].  var_dump($preg_match_array[1][0]), 1);
		if(count($preg_match_array[1])){
			//Guess Ticket
			$relatedDocument = $preg_match_array[1][0];
			$document_array_all = explode(" ", $relatedDocument);
			$document_array = explode("\\", $document_array_all[0]);

			$document = $this->add($document_array[0].'\Model_'.$document_array[1]);
			$document->tryLoadBy('name',$document_array_all[1]);
		}else{
			$document = $this->loadFrom();
			if(!$document) return;
		}
		



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

	function customer($email){

		if(!is_array($email)){
			$email = explode(",", $email);
		}

		$cstmr = $this->add('xShop/Model_Customer');

		$or = $cstmr->dsql()->orExpr();
		foreach ($email as $em) {
			$em=trim($em);
			if(!$em or $em=='') continue;
			$or->where('email','like','%'.$em.'%');
			$or->where('other_emails','like','%'.$em.'%');
		}
		
		$cstmr->addCondition($or);

		if($cstmr->count()->getOne() > 1)
			return false;

		$cstmr->tryLoadAny();
		if($cstmr->loaded())
			return $cstmr;

		return false;
	}

	function supplier($email){
		if(!is_array($email)){
			$email = explode(",", $email);
		}

		$supplr = $this->add('xPurchase/Model_Supplier');
		
		$or = $supplr->dsql()->orExpr();
		foreach ($email as $em) {
			$em=trim($em);
			if(!$em or $em=='') continue;
			$or->where('email','like','%'.$em.'%');
		}

		$supplr->addCondition($or);

		if($supplr->count()->getOne() > 1)
			return false;

		$supplr->tryLoadAny();
		if($supplr->loaded())
			return $supplr;

		return false;
	}

	function afiliate($email){
		if(!is_array($email)){
			$email = explode(",", $email);
		}

		$afiliate = $this->add('xShop/Model_Affiliate');
		
		$or = $afiliate->dsql()->orExpr();
		foreach ($email as $em) {
			$em=trim($em);
			if(!$em or $em=='') continue;
			$or->where('email_id','like','%'.$em.'%');
		}
				
		$afiliate->addCondition($or);
		
		if($afiliate->count()->getOne() > 1)
			return false;

		$afiliate->tryLoadAny();
		if($afiliate->loaded())
			return $afiliate;

		return false;
	}

	function employee($email){
		if(!is_array($email)){
			$email = explode(",", $email);
		}

		$emp = $this->add('xHR/Model_Employee');
		
		$or = $emp->dsql()->orExpr();
		foreach ($email as $em) {
			$em=trim($em);
			if(!$em or $em=='') continue;
			$or->where('personal_email','like','%'.$em.'%');
		}
		
		$emp->addCondition($or);
		
		if($emp->count()->getOne() > 1)
			return false;

		$emp->tryLoadAny();
		if($emp->loaded())
			return $emp;

		return false;
	}


	function loadDepartmentEmails($dept_id=null, $include_support_emails=false){
		if(!$dept_id)
			$dept_id = $this->api->stickyGET('department_id');
		
		$official_emails = $this->add('xHR/Model_OfficialEmail');
		$official_emails->addCondition('department_id',$dept_id);
		
		if(!$include_support_emails)
			$official_emails->addCondition('is_support_email',false);

		if(!$official_emails->count()->getOne())
			return false;
		
		$or_cond = $this->dsql()->orExpr();


		$official_email_array = array();
		foreach ($official_emails as $official_email) {
			$official_email_array[] = $official_email['email_username'];
			$official_email_array[] = $official_email['imap_email_username'];
			
			$or_cond->where('cc','like','%'.$official_email['email_username'].'%');
			$or_cond->where('cc','like','%'.$official_email['imap_email_username'].'%');
			$or_cond->where('from_email','like','%'.$official_email['email_username'].'%');
			$or_cond->where('from_email','like','%'.$official_email['imap_email_username'].'%');
			$or_cond->where('to_email','like','%'.$official_email['email_username'].'%');
			$or_cond->where('to_email','like','%'.$official_email['imap_email_username'].'%');
		}



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

	function setFrom($from_id,$from,$from_name=null){

		$this['from_id'] = $from_id;
		$this['from'] = $from;
		$this['from_name'] = $from_name;
		$this->save();
		return $this;
	}

	function setTo($to_id,$to){
		$this['to_id'] = $to_id;
		$this['to'] = $to;
		$this->save();

		return $this;
	}

	function loadFrom(){
		if(!$this->loaded()) return false;

		switch ($this['from']) {
				case 'Customer':
					return $this->add('xShop/Model_Customer')->load($this['from_id']);
				break;

				case 'Employee';
					return $this->add('xHR/Model_Employee')->load($this['from_id']);
				break;

				case 'Lead';
					return $this->add('xMarketingCampaign/Model_Lead')->load($this['from_id']);
				break;

				case 'Supplier';
						return $this->add('xPurchase/Model_Supplier')->load($this['from_id']);
				break;

				case 'Affiliate';
					return $this->add('xShop/Model_Affiliate')->load($this['from_id']);
				break;
			}

			return false;
	}

	function loadTo(){
		if(!$this->loaded()) return false;


		switch ($this['from']) {
				case 'Customer':
					return $this->add('xShop/Model_Customer')->load($this['from_id']);
				break;

				case 'Employee';
					return $this->add('xHR/Model_Employee')->load($this['from_id']);
				break;

				case 'Lead';
					return $this->add('xMarketingCampaign/Model_Lead')->load($this['from_id']);
				break;

				case 'Supplier';
						return $this->add('xPurchase/Model_Supplier')->load($this['from_id']);
				break;

				case 'Affiliate';
					return $this->add('xShop/Model_Affiliate')->load($this['from_id']);
				break;
		}
	}

	function updateFromEmail(){
		switch ($this['from']) {
				case 'Customer':
					$this->add('xShop/Model_Customer')->load($this['from_id'])->updateEmail($this['from_email']);
				break;

				case 'Employee';
					$this->add('xHR/Model_Employee')->load($this['from_id'])->updateEmail($this['from_email']);
				break;

				case 'Lead';
					$this->add('xMarketingCampaign/Model_Lead')->load($this['from_id'])->updateEmail($this['from_email']);
				break;

				case 'Supplier';
					$this->add('xPurchase/Model_Supplier')->load($this['from_id'])->updateEmail($this['from_email']);
				break;

				case 'Affiliate';
					$this->add('xShop/Model_Affiliate')->load($this['from_id'])->updateEmail($this['from_email']);
				break;
			}
	}

	function updateToEmail(){
		switch ($this['to']) {
				case 'Customer':
					$this->add('xShop/Model_Customer')->load($this['to_id'])->updateEmail($this['to_email']);
				break;

				case 'Employee';
					$this->add('xHR/Model_Employee')->load($this['to_id'])->updateEmail($this['to_email']);
				break;

				case 'Lead';
					$this->add('xMarketingCampaign/Model_Lead')->load($this['to_id'])->updateEmail($this['to_email']);
				break;

				case 'Supplier';
					$this->add('xPurchase/Model_Supplier')->load($this['to_id'])->updateEmail($this['to_email']);
				break;

				case 'Affiliate';
					$this->add('xShop/Model_Affiliate')->load($this['to_id'])->updateEmail($this['to_email']);
				break;
			}
	}

	function loadOfficialEmail($according="to"){
		if(!$this->loaded()) return false;
		
		if($according=="to")
			$email = explode(',', $this['to_email'].','.$this['cc'].','.$this['bcc']);

		if($according=="from")
			$email = explode(',', $this['to_email'].','.$this['cc'].','.$this['bcc']);

		$off_emails = $this->add('xHR/Model_OfficialEmail');
		$or = $off_emails->dsql()->orExpr();
		foreach ($email as $em) {
			$em=trim($em);
			if(!$em or $em=='') continue;
			$or->where('imap_email_username','like','%'.$em.'%');
		}
		
		$off_emails->addCondition($or);

		$off_emails->tryLoadAny();
		if($off_emails->loaded())
			return $off_emails;

		return false;
	}

}