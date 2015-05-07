<?php

namespace xShop;
class Grid_Opportunity extends \Grid{
	function init(){
		parent::init();
		$this->addQuickSearch(array('name'));
		$this->addPaginator($ipp=50);
		$this->add_sno();
	}
	function setModel($model){
		$m = parent::setModel($model);

		if($this->hasColumn('item_name')) $this->removeColumn('item_name'); 
		
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}