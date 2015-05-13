<?php

class Model_Attachment extends \Model_Document{
	
	public $table="attachments";
	public $status = array();
	public $attachment_name=null;
	public $root_document_name=null;
	public $is_view=true;

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->addField('name');
		$this->add('filestore/Field_File','attachment_url_id')->mandatory(true);

		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');

	}

	function beforeSave(){
		if(!$this['name']){
			$file_model = $this->add('filestore/Model_File')->tryLoad($this['attachment_url_id']);
			if($file_model->loaded())
				$this['name'] = $file_model['original_filename'];
		}

	}

	function beforeDelete(){
		$this->ref('attachment_url_id')->tryDelete();
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