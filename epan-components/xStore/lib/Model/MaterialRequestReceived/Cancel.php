<?php
namespace xStore;
class Model_MaterialRequestReceived_Cancel extends Model_MaterialRequestReceived{
	function init(){
		parent::init();
		$this->addCondition('status','cancel');
	}
}	