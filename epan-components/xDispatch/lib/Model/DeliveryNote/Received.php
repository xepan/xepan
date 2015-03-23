<?php
namespace xDispatch;
class Model_DeliveryNote_Received extends Model_DeliveryNote{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'can_assign'=>array(),
			'can_assign_to'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','received');
	}
}	