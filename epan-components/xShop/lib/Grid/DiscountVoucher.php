<?php
namespace xShop;
class Grid_DiscountVoucher extends \Grid{
	function init(){
		parent::init();
	} 
	function setModel($model){
		$m = parent::setModel($model);

		if($this->hasColumn('item_name')) $this->removeColumn('item_name');
		// $this->fooHideAlways('username');

		$this->addPaginator(15);
		$this->addQuickSearch(array('name','no_person','discount_amount','from','to'));
		$this->add_sno();
		return $m;	
	}
}