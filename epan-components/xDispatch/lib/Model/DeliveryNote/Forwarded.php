<?php
namespace xDispatch;
class Model_DeliveryNote_Forwarded extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','forwarded');
	}
}	