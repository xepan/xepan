<?php

class PageHelp extends View{
	public $page=null;

	function init(){
		parent::init();
		$this->addStyle('float','right');
			
		$this->owner->add('Order')->move($this,'first')->now();

		if($this->page == null) {
			$this->set('Page Not Defined');
			return;
		}

		$bs = $this->add('ButtonSet');
		
		$help=$bs->addButton('')->addClass('icon-help');
		$guide=$bs->addButton('')->addClass('icon-eye');
		if(is_array($this->page)){
			$pov = $this->add('View_Popover');
			$view= $pov->add('View');
			foreach ($this->page as $pg) {
				$m = $view->add('Button')->set(ucwords(str_replace("_", " ", $pg)));
				$m->js('click')->reload(array($this->api->normalizeName($m->name) => 'true'));
				if($m->isClicked()){
					$guide->js(true)->click();
					$this->add('Controller_Guide',array('guide'=>$pg));
				}
			}
			$guide->js('click',$pov->showJS());
		}else{
			if($guide->isClicked()){
				$this->add('Controller_Guide',array('guide'=>$this->page));
			}
		}
		$faq=$bs->addButton('')->addClass('icon-book');

		if($help->isClicked()){
			$help->js()->univ()->successMessage('Hello')->execute();
		}

	}

	function render(){
		$this->api->jquery->addStylesheet('guide/bootstrap-tour.min');
		$this->api->jquery->addInclude('guide/bootstrap-tour.min');
		$this->api->jquery->addInclude('guide/guide.xepan');
		parent::render();
	}

}