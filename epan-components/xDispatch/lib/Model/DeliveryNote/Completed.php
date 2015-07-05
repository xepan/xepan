<?php
namespace xDispatch;
class Model_DeliveryNote_Completed extends Model_DeliveryNote{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','Completed');
	}
}	