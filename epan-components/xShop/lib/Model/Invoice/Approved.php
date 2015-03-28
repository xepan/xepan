<?php
namespace xShop;

class Model_Invoice_Approved extends Model_SalesInvoice{
	
	public $actions=array(
			'can_view'=>array(),
			'allow_del'=>array(),
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','approved');
	}
}