<?php

namespace xMarketingCampaign;

class Grid_SocialPost extends \Grid{
	function init(){
		parent::init();
		$this->addQuickSearch(array('name','category'));
		$this->addPaginator($ipp=50);
		$this->add_sno();
	}
	function setModel($model){
		$m = parent::setModel($model);
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}