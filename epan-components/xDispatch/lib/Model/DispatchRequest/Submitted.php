<?php

namespace xDispatch;

class Model_DispatchRequest_Submitted extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'can_approve'=>array('icon'=>'thumbs-up'),
			'can_reject'=>array('icon'=>'cancel-circled'),
			'can_see_activities'=>array('icon'=>'cancel-circled'),
		);
	function init(){
		parent::init();

		$this->addCondition('status','submitted');

	}
}