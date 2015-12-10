<?php

class page_xPurchase_page_owner_report_stock extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$form=$this->add('Form');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get Report');

	}
}