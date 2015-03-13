<?php

namespace xDispatch;

class Model_DispatchRequest_Assigned extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
		);
	function init(){
		parent::init();

		$this->addCondition('status','assigned');

	}
}