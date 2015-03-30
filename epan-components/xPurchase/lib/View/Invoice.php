<?php
namespace xPurchase;
class View_Invoice extends  \CompleteLister{
	public $invoice;
	public $sno=1;

	function init(){
		parent::init();
		
		$self = $this;
		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$o = $p->add('xPurchase/Model_Order')->load($_GET['purchase_order_clicked']);
			$view_order = $p->add('xPurchase/View_PurchaseOrder',array('show_price'=>false));
			$view_order->setModel($o);
		});


		$this->template->setHtml('invoice_no',$this->invoice['name']);
		$this->template->setHtml('po',$this->invoice['po']);
		$this->template->setHtml('billing_address',$this->invoice['billing_address']);
		// $this->template->setHtml('xpurchase_supplier',$this->invoice['xpurchase_supplier']);
		//$this->template->setHtml('billing_address',$this->invoice['billing_address']);
		$this->template->setHtml('xpurchase_supplier',$this->invoice['supplier']);
		$this->invoice['type']?$this->template->setHtml('type',"Invoice: <b>".ucwords($this->invoice['type'])."</b>"):"";
		//$this->invoice['po']?$this->template->setHtml('purchase_order_no',"Purchase Order No: <b>".'<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->invoice['sales_order'], $this->api->url($this->vp->getURL(),array('sales_order_clicked'=>$this->invoice['sales_order_id']))).'">'.$this->invoice['sales_order']."</a></b>"):"";

		$this->invoice['po']?$this->template->setHtml('po',"Purchase Order No: <b>".ucwords($this->invoice['po'])."</b>"):"";
		
		$this->setModel($this->invoice->itemrows());
	}

	function formatRow(){
		 $this->current_row['sno']=$this->sno;
		$this->sno++;
	}
		
	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		
		
		return array('view/invoice');
	}
	
  
}