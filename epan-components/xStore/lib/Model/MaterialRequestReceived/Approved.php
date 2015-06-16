<?php
namespace xStore;
class Model_MaterialRequestReceived_Approved extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_view'=>array(),
			'can_receive'=>array(),
			'can_cancel'=>array(),
			'can_see_activities'=>array(),

		);
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	