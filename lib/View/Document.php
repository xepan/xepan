<?php

class View_Document extends \View{
	function init(){
		parent::init();
	}

	function setModel($model){
		$m = parent::setModel($model);

		$this->template->trySetHtml('name',$model['name']);	
		$this->template->trySetHtml('status',$model['status']);
		$this->template->trySetHtml('created_at',$model['created_date']);
		$this->template->trySetHtml('created_by',$model['created_by']);
		$this->template->trySetHtml('doc_content',$model['content']);

		return $m;
	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		
		return array('view/company-document');
	}
	
}
