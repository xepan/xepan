<?php

namespace xCRM;

class Model_EmailAttachment extends \Model_Attachment{
	public $root_document_name = "xCRM\EmailAttachment";

	function init(){
		parent::init();
		
		$this->addCondition('related_root_document_name','xCRM\Email');
	}
}