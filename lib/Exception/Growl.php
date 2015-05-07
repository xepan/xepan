<?php

class Exception_Growl extends BaseException{
	function init(){
		parent::init();
		if($this->api->isAjaxOutput() OR $_GET['cut_page'])
			$this->api->js()->univ()->errorMessage($this->getMessage())->execute();
		else
			throw $this;
	}
}