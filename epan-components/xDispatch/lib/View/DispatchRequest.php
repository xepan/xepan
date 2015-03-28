<?php
namespace xDispatch;
class View_DispatchRequest extends \CompleteLister{
	
	public $dispatchrequest;
	public $sno=1;
	
	function init(){
		parent::init();
		
		$this->vp_order = $this->add('VirtualPage')->set(function($p){
			$p->api->stickyGET('sales_order_clicked');
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_clicked']);
			$order = $p->add('xShop/View_Order',array('show_price'=>false));
			$order->setModel($o);
		});


		$this->template->setHtml('name',$this->dispatchrequest['name']);
		$this->template->setHtml('status',ucwords($this->dispatchrequest['status']));
		$this->template->setHtml('created_at',$this->dispatchrequest['created_at']);
		$this->template->setHtml('order','<a href="#void" onclick="javascript:'.$this->js()->univ()->frameURL('Sale Order', $this->api->url($this->vp_order->getURL(),array('sales_order_clicked'=>$this->dispatchrequest['order_id']))).'">'. $this->dispatchrequest['order_no'] ."</a>");
		$this->template->setHtml('from_department',$this->dispatchrequest['from_department']);
		$this->template->setHtml('to_department',$this->dispatchrequest['to_department']);
		$this->template->setHtml('dispatch_to_warehouse',$this->dispatchrequest['dispatch_to_warehouse']?:'Not Dispatched');
		
		if($this->dispatchrequest->loaded())
			$this->setModel($this->dispatchrequest->itemRows());
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
		return array('view/dispatchrequest');
	}
}