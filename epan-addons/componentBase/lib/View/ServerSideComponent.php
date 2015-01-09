<?php

namespace componentBase;


class View_ServerSideComponent extends View_Component {
	public $responsible_namespace = null;
	public $responsible_view = null;

	function init(){
		parent::init();

		$this_class  = get_class($this);

		$namespace_view = explode("\\",$this_class);
		$this->responsible_namespace = $namespace_view[0];
		$this->responsible_view = $namespace_view[1];

		$this->setAttr('data-responsible-namespace',$this->responsible_namespace);
		$this->setAttr('data-responsible-view',$this->responsible_view);
		$this->setAttr('data-is-serverside-component','true');

		if($_GET['html_attributes']){
			// reloading 
			$this->html_attributes = json_decode($_GET['html_attributes'],true);
			$this->data_options = $this->html_attributes['data_options'];
		}

		$this->js('reload')->reload(array('html_attributes'=>$this->js()->parent('div:first')->attrs()));

	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-addons/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);

		return array('view/componentBase-serversidecomponent');
	}
}