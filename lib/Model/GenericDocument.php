<?php

class Model_GenericDocument extends Model_Document {
	public $table='xepan_generic_documents';

	public $root_document_name = "\GenericDocument";
	public $status=array('draft','submitted','inactive');

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

		$this->hasMany('GenericDocumentAttahcment','related_document_id',null,'Attachments');
	}
}