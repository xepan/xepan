<?php
namespace xDispatch;
class Grid_DeliveryNote extends \Grid{
	function init(){
		parent::init();

		$this->addQuickSearch(array('order','warehouse'));
		$this->addPaginator($ipp=50);
	}

}