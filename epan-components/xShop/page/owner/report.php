<?php
class page_xShop_page_owner_report extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xShop_page_owner_report_opportunity','Opportunity');
		$tabs->addTabURL('xShop_page_owner_report_quotation','Quotation');
		$tabs->addTabURL('xShop_page_owner_report_order','Order');
		$tabs->addTabURL('xShop_page_owner_report_invoice','Invoice');
		$tabs->addTabURL('xShop_page_owner_report_item','Items');
		$tabs->addTabURL('xShop_page_owner_report_evoucher','E-Voucher');
		$tabs->addTabURL('xShop_page_owner_report_customer','Customer');
		$tabs->addTabURL('xShop_page_owner_report_materialrequest','Material Request');
		$tabs->addTabURL('xShop_page_owner_report_stock','Stock');
	}
}