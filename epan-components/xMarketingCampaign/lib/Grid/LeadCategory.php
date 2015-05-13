<?php

namespace xMarketingCampaign;
class Grid_LeadCategory extends \Grid{
	function init(){
		parent::init();

		$this->addPaginator($ipp=50);
		$this->add_sno();
	}

	function setModel($model,$fields=array()){
		if(!count($fields))
			$fields=array('name','totalleads');
		$m = parent::setModel($model,$fields);
		
		$this->hasColumn('totalleads')?$this->removeColumn('totalleads'):"";
		$this->addQuickSearch($fields);
		return $m;
		
	}
}