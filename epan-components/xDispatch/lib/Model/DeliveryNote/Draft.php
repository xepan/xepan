<?php
namespace xDispatch;
class Model_DeliveryNote_Draft extends Model_DeliveryNote{
	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	