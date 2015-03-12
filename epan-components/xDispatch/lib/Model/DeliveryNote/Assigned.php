<?php
namespace xDispatch;
class Model_DeliveryNote_Assigned extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','assigned');
	}
}	