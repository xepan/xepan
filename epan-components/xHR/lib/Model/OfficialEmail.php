<?php

namespace xHR;
class Model_OfficialEmail extends \Model_Document{
	public $table="xhr_official_emails";
	public $status=array('active','deactive');
	public $root_document_name = "xHR\OfficialEmail";
	public $title_field="email_username";
	public $actions=array(
			'can_view'=>array(),
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_see_activities'=>false,
			'can_manage_attachments'=>false
		);
	
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xHR/Department','department_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'));
		$this->hasOne('xHR/Employee','employee_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'));
		

		$this->addField('email_transport')->setValueList(array('SmtpTransport'=>'SMTP Transport','SendmailTransport'=>'SendMail','MailTransport'=>'PHP Mail function'))->defaultValue('smtp')->group('es~6~<i class="fa fa-cog "></i> OutGoing - Email Transporter To Use');
		$this->addField('is_support_email')->type('boolean')->group('es~6')->hint('To see the changes save and edit again')->defaultValue(false);
		
		$this->addField('encryption')->enum(array('none','ssl','tls'))->mandatory(true)->group('ecs~1~<i class="glyphicon glyphicon-link "></i>OutGoing - Connection Settings');
		$this->addField('email_host')->group('ecs~4');
		$this->addField('email_port')->group('ecs~1');
		$this->addField('email_username')->group('ecs~3');
		$this->addField('email_password')->type('password')->group('ecs~3');

		$this->addField('from_email')->group('from~2~Email From Sender Settings');
		$this->addField('from_name')->group('from~2');
		$this->addField('sender_email')->group('from~2');
		$this->addField('sender_name')->group('from~2');
		$this->addField('email_reply_to')->group('from~2');
		$this->addField('return_path')->group('from~2');

		$this->addField('imap_email_host')->group('pop~3~<i class="glyphicon glyphicon-link "></i>IMAP/POP3 Settings')->caption('Host');
		$this->addField('imap_email_port')->group('pop~1')->caption('Port');
		$this->addField('imap_email_username')->group('pop~1')->caption('Username');
		$this->addField('imap_email_password')->type('password')->group('pop~1')->caption('Password');
		$this->addField('imap_flags')->mandatory(true)->defaultValue('/imap/ssl/novalidate-cert')->group('pop~6')->caption('Flags');



		$this->addField('auto_reply')->type('boolean')->group('ar~4~Auto Reply');
		$this->addField('email_subject')->group('ar~12')->hint('{{customer_name}}');
		$this->addField('email_body')->type('text')->display(array('form'=>'RichText'))->group('ar~12')->hint('{{ticket_number}},{{status}},{{priority}},{{customer_name}},{{created_date}},{{from_name}},{{from_email}}');

		$this->addField('denied_email_subject')->group('ar~12')->hint('{{from_name}}, {{from_email}}');
		$this->addField('denied_email_body')->type('text')->display(array('form'=>'RichText'))->group('ar~12')->hint('{{from_name}},{{from_email}}');

		$this->addField('footer')->type('text')->display(array('form'=>'RichText'))->group('e~12~Email Footer');
		
		// $this->addExpression('name')->set(function(){});
		// $this->addHook('beforeDelete',$this);
		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){}
	
	// function forceDelete(){
	// 	$this->delete();
	// }

	function department(){
		return $this->ref('department_id');
	}
	

	function supportEmails(){
		return $this->addCondition('is_support_email',true)->addCondition('status','active')->tryLoadAny();
	}

}