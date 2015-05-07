<?php

namespace xMarketingCampaign;
class Grid_LeadCategory extends \Grid{
	function init(){
		parent::init();
	}
	function setModel($model){
		$m = parent::setModel($model,array('name'));
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}