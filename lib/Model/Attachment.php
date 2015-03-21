<?php

class Model_Attachment extends Model_Document{
	
	public $table="attachments";
	public $status = array();
	public $attachment_name=null;
	public $root_document_name=null;

	function init(){
		parent::init();

		$this->addField('name');
		$this->add('filestore/Field_File','attachment_url_id')->mandatory(true);

		// $this->add('dynamic_model/Controller_AutoCreator');

	}

	function ref($field){
		if($field=='related_document_id'){
			$class = explode("\\", $this['related_root_document_name']);
			$class=$class[0].'/Model_'.$class[1];
			return $this->add($class)->load($this['related_document_id']);
		}else{
			return parent::ref($field);
		}
	}

}