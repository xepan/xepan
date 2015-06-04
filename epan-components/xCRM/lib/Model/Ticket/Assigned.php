<?php
namespace xCRM;
class Model_Ticket_Assigned extends Model_Ticket{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_cancel'=>array(),
			'can_assign'=>array(),
			'can_mark_processed'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','assigned');
	}
}	