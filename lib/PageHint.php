<?php

class PageHint extends View_Info{
	function init(){
		parent::init();

		if(false /* If Page Hint on in config (general or application ??) */){
			$this->destroy();
		}
	}
}