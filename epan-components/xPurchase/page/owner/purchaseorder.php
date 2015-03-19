<?php
class page_xPurchase_page_owner_purchaseorder extends page_xPurchase_page_owner_main {
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Purchase Order';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Purchase Order Management <small> Manage purchase order </small>');



		// $crud=$this->app->layout->add('CRUD');
		// $crud->setModel('xPurchase/Model_PurchaseOrder');
		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xPurchase/page/owner/purchaseorder/draft','Draft'.$this->add('xPurchase/Model_PurchaseOrder_Draft')->myUnRead());
		$tabs->addTabURL('xPurchase/page/owner/purchaseorder/redesign','Redesign'.$this->add('xPurchase/Model_PurchaseOrder_Redesign')->myUnRead());
		$tabs->addTabURL('xPurchase/page/owner/purchaseorder/submitted','Submitted'.$this->add('xPurchase/Model_PurchaseOrder_Submitted')->myUnRead());
		$tabs->addTabURL('xPurchase/page/owner/purchaseorder/approved','Approved'.$this->add('xPurchase/Model_PurchaseOrder_Approved')->myUnRead());
		$tabs->addTabURL('xPurchase/page/owner/purchaseorder/processing','Processing'.$this->add('xPurchase/Model_PurchaseOrder_Processing')->myUnRead());
		$tabs->addTabURL('xPurchase/page/owner/purchaseorder/completed','Completed'.$this->add('xPurchase/Model_PurchaseOrder_Completed')->myUnRead());
		$tabs->addTabURL('xPurchase/page/owner/purchaseorder/rejected','Rejected'.$this->add('xPurchase/Model_PurchaseOrder_Rejected')->myUnRead());
	}
}
