<?php
namespace xMarketingCampaign;
class Grid_SubscriptionCategory extends \Grid{
	function init(){
		parent::init();
		$this->addQuickSearch(array('name','is_active'));
		$this->addPaginator($ipp=50);
		$this->add_sno();

	}

	// function format_total_phrases($f){
	// 	$this->current_row_html[$f]= '<a href="javascript:void(0)" onclick="'.$this->js()->univ()->frameURL('Phrases For "'.$this->model['name'].'"',$this->api->url($total_phrases_vp->getURL(),array('category_id'=>$this->model->id))).'">'.$this->current_row[$f].'</a>';
	// }
	function setModel($model){
		$m = parent::setModel($model,array('name','is_active','total_phrases','un_grabbed_phrases','total_emails','grabbed_emails','emails_by_other_apps','bounced_emails'));
	
		$this->fooHideAlways('starting_date');
		$this->fooHideAlways('ending_date');
		$this->addButton('Jump to Data Grabber ...')->js('click')->redirect($this->api->url('xMarketingCampaign_page_owner_mrkt_dtgrb_dtgrb'));
		
		$this->addFormatter('total_phrases','total_phrases');	

		return $m;
	}
	function formatRow(){
		parent::formatRow();
	}
}