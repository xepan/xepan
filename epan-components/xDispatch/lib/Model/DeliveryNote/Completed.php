<?php
namespace xDispatch;
class Model_DeliveryNote_Completed extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','Completed');
	}
}	