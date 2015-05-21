<?php

namespace xMarketingCampaign;
class Grid_LeadCategory extends \Grid{
	function init(){
		parent::init();

		$this->addPaginator($ipp=50);
		$this->add_sno();
	}

	function setModel($model,$fields=null){
		if(!count($fields))
			$fields=array('name','is_active','total_emails','totalleads');
		$m = parent::setModel($model,$fields);
		$this->removeColumn('item_name');		
		$this->addQuickSearch($fields);
		return $m;
		
	}
}