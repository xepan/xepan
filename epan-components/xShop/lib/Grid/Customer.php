<?php
namespace xShop;
class Grid_Customer extends \Grid{
	function init(){
		parent::init();

		$this->add_sno();
		$this->addPaginator($ipp=100);

		$this->vp = $this->add('VirtualPage')->set(function($p){
			$this->api->StickyGET('customer_id');
			$grid = $p->add('xShop/Grid_Order');
			$so = $p->add('xShop/Model_Order')->addCondition('member_id',$_GET['customer_id']);
			$grid->setModel($so);
		});

		$this->addColumn('total_sales_order');
	} 

	function setModel($model,$fields=null){
		if(!$fields)
			$fields = $model->getActualFields();
		$m = parent::setModel($model,$fields);

		if($this->hasColumn('item_name')) $this->removeColumn('item_name');
		if($this->hasColumn('password')) $this->removeColumn('password');
		if($this->hasColumn('user_account_activation')) $this->removeColumn('user_account_activation');
		if($this->hasColumn('is_active')) $this->removeColumn('is_active');
		if($this->hasColumn('pincode')) $this->removeColumn('pincode');
		// if($this->hasColumn('address')) $this->removeColumn('address');

		$this->addFormatter('customer_name','wrap');
		$this->addFormatter('organization_name','wrap');
		
		$this->addFormatter('address','wrap');
		$this->addFormatter('customer_email','wrap');
		$this->addFormatter('mobile_number','wrap');
		
		// $this->fooHideAlways('city');
		$this->fooHideAlways('state');
		$this->fooHideAlways('country');
		$this->fooHideAlways('billing_address');
		$this->fooHideAlways('shipping_address');

		$this->addPaginator(50);

		if(!$fields)
			$fields = $model->getActualFields();
		$this->addQuickSearch($fields,null,'xShop/Filter_Customer');

		//Total Order Count
		$this->addFormatter('total_sales_order','total_sales_order');
		$this->add('misc/Export');
		return $m;	
	}

	function format_total_sales_order($f){
		$this->current_row_html[$f] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Customer ( '.$this->model['customer_name'].' ) Sales Order List ', $this->api->url($this->vp->getURL(),array('customer_id'=>$this->model['id']))).'">'. $this->model->ref('xShop/Order')->count()->getOne()."</a>";
	}

	function formatRow(){
		if(!$this->model['is_active'])
			$this->setTDParam('customer_name','style/color','red');
		else
			$this->setTDParam('customer_name','style/color','');
		$this->current_row_html['address']=$this->model['address']."  ".$this->model['pincode'];
		parent::formatRow();
	}
}