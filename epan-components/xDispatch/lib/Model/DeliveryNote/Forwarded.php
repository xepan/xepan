<?php
namespace xDispatch;
class Model_DeliveryNote_Forwarded extends Model_DeliveryNote{
	public $actions=array(
			'can_view'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','forwarded');
	}
}	