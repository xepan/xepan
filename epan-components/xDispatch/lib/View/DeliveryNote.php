<?php
namespace xDispatch;

class View_DeliveryNote extends \CompleteLister{
	
	public $deliverynote;
	public $sno=1;
	
	function init(){
		parent::init();

		$this->vp_order = $this->add('VirtualPage')->set(function($p){
			$p->api->stickyGET('sales_order_clicked');
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_clicked']);
			$order = $p->add('xShop/View_Order',array('show_price'=>false));
			$order->setModel($o);
		});

		$this->template->setHtml('name',$this->deliverynote['name']);
		$this->template->setHtml('created_at',$this->deliverynote['created_at']);
		$this->template->setHtml('status',ucwords($this->deliverynote['status']));
		$this->template->setHtml('order','<a href="#void" onclick="javascript:'.$this->js()->univ()->frameURL('Sale Order', $this->api->url($this->vp_order->getURL(),array('sales_order_clicked'=>$this->deliverynote['order_id']))).'">'. $this->deliverynote['order'] ."</a>");
		$this->template->setHtml('to_memberdetails',$this->deliverynote['to_memberdetails']);
		$this->template->setHtml('shipping_address',$this->deliverynote['shipping_address']);
		$this->template->setHtml('shipping_via',$this->deliverynote['shipping_via']);
		$this->template->setHtml('docket_no',$this->deliverynote['docket_no']);
		
		if($this->deliverynote->loaded())
			$this->setModel($this->deliverynote->itemRows());
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
		return array('view/deliverynote');
	}
}