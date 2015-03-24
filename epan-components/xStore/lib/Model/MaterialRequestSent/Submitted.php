<?php
namespace xStore;
class Model_MaterialRequestSent_Submitted extends Model_MaterialRequestSent{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'can_approve'=>array(),
			'can_reject'=>array('icon'=>'cancel-circled'),
		);
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	