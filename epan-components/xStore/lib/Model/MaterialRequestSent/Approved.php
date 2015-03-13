<?php
namespace xStore;
class Model_MaterialRequestSent_Approved extends Model_MaterialRequestSent{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(approve) this post can see'),
			'can_receive'=>array('caption'=>'Can this post receive Jobcard(approve)'),

		);
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	