<?php

namespace xPurchase;

class Grid_Invoice extends \Grid{
	function init(){
		parent::init();
		$self= $this;
		$this->addSno();

		$this->vp=$this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xPurchase/View_PurchaseInvoice',array('invoice'=>$p->add('xPurchase/Model_PurchaseInvoice')->load($p->api->stickyGET('invoice_clicked'))));
		});
		
		$this->vp_order = $this->add('VirtualPage')->set(function($p)use($self){
			$p->api->stickyGET('purchase_order_no_clicked');
			$o = $p->add('xPurchase/Model_PurchaseOrder')->load($_GET['purchase_order_no_clicked']);
			$order = $p->add('xPurchase/View_PurchaseOrder',array('purchaseorder'=>$o));
			// $order->setModel($o);
		});
	}
	
	function format_view($field){
		if($this->model['invoiceitem_count']==0){
			$this->setTDParam($field, 'class', ' atk-swatch-yellow ');
		}else{
			$this->setTDParam($field, 'class', '');
		}
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Invoice', $this->api->url($this->vp->getURL(),array('invoice_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>".'<br><small style="color:gray;">'.$this->model['supplier'].'</small>';
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Purchase Order '. $this->model['po'], $this->api->url($this->vp_order->getURL(),array('purchase_order_no_clicked'=>$this->model['po_id']))).'">'. $this->current_row[$field] ."</a>";
	}
	
	function setModel($invoice_model,$field=array()){
		if(!$field)
			$field = array('name','invoice_no','po','supplier','total_amount','discount','tax','net_amount','custom_fields');

		$m=parent::setModel($invoice_model,$field);
		 $this->addFormatter('name','view');
		$this->addFormatter('po','orderview');
		$this->addColumn('expander','items',array('page'=>'xShop_page_owner_invoice_items','descr'=>'Items'));

		$this->removeColumn('supplier');
		$this->removeColumn('invoiceitem_count');
		return $m;
	}
	

	}	