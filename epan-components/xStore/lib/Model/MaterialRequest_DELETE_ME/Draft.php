<?php
namespace xStore;
class Model_MaterialRequest_Draft extends Model_MaterialRequest{
	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	