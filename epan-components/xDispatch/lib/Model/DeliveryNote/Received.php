<?php
namespace xDispatch;
class Model_DeliveryNote_Received extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','received');
	}
}	