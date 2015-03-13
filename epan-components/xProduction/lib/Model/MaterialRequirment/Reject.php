<?php

namespace xProduction;

class Model_MaterialRequirment_Reject extends Model_MaterialRequirment{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see')
		);
	function init(){
		parent::init();

		$this->addCondition('status','reject');
	}

}