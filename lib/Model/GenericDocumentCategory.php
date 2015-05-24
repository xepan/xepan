<?php

class Model_GenericDocumentCategory extends \Model_Document {
	public $table= "xepan_generic_documents_category";

	public $status=array('public','departmental','shared','private');
	public $root_document_name = '\GenericDocumentCategory';

	function init(){
		parent::init();

		$this->addField('name'); // Already defined in model_document

		$this->hasMany('GenericDocument','generic_doc_category_id');

		// $this->add('dynamic_model/Controller_AutoCreator');
	}
}