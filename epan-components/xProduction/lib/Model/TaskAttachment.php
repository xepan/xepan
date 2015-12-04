<?php

namespace xProduction;

class Model_TaskAttachment extends \Model_Attachment{
	public $root_document_name = "xProduction\TaskAttachment";

	function init(){
		parent::init();
		
		$this->addCondition('related_root_document_name','xProduction\Task');
	}

	
}