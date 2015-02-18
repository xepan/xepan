<?php

class page_xProduction_page_owner_update extends page_componentBase_page_update {
		
	public $git_path="https://github.com/xepan/xProduction.git"; // Put your components git path here

	function init(){
		parent::init();

		// 
		// Code To run before update
		
		$this->update(); // All modls will be dynamic executed in here
		
		// Code to run after update
	}
}