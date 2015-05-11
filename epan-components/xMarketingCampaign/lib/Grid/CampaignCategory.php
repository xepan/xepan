<?php
namespace xMarketingCampaign;
class Grid_CampaignCategory extends \Grid{
	function init(){
		parent::init();
		$this->addQuickSearch(array('name'));
		$this->addPaginator($ipp=50);
		$this->add_sno();
	}
	function setModel($model){
		$m = parent::setModel($model,array('name','campaigns'));
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}