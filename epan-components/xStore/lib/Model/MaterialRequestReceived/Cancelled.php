<?php
namespace xStore;
class Model_MaterialRequestReceived_Cancelled extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','cancelled');
	}
}	