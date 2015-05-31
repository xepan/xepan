<?php

class Model_GenericDocument extends Model_Document {
	public $table='xepan_generic_documents';

	public $root_document_name = "\GenericDocument";
	public $status=array('public','departmental','shared','private');

	public $actions=array(
		'allow_add'=>array(),
		'allow_edit'=>array(),
		'allow_del'=>array(),
		'can_start_processing'=>array('caption'=>'Create New')
		);

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('Model_GenericDocumentCategory','generic_doc_category_id')->mandatory(true);

		$this->addField('name')->mandatory(true);
		$this->addField('content')->type('text')->display(array('form'=>'RichText'));
		$this->addField('is_template')->type('boolean')->defaultValue(false);

		$this->hasMany('GenericDocumentAttachment','related_document_id',null,'Attachments');
	
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function attechmentImages(){
		return	$this->add('Model_GenericDocumentAttachment')->addCondition('related_document_id',$this->id);
	}

	function start_processing(){

	}
}