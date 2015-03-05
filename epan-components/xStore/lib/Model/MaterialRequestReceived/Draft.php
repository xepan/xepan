<?php
namespace xStore;
class Model_MaterialRequestReceived_Draft extends Model_MaterialRequestReceived{
	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	