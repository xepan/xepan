<?php
namespace xDispatch;
class Model_DeliveryNote_Approved extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	