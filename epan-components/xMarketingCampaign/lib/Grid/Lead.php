<?php

namespace xMarketingCampaign;

class Grid_Lead extends \Grid{
	
	function init(){
		parent::init();

		$this->addPaginator(100);
		$this->add_sno();
	}
	function format_weblink($field){
		$is_ok ='<span class="pull-right fa fa-circle" style="color:red"></span>';
		$this->setTDParam($field,'title','Invalid Email');
		
		if($this->model['is_ok']){
			$this->setTDParam($field,'title','Valid Email');
			$is_ok = '<span class="pull-right fa fa-circle" style="color:green"></span>';
		}

		preg_match_all("/@(.*)$/", $this->current_row[$field],$weblink);
					// $g->current_row_html[$f] = print_r($weblink[1],true);
					$this->current_row_html[$field]= '<a class="pull-left" href="http://'.$weblink[1][0].'" target="_blank"> '.$this->current_row[$field].'</a>'.$is_ok;
	}

	function setModel($model,$fields=array()){
		if(!count($fields))
			$fields = array('email','name','from_app','is_ok','ip','lead_type','organization_name','website','phone','mobile_no','associated_categories','total_opportunity','total_quotation'); 
		$m = parent::setModel($model,$fields);

		$this->fooHideAlways('ip');
		$this->fooHideAlways('lead_type');
		$this->fooHideAlways('organization_name');
		$this->fooHideAlways('website');
		$this->fooHideAlways('phone');
		$this->fooHideAlways('mobile_no');

		$this->addFormatter('email','weblink');
		// $this->addQuickSearch($fields);

		$this->hasColumn('is_ok')?$this->removeColumn('is_ok'):"";
		$this->addQuickSearch(array($fields),null,'xMarketingCampaign/Filter_Lead');

		$this->addColumn('Expander','category');
		return $m;
	}

	function recursiveRender(){
		$btn= $this->addButton("Lead Category Management");
		if($btn->isClicked()){
			$this->js()->univ()->frameURL('Lead Category',$this->api->url('xMarketingCampaign_page_owner_leadcategory'))->execute();
		}
		parent::recursiveRender();
	}
	function formatRow(){
		$str = "";
		if($this->model['phone'])
			$str = $this->model['phone'].', ';

		$this->current_row_html['name'] = $this->model['name'].'<br/>'.$str.$this->model['mobile_no'];
		parent::formatRow();
	}
}