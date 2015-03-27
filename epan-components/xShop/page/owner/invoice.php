<?php

class page_xShop_page_owner_invoice extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$tab=$this->add('Tabs');
		$tab->addTabURL('xShop/page/owner/invoice_draft','Draft '.$this->add('xShop/Model_Invoice_Draft')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_submitted','Submitted '.$this->add('xShop/Model_Invoice_Submitted')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_approved','Approved'.$this->add('xShop/Model_Invoice_Approved')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_completed','Completed'.$this->add('xShop/Model_Invoice_Completed')->myCounts(true,false));
		$tab->addTabURL('xShop/page/owner/invoice_canceled','Canceled '.$this->add('xShop/Model_Invoice_Canceled')->myCounts(true,false));

	}

}