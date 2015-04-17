<?php
namespace xProduction;
class Model_Task_Processing extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
			// 'can_reject'=>array(),
			'can_mark_processed'=>array('icon'=>'ok'),
		);
	function init(){
		parent::init();

		$this->addCondition('status','processing');
	}
}