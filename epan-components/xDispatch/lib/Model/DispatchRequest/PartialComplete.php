<?php

namespace xDispatch;

class Model_DispatchRequest_PartialComplete extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('item_under_process','>=',1);
		$this->addCondition('pending_items_to_deliver',0);


	}
}