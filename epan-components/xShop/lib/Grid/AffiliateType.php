<?php
namespace xShop;
class Grid_AffiliateType extends \Grid{
	function init(){
		parent::init();
	}

	function setModel($model){
		
		$m=parent::setModel($model,array('name'));



		$this->addQuickSearch(array('name'));
		$this->addPaginator(50);
		$this->add_sno();

		return $m;

	}

	function formatRow(){

		parent::formatRow();		
	}

}