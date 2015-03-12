<?php
namespace xDispatch;
class Model_DeliveryNote_Cancel extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','cancel');
	}
}	