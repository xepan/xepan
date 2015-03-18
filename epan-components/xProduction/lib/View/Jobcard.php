<?php

namespace xProduction;

class View_Jobcard extends \View{
	public $jobcard;
	public $sno=1;

	function init(){
		parent::init();
		$oi = $this->jobcard->orderItem();
		$order = $oi->order();


		$this->template->set('jobcard_no',$this->jobcard['name']);
		$this->template->set('job_created_at',$this->jobcard['created_at']);
		$this->template->set('receive_date',"TODOOOOO");
		$this->template->set('from_dept',$this->jobcard['from_department']);
		$this->template->set('to_dept',$this->jobcard['to_department']);
		$this->template->set('next_dept','Todo');
		$this->template->set('status',$this->jobcard['status']);
		$this->template->set('sales_order_no',$order['name']);
		$this->template->set('order_created_at',$order['created_at']);
		$this->template->set('customer',$order['member']);
		$this->template->set('order_from',$order['order_from']);
		$this->template->set('item',$oi['item']);
		$this->template->setHtml('custom_fields',$oi->item()->genericRedableCustomFieldAndValue($oi['custom_fields']));
		$this->template->setHtml('specification',$oi->item()->genericRedableCustomFieldAndValue($oi['custom_fields']));

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