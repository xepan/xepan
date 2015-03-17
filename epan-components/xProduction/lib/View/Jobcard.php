<?php

namespace xProduction;

class View_Jobcard extends \View{
	public $jobcard;
	public $sno=1;

	function init(){
		parent::init();

		$oi = $this->jobcard->orderItem();
		$order = $oi->order();

		$this->setModel($order->OrderItems());
		

		$this->template->set('qty',$order['qty']);
		$this->template->set('name',$order['name']);
		$this->template->set('member',$order['member']);
		$this->template->set('order_from',$order['order_from']);
		$this->template->set('on_date',$order['on_date']);
		$this->template->set('status',$order['status']);
		$this->template->set('from_dept',$this->jobcard['from_department']);
		$this->template->set('to_dept',$this->jobcard['to_department']);
		$this->template->set('name',$this->jobcard['name']);
		$this->current_row['sno']=$this->sno;
		$this->current_row['current_status'] = $this->model->getCurrentStatus();
		$this->current_row['custom_fields'] = $this->model->ref('item_id')->genericRedableCustomFieldAndValue($this->model['custom_fields']);
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
		
		
		return array('view/jobcard');
	}
	
  
}