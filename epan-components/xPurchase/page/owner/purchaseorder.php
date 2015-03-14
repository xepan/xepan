<?php
class page_xPurchase_page_owner_purchaseorder extends page_xPurchase_page_owner_main {
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Purchase Order';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Purchase Order Management <small> Manage purchase order </small>');



		// $crud=$this->app->layout->add('CRUD');
		// $crud->setModel('xPurchase/Model_PurchaseOrder');
		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xPurchase_page_owner_purchaseorder_draft','Draft');
		$tabs->addTabURL('xPurchase_page_owner_purchaseorder_redesign','Redesign');
		$tabs->addTabURL('xPurchase_page_owner_purchaseorder_submitted','Submitted');
		$tabs->addTabURL('xPurchase_page_owner_purchaseorder_approved','Approved');
		$tabs->addTabURL('xPurchase_page_owner_purchaseorder_processing','Processing');
		$tabs->addTabURL('xPurchase_page_owner_purchaseorder_completed','Completed');
		$tabs->addTabURL('xPurchase_page_owner_purchaseorder_rejected','Rejected');
	}
}
