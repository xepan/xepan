<?php
namespace xMarketingCampaign;
class Grid_Phrases extends \Grid{
	function init(){
		parent::init();
	}
	function setModel($model){
		$m = parent::setModel($model,array('subscription_category','name','is_grabbed','last_page_checked_at','emails_count'));
	
		$this->fooHideAlways('last_run_time');
		$this->fooHideAlways('site_url');
		
		$this->addQuickSearch(array('name','subscription_category'),null,'xMarketingCampaign/Filter_Phrases');
		$this->addPaginator(10);;
		$this->add_sno();
		
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}