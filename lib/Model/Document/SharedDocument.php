<?php

class Model_Document_SharedDocument extends Model_GenericDocument {
	public $actions=array(
		'allow_add'=>array(),
		'allow_edit'=>array(),
		'allow_del'=>array()
		);

	function init(){
		parent::init();
		$share_j= $this->join('xepan_generic_documents_share.document_id');
		$share_j->addField('employee_id');
		$share_j->addField('share_mode')->system(true);

		$this->addCondition('employee_id',@$this->api->current_employee->id);		
	}
}