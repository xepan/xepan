<?php


class Model_GenericDocumentAttahcment extends \Model_Attachment{
	public $root_document_name = "\GenericDocumentAttahcment";

	function init(){
		parent::init();
		
		$this->addCondition('related_root_document_name','\GenericDocument');
	}

	
}