<?php
class page_xPurchase_page_owner_purchaseorder extends page_xPurchase_page_owner_main {
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Purchase Order';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Purchase Order Management <small> Manage purchase order </small>');



	$tab = $this->add('Tabs');
	$tab->addTabURL('xPurchase/page/owner/purchaseorder_draft','Draft '.$this->add('xPurchase/Model_PurchaseOrder_Draft')->myCounts(true,false));
	$tab->addTabURL('xPurchase/page/owner/purchaseorder_submitted','Submitted '.$this->add('xPurchase/Model_PurchaseOrder_Submitted')->myCounts(true,false));
	$tab->addTabURL('xPurchase/page/owner/purchaseorder_redesign','Redesign '.$this->add('xPurchase/Model_PurchaseOrder_Redesign')->myCounts(true,false));
	$tab->addTabURL('xPurchase/page/owner/purchaseorder_approved','Approved '.$this->add('xPurchase/Model_PurchaseOrder_Approved')->myCounts(true,false));
	// $tab->addTabURL('xPurchase/page/owner/purchaseorder_processing','Processing '.$this->add('xPurchase/Model_PurchaseOrder_Processing')->myCounts(true,false));
	$tab->addTabURL('xPurchase/page/owner/purchaseorder_completed','Completed '.$this->add('xPurchase/Model_PurchaseOrder_Completed')->myCounts(true,false));
	$tab->addTabURL('xPurchase/page/owner/purchaseorder_rejected','Rejected '.$this->add('xPurchase/Model_PurchaseOrder_Rejected')->myCounts(true,false));
	$tab->addTabURL('xPurchase/page/owner/purchaseorder_all','All '.$this->add('xPurchase/Model_PurchaseOrder')->myCounts(true,false));
	}
}
