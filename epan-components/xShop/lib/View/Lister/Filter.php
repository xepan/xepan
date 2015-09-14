<?php

namespace xShop;

class View_Lister_Filter extends \CompleteLister{
	public $html_attributes = array();
	public $specification_id = null;

	function init(){
		parent::init();

		if(!$this->specification_id){
			$this->add('View_Error')->set('specification_id not found');
			return;
		}
			
		$filter = $this->add('xShop/Model_Filter');
		$filter->addCondition('specification_id',$this->specification_id);
		$filter->addCondition('category_id',$_GET['xsnb_category_id']);
		$filter->tryLoadAny();

		$this->setModel($filter);

	}

	function setModel($model){
		parent::setModel($model);

	}

	function formatRow(){
		parent::formatRow();
		
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
		return array('view/xShop-Filter');		
	}

	
}