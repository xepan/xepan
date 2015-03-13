<?php

namespace xProduction;

class Model_MaterialRequirment_Approved extends Model_MaterialRequirment{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(approve) this post can see'),
			'can_receive'=>array('caption'=>'Can this post receive Jobcard(approve)'),

		);
	function init(){
		parent::init();

		$this->addCondition('status','approved');
	}

}