<?php
namespace xDispatch;
class Model_DeliveryNote_Submit extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','submit');
	}
}	