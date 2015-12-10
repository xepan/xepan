<?php
class page_xPurchase_page_owner_report extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xPurchase_page_owner_report_order','Order');
		$tabs->addTabURL('xPurchase_page_owner_report_invoice','Invoice');
		$tabs->addTabURL('xPurchase_page_owner_report_supplier','Supplier');
		$tabs->addTabURL('xPurchase_page_owner_report_supplier','Material Request');
		$tabs->addTabURL('xPurchase_page_owner_report_supplier','Stock');
	}
}