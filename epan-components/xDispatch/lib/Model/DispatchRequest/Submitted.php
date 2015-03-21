<?php

namespace xDispatch;

class Model_DispatchRequest_Submitted extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(submit) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Jobcard(submit) this post can edit'),
			'can_approve'=>array('icon'=>'thumbs-up'),
			'can_reject'=>array('icon'=>'cancel-circled'),
		);
	function init(){
		parent::init();

		$this->addCondition('status','submitted');

	}
}