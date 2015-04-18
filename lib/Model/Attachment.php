<?php

class Model_Attachment extends \Model_Document{
	
	public $table="attachments";
	public $status = array();
	public $attachment_name=null;
	public $root_document_name=null;

	function init(){
		parent::init();

		// $this->hasOne('xCRM/Activity','activity_id');
		$this->addField('name');
		$this->add('filestore/Field_File','attachment_url_id')->mandatory(true);

		$this->addHook('beforeSave',$this);
		$this->add('dynamic_model/Controller_AutoCreator');

	}

	function beforeSave(){
		if(!$this['name']){
			$file_model = $this->add('filestore/Model_File')->tryLoad($this['attachment_url_id']);
			if($file_model->loaded())
				$this['name'] = $file_model['original_filename'];
		}

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