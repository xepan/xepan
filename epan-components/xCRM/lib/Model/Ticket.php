<?php
namespace xCRM;

class Model_Ticket extends \Model_Document{
	
	public $status=array('draft','submitted','solved','canceled','assigned','junk');
	public $table="xcrm_tickets";
	public $root_document_name= 'xCRM\Ticket';

	function init(){
		parent::init();
		
 		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

 		$this->hasOne('xShop/Model_Customer','customer_id')->display(array('form'=>'autocomplete/Plus'))->mandatory(true);
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
		$this->addField('message')->type('text')->display(array('form'=>'RichText'));

		$this->addField('priority')->enum(array('Low','Medium','High','Urgent'))->defaultValue('Medium')->mandatory(true);

		$this->addExpression('last_activity_date')->set(function ($m, $q){
			$activity = $m->activities()->setOrder('id','desc')->tryLoadAny();
			return $activity->dsql->fieldQuery('created_at');
		});

		$this->hasMany('xCRM/TicketAttachment','related_document_id',null,'Attachments');
		//$this->add('dynamic_model/Controller_AutoCreator');
		
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
					->addCondition('status','active')
					->addCondition('is_support_email','true');

		return $off_email->tryLoadAny();
	}

	function autoReply(){
		if(!$this->loaded()){
			return false;	
		}

		if($this->supportEmail()->count()->getOne()){
			$support_email = $this->supportEmail();
			if(!$support_email['auto_reply']) return false;
			
			if(!$this['from_email'])
				return false;

			$ticket_number = "[".$this->root_document_name." ".$this['name']."]";
			$footer = $support_email['footer'];

//AUTO REPLY OF CREATE TICKET ONLY IF FROM EMAIL IS OUR CUSTOMER OR MEMBER------------------------ 
			if( in_array($this['from'], array("Customer","Member")) ){

				$subject = $ticket_number." ".$support_email['email_subject']?:"Ticket Created";
				$subject = str_replace("{{customer_name}}", $this['customer'], $subject);
				// $subject = str_replace("{{ticket_number}}", $this['name'], $subject);
				
				$email_body = $support_email['email_body'];

				$email_body = str_replace("{{ticket_number}}", $ticket_number, $email_body);
				$email_body = str_replace("{{status}}", $this['status'], $email_body);
				$email_body = str_replace("{{priority}}", $this['priority'], $email_body);
				$email_body = str_replace("{{customer_name}}", $this['customer']?$this['customer']:" ", $email_body);
				$email_body = str_replace("{{created_date}}", $this['created_date'], $email_body);
				$email_body = str_replace("{{from_name}}", $this['from_name']?$this['customer']:" ", $email_body);
				$email_body = str_replace("{{from_email}}", $this['from_email']?$this['customer']:" ", $email_body);

			}else{//REPLY NOT REGISTERED USER----------------------------------- 
				$subject = $support_email['denied_email_subject'];
				$subject = str_replace("{{from_name}}", $this['from_name'], $subject);
				$subject = str_replace("{{from_email}}", $this['from_email'], $subject);

				$email_body = $support_email['denied_email_body'];
				$email_body = str_replace("{{from_name}}", $this['from_name'], $email_body);
				$email_body = str_replace("{{from_email}}", $this['from_email'], $email_body);
				
				$this['status'] = 'junk';
				$this->save();
			}
			
			$email_body = $email_body .'<br/>'.$footer;
			$this->sendEmail($this['from_email'],$subject,$email_body,explode(",",trim($this['cc'])),explode(",",trim($this['bcc'])),array(),$support_email);
			
			$email_to = $this['from_email'].','.$this['cc'].$this['bcc'];
			$new_activity = $this->createActivity('email',$subject,$email_body,$this['from'],$this['from_id'], $this['to'], $this['to_id'],$email_to);
		}
	}

	function customer($to="from"){
		$email = $this['from_email'];
		if($to == "to")
			$email = $this['to_email'];

		$cstmr = $this->add('xShop/Model_Customer');
		$cstmr->addCondition('customer_email','like','%'.$email.'%');
		
		if($cstmr->count()->getOne() > 1)
			return false;

		$cstmr->tryLoadAny();
		if($cstmr->loaded())
			return $cstmr;

		return false;
	}

	function submit(){//Open Ticket
		
		$current_id = $this->id;
		$customer = $this->ref('customer_id');

		$this['from'] = 'Customer';
		$this['from_id'] = $this['customer_id'];
		$this['from_name'] = $customer['customer_name'];

		$this['to_email'] = $this->api->current_department->supportEmails()->get('imap_email_username');
		$this->save();

		$this->setStatus('submitted');
		
		$t = $this->add('xCRM/Model_Ticket')->load($current_id);
		$t->autoReply();	
		return true;
	}


	function cancel(){
		$this->setStatus('canceled');
		return true;
	}

	function assign(){
		$this->setStatus('assigned');
		return;
	}

	function mark_processed(){//Solved
		//Send Email for Ticket Close;
		
		$this->setStatus('solved');
		return;	
	}


	function createActivity($action,$subject,$message,$from=null,$from_id=null, $to=null, $to_id=null,$email_to=null,$notify_via_email=false, $notify_via_sms=false){
		if($this['status'] == 'solved'){
			$this['status']='submitted';
			$this->save();
		}
		parent::createActivity($action,$subject,$message,$from=null,$from_id=null, $to=null, $to_id=null,$email_to=null,$notify_via_email=false, $notify_via_sms=false);
	}

	function attachment(){
		return $this->ref('Attachments')->addCondition('related_document_id',$this->id);
	}

}
