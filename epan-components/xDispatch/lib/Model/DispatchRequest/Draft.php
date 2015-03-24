<?php

namespace xDispatch;

class Model_DispatchRequest_Draft extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Jobcard this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Jobcard'),
			'allow_del'=>array('caption'=>'Whose Created Jobcard this post can delete'),
			'can_submit'=>array('caption'=>'Whose Created Jobcard this post can submit'),
		);
	function init(){
		parent::init();

		$this->addCondition('status','draft');
		//Get All Orders with checking it's orderitem status is completed and it's next department is Dispatch/Delivery
		
	}
}