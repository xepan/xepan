<?php

namespace xShop;
class Grid_QuotationItem extends \Grid{
	function init(){
		parent::init();
		$this->addQuickSearch(array('name'));
		$this->addPaginator($ipp=50);
		$this->add_sno();
	}
	function setModel($model){
		$m = parent::setModel($model,array('name','item_name','item','qty','rate','amount','custom_fields','tax_per_sum','tax_amount','texted_amount'));

		if($this->hasColumn('item_name')) $this->removeColumn('item_name'); 
		if($this->hasColumn('name'))  $this->removeColumn('name');
		if($this->hasColumn('item'))  $this->removeColumn('item');
		if($this->hasColumn('custom_fields'))  $this->removeColumn('custom_fields');


		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}