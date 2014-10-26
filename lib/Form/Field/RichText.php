<?php

class Form_Field_RichText extends Form_Field_Text{
	function init(){
		parent::init();
		
		$this->js(true)->_load('elrte/js/elrte.min')->_load('rte');
		$this->setFieldHint('Use Save Icon of this window to save the form contents');

		// $this->addClass('tinymce');
		// $this->js(true)->_load('tinymce/xepan6.tinymce');
		// $this->js(true)->univ()->xtinymce();
			
	}

	function render(){

		$this->js(true)->univ()->createRTE(array(
											'toolbar'=>'maxi',
											'cssfiles'=>  array('templates/default/css/epan.css')
											)
								);
		parent::render();
	}
}