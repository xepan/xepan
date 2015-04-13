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

	function defaultTemplate(){
		return array('view/tile');
	}
}