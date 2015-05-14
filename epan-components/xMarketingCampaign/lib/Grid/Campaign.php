<?php
namespace xMarketingCampaign;
class Grid_Campaign extends \Grid{
	function init(){
		parent::init();
	}
	function setModel($model){
		$m = parent::setModel($model,array('category','name','starting_date','ending_date','effective_start_date','is_active'));
		if($this->hasColumn('category'))$this->removeColumn('category');	
		$this->fooHideAlways('starting_date');
		$this->fooHideAlways('ending_date');
		$this->addQuickSearch(array('name','category','starting_date','ending_date'),null,'xMarketingCampaign/Filter_Campaign');
		$this->addPaginator($ipp=50);
		$this->add_sno();
		return $m;
	}
	function recursiveRender(){
		$btn= $this->addButton("Campaing Category Management");
		if($btn->isClicked()){
			$this->js()->univ()->frameURL('Campaing Category',$this->api->url('xMarketingCampaign_page_owner_campaignscat'))->execute();
		}
		parent::recursiveRender();
	}
	function formatRow(){
		parent::formatRow();
	}
}