<?php

namespace xShop;

class Grid_Category extends \Grid{
	function init(){
		parent::init();
		

	}

	function setModel($model){
		$m = parent::setModel($model,array('name','parent','order_no','is_active'));
		
		if($this->hasColumn('is_active')) $this->removeColumn('is_active');
		
		$this->addFormatter('name','wrap');
		$this->add_sno();
		$this->addQuickSearch(array('name','parent'));
		$this->addPaginator($ipp=100);
		return $m;
	}

	function formatRow(){
		
		if(!$this->model['is_active']){
			$this->setTDParam('name','style/color','red');
		}else{
			$this->setTDParam('name','style/color','');
		}
		parent::formatRow();

	}

	function recursiveRender(){
		$this->addClass('panel panel-default');
		$this->addClass('mygrid');//Todo for reload of crud->grid 
		$this->js('reload')->reload();//adding trigger 

		parent::recursiveRender();
	}

}