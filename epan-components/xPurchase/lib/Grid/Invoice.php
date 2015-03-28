<?php

namespace xPurchase;

class Grid_Invoice extends \Grid{
	function init(){
		parent::init();

		$self= $this;
		$this->addSno();

		$this->vp=$this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xPurchase/View_Invoice',array('invoice'=>$p->add('xShop/Model_Invoice')->load($p->api->stickyGET('invoice_clicked'))));
		});
		
		$this->vp_order = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('Purchase_order_no_clicked');
			$o = $p->add('xPurchase/Model_PurchaseOrder')->load($_GET['purchase_order_no_clicked']);
			$order = $p->add('xPurchase/View_PurchaseOrder');
			$order->setModel($o);
		});
	}
	
	function format_view($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Invoice', $this->api->url($this->vp->getURL(),array('invoice_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Purchase Order '. $this->model['po'], $this->api->url($this->vp_order->getURL(),array('purchase_order_no_clicked'=>$this->model['po_id']))).'">'. $this->current_row[$field] ."</a>";
	}
	
	function setModel($invoice_model){
		$m=parent::setModel($invoice_model,array('name','amount','created_at','po','supplier'));
		 $this->addFormatter('name','view');
		$this->addFormatter('po','orderview');
		$this->addColumn('expander','items',array('page'=>'xShop_page_owner_invoice_items','descr'=>'Items'));

		return $m;
	}
	

	}	