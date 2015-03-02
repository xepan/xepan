<?php
namespace xStore;

class Model_MaterialRequest extends \xProduction\Model_JobCard{
	function init(){
		parent::init();

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function receive(){
		throw new \Exception("Receiving", 1);
		
		parent::receive();
	}
}		
