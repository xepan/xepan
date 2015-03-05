<?php
namespace xStore;
class Model_MaterialRequestSent_Approved extends Model_MaterialRequestSent{
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	