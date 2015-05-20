<?php

class Model_GenericDocument extends Model_Document {
	public $root_document_name = "\GenericDocument";
	public $status=array('draft','submitted','inactive');

	function init(){
		parent::init();

		$this->addField('title');
		$this->addField('content')->type('text')->display(array('form'=>'RichText'));

		$this->hasMany('GenericDocumentAttahcment','related_document_id',null,'Attachments');
	}
}