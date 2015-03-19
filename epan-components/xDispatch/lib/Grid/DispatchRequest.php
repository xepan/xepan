<?php
namespace xDispatch;
class Grid_DispatchRequest extends \Grid{
	function init(){
		parent::init();

		$this->addQuickSearch(array('status','order'));
		$this->addPaginator($ipp=50);
	}

}