<?php

class page_xPurchase_page_owner_purchaseinvoice extends page_xPurchase_page_owner_main{

	function init(){
		parent::init();

		$tab=$this->add('Tabs');
		$tab->addTabURL('xPurchase/page/owner/invoice_draft','Draft ');
		$tab->addTabURL('xPurchase/page/owner/invoice_submitted','Submitted '.$this->add('xPurchase/Model_Invoice_Submitted')->myCounts(true,false));
		$tab->addTabURL('xPurchase/page/owner/invoice_approved','Approved'.$this->add('xPurchase/Model_Invoice_Approved')->myCounts(true,false));
		$tab->addTabURL('xPurchase/page/owner/invoice_completed','Completed'.$this->add('xPurchase/Model_Invoice_Completed')->myCounts(true,false));
		$tab->addTabURL('xPurchase/page/owner/invoice_canceled','Canceled '.$this->add('xPurchase/Model_Invoice_Canceled')->myCounts(true,false));

	}

}