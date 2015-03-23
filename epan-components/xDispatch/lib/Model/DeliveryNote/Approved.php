<?php
namespace xDispatch;
class Model_DeliveryNote_Approved extends Model_DeliveryNote{
	public $actions=array(
			'can_view'=>array(),
			'can_receive'=>array(),

		);
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	