<?php
namespace xShop;

class Model_Invoice_Canceled extends Model_SalesInvoice{
	
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','canceled');
	}
}