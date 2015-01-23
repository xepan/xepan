<?php

class CRUD extends View_CRUD{
	public $form_class='Form_Stacked';
	
	function setModel($model,$f=array(),$f2=array()){
		parent::setModel($model,$f,$f2);
		$this->add('Controller_FormBeautifier');
	}
}