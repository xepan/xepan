<?php
namespace xShop;
class Grid_Customer extends \Grid{
	function init(){
		parent::init();
	} 
	function setModel($model){
		$m = parent::setModel($model,array(
										'username','password',
										'customer_name','customer_email',
										'type','email','other_emails','mobile_number',
										'landmark','city','state','pan_no','tin_no',
										'country','address',
										'pincode','billing_address',
										'shipping_address'
										)
								,array('customer_name','customer_email',
										'mobile_number','city','state',
										'country','pincode'));

		if($this->hasColumn('item_name')) $this->removeColumn('item_name');
		// $this->fooHideAlways('username');

		$this->addPaginator(15);
		$this->addQuickSearch(array('name','no_person','discount_amount','from','to'));
		$this->add_sno();
		return $m;	
	}
}