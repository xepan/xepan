<?php

class page_xShop_page_owner_invoice extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Sale Invoice';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-dashboard icon-money"></i> Sales Invoice');

		$tab=$this->add('Tabs');
		$tab->addTabURL('xShop/page/owner/invoice_draft','Draft '.$this->add('xShop/Model_Invoice_Draft')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_submitted','Submitted '.$this->add('xShop/Model_Invoice_Submitted')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_approved','Approved'.$this->add('xShop/Model_Invoice_Approved')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_completed','Completed'.$this->add('xShop/Model_Invoice_Completed')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_redesign','Redesign '.$this->add('xShop/Model_Invoice_Redesign')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_canceled','Canceled '.$this->add('xShop/Model_Invoice_Canceled')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_all','All '.$this->add('xShop/Model_SalesInvoice')->myCounts(true,false));

	}

}