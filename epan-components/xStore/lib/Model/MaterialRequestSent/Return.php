<?php
namespace xStore;
class Model_MaterialRequestSent_Return extends Model_MaterialRequestSent{
	function init(){
		parent::init();
		$this->addCondition('status','return');
	}
}	