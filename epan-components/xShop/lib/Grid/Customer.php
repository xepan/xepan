<?php
namespace xShop;
class Grid_Customer extends \Grid{
	function init(){
		parent::init();
	} 
	function setModel($model,$fields=null){
		$m = parent::setModel($model,$fields);

		if($this->hasColumn('item_name')) $this->removeColumn('item_name');
		if($this->hasColumn('password')) $this->removeColumn('password');
		// if($this->hasColumn('address')) $this->removeColumn('address');

		$this->addFormatter('customer_name','wrap');
		
		$this->addFormatter('address','wrap');
		$this->addFormatter('customer_email','wrap');
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