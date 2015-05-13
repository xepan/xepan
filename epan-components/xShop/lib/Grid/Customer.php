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

		$this->addFormatter('customer_name','wrap');
		$this->addFormatter('address','wrap');
		$this->addFormatter('customer_email','wrap');
		$this->addFormatter('other_emails','wrap');
		$this->addFormatter('mobile_number','wrap');
		
		$this->fooHideAlways('state');
		$this->fooHideAlways('country');
		$this->fooHideAlways('billing_address');
		$this->fooHideAlways('shipping_address');

		$this->addPaginator(15);
		$this->addQuickSearch(array('name','no_person','discount_amount','from','to'));
		$this->add_sno();
		return $m;	
	}

	function formatRow(){
		$this->current_row_html['customer_name']=$this->model['customer_name'];
		parent::formatRow();
	}
}