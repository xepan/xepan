<?php

namespace xShop;
class Grid_Opportunity extends \Grid{
	function init(){
		parent::init();
		$this->addPaginator($ipp=50);
		$this->add_sno();
	}
	function setModel($model,$fields=array()){
		if(!count($fields))
			$fields = array();
		
		$m = parent::setModel($model,$fields);

		if($this->hasColumn('item_name')) $this->removeColumn('item_name');
		$this->addQuickSearch($fields);
		return $m;
	}

	function formatRow(){
		parent::formatRow();
	}
}