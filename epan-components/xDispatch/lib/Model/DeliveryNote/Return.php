<?php
namespace xDispatch;
class Model_DeliveryNote_Redesign extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','redesign');
	}
}	