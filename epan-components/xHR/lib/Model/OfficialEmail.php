<?php

namespace xHR;
class Model_OfficialEmail extends \Model_Document{
	public $table="xhr_official_emails";
	public $status=array('active','deactive');
	public $root_document_name = "xHR\OfficialEmail";
	public $actions=array(
			'can_view'=>array(),
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
		);	
	function init(){
		parent::init();
		$this->hasOne('xHR/Department','department_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'));
		$this->hasOne('xHR/Employee','employee_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'));

		$this->addField('email_transport')->setValueList(array('SmtpTransport'=>'SMTP Transport','SendmailTransport'=>'SendMail','MailTransport'=>'PHP Mail function'))->defaultValue('smtp')->group('es~6~<i class="fa fa-cog "></i> OutGoing - Email Transporter To Use');
		$this->addField('encryption')->enum(array('none','ssl','tls'))->mandatory(true)->group('ecs~1~<i class="glyphicon glyphicon-link "></i>OutGoing - Connection Settings');
		$this->addField('email_host')->group('ecs~4');
		$this->addField('email_port')->group('ecs~1');
		$this->addField('email_username')->group('ecs~3');
		$this->addField('email_password')->type('password')->group('ecs~3');

		$this->addField('imap_email_host')->group('pop~3~<i class="glyphicon glyphicon-link "></i>IMAP/POP3 Settings')->caption('Host');
		$this->addField('imap_email_port')->group('pop~1')->caption('Port');
		$this->addField('imap_email_username')->group('pop~1')->caption('Username');
		$this->addField('imap_email_password')->type('password')->group('pop~1')->caption('Password');
		$this->addField('imap_flags')->mandatory(true)->defaultValue('/imap/ssl/novalidate-cert')->group('pop~6')->caption('Flags');

		//$this->add('dynamic_model/Controller_AutoCreator');

	}
}