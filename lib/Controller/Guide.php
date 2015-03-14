<?php


class Controller_Guide extends AbstractController {
	public $guide_steps = array();
	public $guide = null;

	function init(){
		parent::init();
		
		if(true /* or guide is on in session */){
			if($_GET['reset-guide']){
				$this->api->forget('guide_done');
			}
			
			$done=$this->api->recall('guide_done',array());
			if(in_array($this->owner->name, $done)){
				// return;
			}

			$done[]=$this->owner->name;
			$this->api->memorize('guide_done',$done);

			$file = getcwd().'/templates/guide/'.$this->guide.".json";
			if(file_exists($file)){
				$contents = file_get_contents($file);
				$this->guide_steps = $array = json_decode($contents,true);
				// foreach ($array as $step) {
				// 	$this->guide_steps[] =array('element'=>$step['selector'],'intro'=>$step['intro']);
				// }

			}

			if(count($this->guide_steps)){
				// include intro js files
				// $this->api->template->appendHTML('js_include','<script src="templates/js/guide/bootstrap-tour.min.js"></script>'."\n");
				// $this->api->template->appendHTML('js_include','<link type="text/css" href="templates/js/guide/bootstrap-tour.min.css" rel="stylesheet" />'."\n");
				// get its guide and start tour on load
				$this->api->jquery->addInclude('guide/bootstrap-tour.min');
				$this->api->jquery->addStylesheet('guide/bootstrap-tour.min');
				$this->owner->js()->_load('guide/guide.xepan')->univ()->runIntro($this->guide_steps)->execute();
			}
		}
		// parent::recursiveRender();
	}
}