<?php
namespace xStore;
class Model_MaterialRequest_Cancel extends Model_MaterialRequest{
	function init(){
		parent::init();
		$this->addCondition('status','cancel');
	}
}	