<?php

namespace xProduction;

class View_Jobcard extends \CompleteLister{
	public $jobcard;
	public $sno=1;

	function init(){
		parent::init();

		$oi = $this->jobcard->orderItem();
		$order = $oi->order();

		$this->setModel($order->OrderItems());
		

		$this->template->set('qty',$order['qty']);
		$this->template->set('order_from',$order['order_from']);
		$this->template->set('on_date',$order['on_date']);
	}

	function formatRow(){
		$this->current_row['sno']=$this->sno;
		$this->current_row['current_status'] = $this->model->getCurrentStatus();
		$this->current_row['custom_fields'] = $this->model->getCurrentStatus();
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