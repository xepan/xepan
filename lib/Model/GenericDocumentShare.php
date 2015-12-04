<?php


class Model_GenericDocumentShare extends Model_Table{
	public $table = "xepan_generic_documents_share";

	function init(){
		parent::init();
		$this->hasOne('GenericDocument','document_id')->mandatory(true);
		$this->hasOne('xHR/Employee','employee_id')->mandatory(true);

		$this->addField('share_mode')->setValueList(['view-only','allow-edit'])->defaultValue('view-only');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}