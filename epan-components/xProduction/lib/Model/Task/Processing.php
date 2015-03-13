<?php
namespace xProduction;
class Model_Task_Processing extends Model_Task{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
			'can_mark_processed'=>array('caption'=>'Whose created Jobcard this post can Mark Processed'),
		);
	function init(){
		parent::init();

		$this->addCondition('status','processing');
	}
}