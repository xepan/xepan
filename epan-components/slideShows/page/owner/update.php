<?php

class page_slideShows_page_owner_update extends page_componentBase_page_update {
		
	public $git_path='https://github.com/xepan/slideShows'; // Put your components git path here

	function init(){
		parent::init();

		// 
		// Code To run before update
		
		$this->update($dynamic_model_update=true, $git_update=false);
		$this->add('View_Info')->set('Component Updated Successfully');
		
		// Code to run after update
	}
}