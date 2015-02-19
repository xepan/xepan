<?php

class page_xAi_page_owner_update extends page_componentBase_page_update {
		
	public $git_path="https://github.com/xepan/xAi.git"; // Put your components git path here

	function init(){
		parent::init();

		$this->update($dynamic_model_update=true, $git_update=false);
		$this->add('View_Info')->set('Component Updated Successfully');
	}
}