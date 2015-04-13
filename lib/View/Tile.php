<?php

class View_Tile extends View {

	function init(){
		parent::Init();

	}

	function setTitle($title,$icon=null){
		$this->template->trySetHTML('title',$title);
	}

	function setContent($content){
		$this->template->trySetHTML('Content',$content);
	}

	function setFooter($text,$icon=null){
		$html = '<i class="'.$icon.'"> &nbsp;&nbsp;'.$text.'</i>';
		$this->template->trySetHTML('footer',$html);
	}

	function defaultTemplate(){
		return array('view/tile');
	}

}