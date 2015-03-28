<?php
namespace xShop;

class Model_Invoice_Completed extends Model_SalesInvoice{
	
	public $actions=array(
			'can_view'=>array(),
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','completed');
	}
}