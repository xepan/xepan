<?php
namespace xProduction;

class Model_Task_Assigned extends Model_Task{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
			'can_start_processing'=>array('caption'=>'Whose Created  this post can Processing')
		);
	function init(){
		parent::init();

		$this->addCondition('status','assigned');
	}
}