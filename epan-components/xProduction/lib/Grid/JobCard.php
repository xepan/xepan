<?php
namespace xProduction;

class Grid_JobCard extends \Grid{

	function init(){
		parent::init();
		$self= $this;
		$this->addSno();

		$this->vp=$this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xProduction/View_Jobcard',array('jobcard'=>$p->add('xProduction/Model_JobCard')->load($this->api->stickyGET('jobcard_clicked'))));
		});
	}
	
	function format_view($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Job Card', $this->api->url($this->vp->getURL(),array('jobcard_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}


	function setModel($job_card_model){
		$m=parent::setModel($job_card_model,array('name','created_at','orderitem','from_department','forwarded_to'));
		$this->addFormatter('name','view');

		return $m;
	}
}