<?php
namespace xStore;
class Model_MaterialRequestSent_Draft extends Model_MaterialRequestSent{
	// public $actions=array(
	// 	'document_id'=>'',
	// 	'allow_add'=>'allow_add',
	// 	'allow_edit'=>'allow_edit',
	// 	'can_submit'=>array('caption'=>'Can Submit and Approve')
	// 	);

	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	