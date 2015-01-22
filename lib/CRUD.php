<?php

class CRUD extends View_CRUD{
	public $form_class='Form_Stacked';
	
	function recursiveRender(){
		$this->add('Controller_FormBeautifier');
		parent::recursiveRender();
	}
}