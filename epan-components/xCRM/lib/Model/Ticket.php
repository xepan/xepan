<?php
namespace xCRM;

class Model_Ticket extends \Model_Document{
	
	public $status=array('draft','submitted','solved','canceled','assigned');
	public $table="xcrm_tickets";
	public $root_document_name= 'xCRM\Ticket';

	function init(){
		parent::init();
		
 		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

 		$this->hasOne('xShop/Model_Customer','customer_id');
 		$this->hasOne('xShop/Model_Order','order_id');
		
		$this->addField('name');
		$this->addField('uid');
		$this->addField('from'); // Customer, Employee, Supplier ... string
		$this->addField('from_id');
		$this->addField('from_email');
		$this->addField('from_name');

		$this->addField('to');
		$this->addField('to_id');
		$this->addField('to_email');

		$this->addField('cc')->type('text');
		$this->addField('bcc')->type('text');

		$this->addField('subject');
		$this->addField('message')->type('text');

		$this->addField('priority')->enum(array('Low','Medium','High','Urgent'))->defaultValue('Medium');

		$this->hasMany('xCRM/TicketAttachment','related_document_id',null,'Attachments');
		$this->addHook('beforeSave',$this);
		//$this->add('dynamic_model/Controller_AutoCreator');	
		
	}

	function beforeSave(){
		$this['name'] = "[".$this->root_document_name." ".$this['name']."]";
	}

	function addAttachment($attach_id,$name=null){
		if(!$attach_id) return;
		$attach = $this->add('xCRM/Model_TicketAttachment');
		$attach['attachment_url_id'] = $attach_id;
		$attach['related_document_id'] = $this->id;
		if($name)
			$attach['name'] = $name;

		$attach->save();

		return $attach;
	}
	
	function supportEmail(){
		$off_email = $this->add('xHR/Model_OfficialEmail');
		$off_email->addCondition('imap_email_username',$this['to_email'])
					->addCondition('status','active');
		return $off_email->tryLoadAny();
	}

	function autoReply(){
		if(!$this->loaded()) return false;

		if($this->supportEmail()->count()->getOne()){
			$support_email = $this->supportEmail();
			if(!$support_email['auto_reply']) return false;
			
			if(!$this['from_email'])
				return false;

			$subject = $this['name']." ".$support_email['email_subject']?:"Ticket Created";
			$subject = str_replace("{{customer_name}}", $this['customer'], $subject);
			// $subject = str_replace("{{ticket_number}}", $this['name'], $subject);
			
			$email_body = $support_email['email_body'];
			$footer = $support_email['footer'];

			$email_body = str_replace("{{ticket_number}}", $this['name'], $email_body);
			$email_body = str_replace("{{status}}", $this['status'], $email_body);
			$email_body = str_replace("{{priority}}", $this['priority'], $email_body);
			$email_body = str_replace("{{customer_name}}", $this['customer']?$this['customer']:" ", $email_body);
			$email_body = str_replace("{{created_date}}", $this['created_date'], $email_body);

			$email_body = $email_body .'<br/>'.$footer;
			 
			$this->sendEmail($this['from_email'],$subject,$email_body,$this['cc'],$this['bcc']);
				
			$email_to = $this['from_email'].','.$this['cc'].$this['bcc'];
			$new_activity = $this->createActivity('Email',$subject,$email_body,$this['from'],$this['from_id'], $this['to'], $this['to_id'],$email_to);
		}
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
}
