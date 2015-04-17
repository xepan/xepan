<?php
namespace xProduction;

class Grid_JobCard extends \Grid{
	public $ipp=100;
	function init(){
		parent::init();
		$self= $this;
		$this->addSno();

		$this->vp=$this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xProduction/View_Jobcard',array('jobcard'=>$p->add('xProduction/Model_JobCard')->load($p->api->stickyGET('jobcard_clicked'))));
		});

		$this->vp_order = $this->add('VirtualPage')->set(function($p)use($self){
			$o = $p->add('xShop/Model_Order')->loadBy('name',$_GET['sales_order_no_clicked']);
			$order = $p->add('xShop/View_Order',array('show_price'=>false));
			$order->setModel($o);
		});

	}
	
	function format_view($field){
		$outsource = "";
		if($this->model['outsource_party']){
			$this->setTDParam($field, 'class', ' atk-swatch-blue ');
			$outsource = "<br><span>Outsource:".$this->model['outsource_party']."</span>";
		}
		else
			$this->setTDParam($field, 'class', '');

		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Job Card '. $this->model['name'], $this->api->url($this->vp->getURL(),array('jobcard_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>"."<br><small>Dept:".$this->model->ref('to_department_id')->get('name')."</small>".$outsource;
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->model['order_no'], $this->api->url($this->vp_order->getURL(),array('sales_order_no_clicked'=>$this->model['order_no']))).'">'. $this->current_row[$field] ."</a>".'<br/><small style="color:gray;">'.$this->model->order()->get('member').'</small>';
	}


	function setModel($job_card_model){
		$m=parent::setModel($job_card_model,array('order_no','name','created_at','orderitem','from_department','forwarded_to','outsource_party'));
		$this->addFormatter('order_no','orderview');
		$this->addFormatter('name','view');
		$this->removeColumn('outsource_party');

		$this->addPaginator($this->ipp);
		return $m;
	}
}