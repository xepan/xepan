<?php

namespace xPurchase;
class Grid_Supplier extends \Grid{
	public $vp;
	function init(){
		parent::init();
		$self=$this;
		$this->vp = $this->add('VirtualPage')->set(function($p){
			$p->api->StickyGET('supplier_id');
			$grid = $p->add('xPurchase/Grid_PurchaseOrder');
			$po = $p->add('xPurchase/Model_PurchaseOrder')->addCondition('supplier_id',$_GET['supplier_id']);
			$grid->setModel($po,array('name','order_date'));
		});
		
	}
	
	function format_total_purchase_order($f){
				$this->current_row_html[$f] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Purchase Order List ', $this->api->url($this->vp->getURL(),array('supplier_id'=>$this->model['id']))).'">'. $this->model->ref('xPurchase/PurchaseOrder')->count()->getOne()."</a>";
	}

	function setModel($model){
		$m = parent::setModel($model,array('name','owner_name','city','email','contact_no','is_active'));
		$this->addColumn('total_purchase_order');
		$this->addFormatter('total_purchase_order','total_purchase_order');
		
	
		$this->addQuickSearch(array('name','code','city','state','pin_code','email','contact_no','created_at'));
		$this->addPaginator($ipp=50);
		$this->add_sno();
		return $m;
		


	}

	function formatRow(){
		parent::formatRow();
	}
}