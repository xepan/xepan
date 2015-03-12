<?php
namespace xDispatch;
class Model_DeliveryNote_Processed extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','processed');
	}
}	