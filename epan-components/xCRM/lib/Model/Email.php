<?php

namespace xCRM;

class Model_Email extends \Model_Document{
	public $table = 'xcrm_emails';
	public $status = array();
	public $root_document_name='xCRM\Email';

	function init(){
		parent::init();

		$this->addField('from');
		$this->addField('from_id');

		$this->addField('to');
		$this->addField('to_id');

		$this->addField('subject');
		$this->addField('message')->type('text');

		$this->hasMany('xCRM/EmailAttachment','related_document_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}
}