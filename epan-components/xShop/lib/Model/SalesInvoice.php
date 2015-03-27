<?php
namespace xShop;
class Model_SalesInvoice extends Model_Invoice{

	function init(){
		parent::init();
		$this->addCondition('type','salesInvoice');
	}
}