<?php

namespace xMarketingCampaign;
class Grid_Lead extends \Grid{
	function init(){
		parent::init();

		$this->addPaginator(100);
		$this->addQuickSearch(array('email'));
		$this->add_sno();
	}
	function format_weblink($field){
		preg_match_all("/@(.*)$/", $this->current_row[$field],$weblink);
					// $g->current_row_html[$f] = print_r($weblink[1],true);
					$this->current_row_html[$field]= '<a href="http://'.$weblink[1][0].'" target="_blank"> '.$this->current_row[$field].' </a>';
			
	}

	function setModel($model){
		$m = parent::setModel($model,array('email','name','from_app','is_ok','ip','lead_type','organization_name','website','phone','mobile_no'));

		$this->fooHideAlways('ip');
		$this->fooHideAlways('lead_type');
		$this->fooHideAlways('organization_name');
		$this->fooHideAlways('website');
		$this->fooHideAlways('phone');
		$this->fooHideAlways('mobile_no');

		$this->addFormatter('email','weblink');

		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}