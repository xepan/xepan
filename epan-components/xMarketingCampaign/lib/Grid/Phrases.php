<?php
namespace xMarketingCampaign;
class Grid_Phrases extends \Grid{
	function init(){
		parent::init();
		$this->addPaginator(10);;
		$this->add_sno();
	}
	function setModel($model){
		$m = parent::setModel($model,array('subscription_category','name','is_grabbed','last_page_checked_at','emails_count'));
	
		$this->fooHideAlways('last_run_time');
		$this->fooHideAlways('site_url');
		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}