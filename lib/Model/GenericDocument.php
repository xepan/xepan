<?php

class Model_GenericDocument extends Model_Document {
	public $table='xepan_generic_documents';

	public $root_document_name = "\GenericDocument";
	public $status=array('public','departmental','shared','private');

	public $actions=array(
		'allow_add'=>array(),
		'allow_edit'=>array(),
		'allow_del'=>array()
		);

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->addField('title');
		$this->addField('content')->type('text')->display(array('form'=>'RichText'));

		$this->hasMany('GenericDocumentAttachment','related_document_id',null,'Attachments');
	}

	function attechmentImages(){
		return	$this->add('Model_GenericDocumentAttachment')->addCondition('related_document_id',$this->id);
	}
}