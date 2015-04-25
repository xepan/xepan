<?php

namespace xPurchase;

class Grid_PurchaseOrder extends \Grid {

	function init(){
		parent::init();
		$self= $this;
		$this->addSno();

		$this->vp=$this->add('VirtualPage')->set(function($p)use($self){
			$po_id = $self->api->stickyGET('purchaseorder_clicked');
			$p->add('xPurchase/View_PurchaseOrder',array('purchaseorder'=>$p->add('xPurchase/Model_PurchaseOrder')->load($po_id)));
		});

		$purchase_order_print = $this->addColumn('Button','print');
		if($_GET['print']){
			$this->js()->univ()->newWindow($this->api->url('xPurchase_page_owner_printpurchaseorder',array('purchaseorder_id'=>$_GET['print'],'cut_page'=>0)))->execute();
		}
	}
	
	function format_purchaseorder($field){
		if($this->model['orderitem_count']==0){
			$this->setTDParam($field, 'class', ' atk-swatch-yellow ');
		}else{
			$this->setTDParam($field, 'class', '');
		}
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('PurchaseOrder', $this->api->url($this->vp->getURL(),array('purchaseorder_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}


	function setModel($purchase_order_model,$fields=null){
		if($fields==null){
			$fields = array(
						'supplier_id','priority_id','name','order_summary','order_date','delivery_to'
						);
		}

		$m=parent::setModel($purchase_order_model,$fields);
	
		$this->removeColumn('orderitem_count');
		$this->addFormatter('name','purchaseorder');
		$this->addPaginator(100);
		return $m;
	}
	

}	