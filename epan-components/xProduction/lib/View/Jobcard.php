<?php

namespace xProduction;

class View_Jobcard extends \View{
	public $jobcard;
	public $sno=1;

	function init(){
		parent::init();
		$oi = $this->jobcard->orderItem();
		$order = $oi->order();

		$self = $this;
		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_clicked']);
			$view_order = $p->add('xShop/View_Order',array('show_price'=>false));
			$view_order->setModel($o);
		});
		
		$this->template->trySetHtml('name',$this->jobcard['name']);
		$this->template->trySetHtml('from_dept',$this->jobcard['from_department']);
		$this->template->trySetHtml('to_dept',$this->jobcard['to_department']);
		$this->template->trySetHtml('next_dept','Todo');
		$this->template->trySetHtml('status',$this->jobcard['status']);
		$this->template->trySetHtml('sales_order_no','<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Sale Order', $this->api->url($this->vp->getURL(),array('sales_order_clicked'=>$order->id))).'">'. $order['name'] ."</a>");
		$this->template->trySetHtml('order_created_at',$order['created_at']);
		$this->template->trySetHtml('customer',$order['member']);
		$this->template->trySetHtml('order_from',$order['order_from']);
		$this->template->trySetHtml('item',$oi['item_name']);
		$this->template->trySetHtml('qty',$oi['qty']);
		$this->template->trySetHtml('unit',$oi['unit']);
		$out = $oi->redableDeptartmentalStatus(true,false,$this->jobcard->toDepartment()); // all departments
		// $out= $oi->item()->genericRedableCustomFieldAndValue($oi['custom_fields']); // Department only
		$this->template->trySetHtml('custom_fields',$out);
		$this->template->trySetHtml('specification',$oi->item()->redableSpecification());

		$received_activity = $this->jobcard->searchActivity('received');
		if(!$received_activity instanceof \Dummy)
			$this->template->trySetHtml('receive_date', $received_activity['created_at']);

		$this->template->trySetHtml('received_by_x',$this->jobcard->ref('created_by_id')->get('name_with_designation') . ' on ' .$this->jobcard['created_at']);
		// $this->current_row['sno']=$this->sno;
		// $this->current_row['current_status'] = $this->model->getCurrentStatus();
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
		
		
		return array('view/jobcard');
	}
	
  
}