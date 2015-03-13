<?php

class PageHelp extends View{
	public $page=null;

	function init(){
		parent::init();
		
		$bs = $this->add('ButtonSet');
		
		$help=$bs->addButton('Help');
		$guide=$bs->addButton('Guide');
		$faq=$bs->addButton('FAQ');

		if($help->isClicked()){
			$help->js()->univ()->successMessage('Hello')->execute();
		}

		if($guide->isClicked()){
			$this->add('Controller_Guide',array('guide'=>$this->page));
		}
	}

	function render(){
		$this->api->jquery->addStylesheet('guide/bootstrap-tour.min');
		$this->api->jquery->addInclude('guide/bootstrap-tour.min');
		$this->api->jquery->addInclude('guide/guide.xepan');
		parent::render();
	}

}