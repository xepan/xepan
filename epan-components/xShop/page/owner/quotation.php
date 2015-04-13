<?php

class page_xShop_page_owner_quotation extends page_xShop_page_owner_main{
	function page_index(){

		$this->app->title=$this->api->current_department['name'] .': Quotations';		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Quotations Management <small> Manage your Quotations </small>');

		$tab = $this->add('Tabs');
		$tab->addTabURL('xShop/page/owner/quotation/draft','Draft'.$this->add('xShop/Model_Quotation_Draft')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/quotation/submitted','Submitted'.$this->add('xShop/Model_Quotation_Submitted')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/quotation/approved','Approved'.$this->add('xShop/Model_Quotation_Approved')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/quotation/cancelled','Cancelled'.$this->add('xShop/Model_Quotation_Cancelled')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/quotation/redesign','Redesign'.$this->add('xShop/Model_Quotation_Redesign')->myCounts(true,false));
		
		// $p=$crud->addFrame('communication_frame');
		// if($p) $p->add('View_Error')->set($crud->id);
		
	}

}