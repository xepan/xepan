<?php
namespace xStore;
class Model_MaterialRequestSent_Submit extends Model_MaterialRequestSent{
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	