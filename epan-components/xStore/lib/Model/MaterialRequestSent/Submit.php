<?php
namespace xStore;
class Model_MaterialRequestSent_Submit extends Model_MaterialRequestSent{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(submit) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Jobcard(submit) this post can edit'),
			'can_approve'=>array('caption'=>'Can this post approve Jobcard(submit)'),
			'can_reject'=>array('caption'=>'Whose created Jobcard(submit) this post can reject'),
		);
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	