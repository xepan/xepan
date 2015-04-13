<?php

class page_xMarketingCampaign_page_owner_leads extends page_xMarketingCampaign_page_owner_main{
	
	function page_index(){
			$this->app->title=$this->api->current_department['name'] .': Leads';
		// Add Badges

		// filter line if filter is there

		$leads=$this->app->layout->add('xMarketingCampaign/Model_Lead');
		// $leads->addCondition('source','DataFeed');
		// $leads->addCondition('source_id','0');

		$crud=$this->add('CRUD');
		$crud->setModel($leads,array(),array('email','from_app','is_ok','ip','lead_type','name','organization_name','website','phone','mobile_no','fax'));
		$grid=$crud->grid;
			$grid->addMethod('format_weblink',function($g,$f){
					preg_match_all("/@(.*)$/", $g->current_row[$f],$weblink);
					// $g->current_row_html[$f] = print_r($weblink[1],true);
					$g->current_row_html[$f]= '<a href="http://'.$weblink[1][0].'" target="_blank"> '.$g->current_row[$f].' </a>';
			});
			$grid->addFormatter('email','weblink');
			$grid->addPaginator(100);
			$grid->addQuickSearch(array('email'));
		$crud->add('xHR/Controller_Acl');

		$grid->removeColumn('item_name');

	}
}