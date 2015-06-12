<?php

namespace xMarketingCampaign;
class Grid_LeadCategory extends \Grid{
	public $mail_vp;
	function init(){
		parent::init();

		$this->addPaginator($ipp=50);
		$this->add_sno();

		$self=$this;
		$this->mail_vp = $this->add('VirtualPage')->set(function($p)use($self){
			$cat_id=$this->api->StickyGET('leadcategory_id');
			$cat_model=$p->add('xMarketingCampaign/Model_LeadCategory');
			$cat_model->load($cat_id);
			
			$grid = $p->add('xMarketingCampaign/Grid_Lead');
			$lead = $p->add('xMarketingCampaign/Model_Lead');
				// $lead->addCondition('subscriber_id',$cat_id);
			// echo "string".$lead;
			$grid->setModel($lead);
		});
	}

	function format_total_emails($f){
		$this->current_row_html[$f] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Total E-mails ( '.$this->model['name'].' )', $this->api->url($this->mail_vp->getURL(),array('leadcategory_id'=>$this->model['id']))).'">'. $this->current_row[$f]."</a>";
	}

	function setModel($model,$fields=null){
		if(!count($fields))
			$fields=array('name','is_active','total_emails','totalleads');
		$m = parent::setModel($model,$fields);
		$this->removeColumn('item_name');		
		$this->addQuickSearch($fields);

		$this->addFormatter('total_emails','total_emails');
		return $m;
		
	}
}