<?php
namespace xMarketingCampaign;
class Grid_DataGrabber extends \Grid{
	function init(){
		parent::init();
		$this->addPaginator($ipp=10);
		$this->add_sno();
	}
	function setModel($model){
		$m = parent::setModel($model,array('name','site_url','is_active','last_run_time','total_phrases','ungrabbed_phrases'));
	
		$this->fooHideAlways('last_run_time');
		$this->fooHideAlways('site_url');
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}