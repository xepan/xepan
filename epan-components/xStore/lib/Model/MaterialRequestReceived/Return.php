<?php
namespace xStore;
class Model_MaterialRequestReceived_Return extends Model_MaterialRequestReceived{
	function init(){
		parent::init();
		$this->addCondition('status','return');
	}
}	