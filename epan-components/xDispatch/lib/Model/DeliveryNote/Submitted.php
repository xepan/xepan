<?php
namespace xDispatch;
class Model_DeliveryNote_Submitted extends Model_DeliveryNote{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(submit) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Jobcard(submit) this post can edit'),
			'can_approve'=>array('caption'=>'Can this post approve Jobcard(submit)'),
			'can_reject'=>array('icon'=>'cancel-circled'),
		);
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	