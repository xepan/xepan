<?php

class CRUD extends View_CRUD{
	public $form_class='Form_Stacked';
	
	function setModel($model,$f=null,$f2=null){
		parent::setModel($model,$f,$f2);
		$this->add('Controller_FormBeautifier');
	}
}