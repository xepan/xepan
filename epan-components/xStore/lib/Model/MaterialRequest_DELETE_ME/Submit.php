<?php
namespace xStore;
class Model_MaterialRequest_Submit extends Model_MaterialRequest{
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	