<?php

namespace xCRM;

class Model_TicketAttachment extends \Model_Attachment{
	public $root_document_name = "xCRM\TicketAttachment";

	function init(){
		parent::init();
		
		$this->addCondition('related_root_document_name','xCRM\Ticket');
	}

	
}