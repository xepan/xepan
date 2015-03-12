<?php
namespace xDispatch;
class Model_DeliveryNote_Cancelled extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','cancelled');

	}
}	