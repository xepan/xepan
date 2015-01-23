<?php

class Form_Field_ElImage extends Form_Field_Line{
	function init(){
		parent::init();

		$btn=$this->afterField()->add('Button')->set('')->setIcon('doc');
		$btn->js('click')->_load('elimage')->univ()->myelimage($this);
	}
}