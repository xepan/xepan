<?php
namespace xMarketingCampaign;
class Grid_Campaign extends \Grid{
	function init(){
		parent::init();
		$this->addQuickSearch(array('name','category','starting_date','ending_date'));
		$this->addPaginator($ipp=50);
		$this->add_sno();
	}
	function setModel($model){
		$m = parent::setModel($model,array('category','name','starting_date','ending_date','effective_start_date','is_active'));
	
		$this->fooHideAlways('starting_date');
		$this->fooHideAlways('ending_date');
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}