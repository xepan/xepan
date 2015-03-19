<?php

class page_xShop_page_owner_quotation extends page_xShop_page_owner_main{
	function page_index(){

		$this->app->title=$this->api->current_department['name'] .': Quotations';		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Quotations Management <small> Manage your Quotations </small>');

		$tab = $this->add('Tabs');
		$draft_tab = $tab->addTabURL('xShop_page_owner_quotation_draft','Draft');
		$submit_tab = $tab->addTabURL('xShop_page_owner_quotation_submitted','Submitted');
		$redesign_tab = $tab->addTabURL('xShop_page_owner_quotation_redesign','Redesign');
		$approve_tab = $tab->addTabURL('xShop_page_owner_quotation_approved','Approved');
		$approve_tab = $tab->addTabURL('xShop_page_owner_quotation_cancelled','Cancelled');
		
		// $p=$crud->addFrame('communication_frame');
		// if($p) $p->add('View_Error')->set($crud->id);
		
	}

}