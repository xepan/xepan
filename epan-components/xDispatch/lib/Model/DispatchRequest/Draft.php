<?php

namespace xDispatch;

class Model_DispatchRequest_Draft extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_submit'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','draft');

	}
}