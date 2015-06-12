<?php

class page_xPurchase_page_owner_purchaseinvoice extends page_xPurchase_page_owner_main{

	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Purchase Invoice';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-dashboard icon-money"></i> Purchase Invoice');

		$tab=$this->add('Tabs');
		$tab->addTabURL('xPurchase/page/owner/invoice_draft','Draft '.$this->add('xPurchase/Model_Invoice_Draft')->myCounts(true,false));
		$tab->addTabURL('xPurchase/page/owner/invoice_submitted','Submitted '.$this->add('xPurchase/Model_Invoice_Submitted')->myCounts(true,false));
		$tab->addTabURL('xPurchase/page/owner/invoice_approved','Approved'.$this->add('xPurchase/Model_Invoice_Approved')->myCounts(true,false));
		$tab->addTabURL('xPurchase/page/owner/invoice_completed','Completed'.$this->add('xPurchase/Model_Invoice_Completed')->myCounts(true,false));
		$tab->addTabURL('xPurchase/page/owner/invoice_canceled','Canceled '.$this->add('xPurchase/Model_Invoice_Canceled')->myCounts(true,false));
		$tab->addTabURL('xPurchase/page/owner/invoice_all','All '.$this->add('xPurchase/Model_PurchaseInvoice')->myCounts(true,false));

	}

}