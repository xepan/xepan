<?php
namespace xStore;
class Model_MaterialRequestReceived_Draft extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	