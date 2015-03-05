<?php
namespace xStore;
class Model_MaterialRequestReceived_Approved extends Model_MaterialRequestReceived{
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	