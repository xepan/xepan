<?php

namespace xCRM;

class Model_ActivityAttachment extends \Model_Attachment{
	public $root_document_name = "xCRM\ActivityAttachment";

	function init(){
		parent::init();
		
		$this->addCondition('related_root_document_name','xCRM\Attachment');
	}

	
}