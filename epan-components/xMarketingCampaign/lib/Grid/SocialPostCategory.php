<?php
namespace xMarketingCampaign;
class Grid_SocialPostCategory extends \Grid{
	function init(){
		parent::init();
		$this->addQuickSearch(array('name'));
		$this->addPaginator($ipp=50);
		$this->add_sno();

	}
	function setModel($model){
		$m = parent::setModel($model,array('name','posts'));
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}