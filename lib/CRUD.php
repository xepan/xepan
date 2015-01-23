<?php

class CRUD extends View_CRUD{
	public $form_class='Form_Stacked';
	
	function init(){
		parent::init();
		$this->add('Controller_FormBeautifier');
	}
}