<?php

class View_Accordion extends View {

	function addSection($title_text){
		$a = $this->add('View',null,null,array('view/accordion','accordian_panel'));
		$title=$this->add('View',null,'titles',array('view/accordion','title'));
		$title->template->trySet('panel_name',$a->name);
		$title->template->tryset('_main_accordian_name',$this->name);
		$title->set($title_text);
		return $a;
	}

	function defaultTemplate(){
		return array('view/accordion');
	}

}