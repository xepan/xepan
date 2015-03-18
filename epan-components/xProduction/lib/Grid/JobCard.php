<?php
namespace xProduction;

class Grid_JobCard extends \Grid{

	function init(){
		parent::init();
		$self= $this;

		$this->add('VirtualPage')->addColumn('col_name','job Detail',array('icon'=>''),$this)->set(function($p)use($self){
			$p->add('xProduction/View_Jobcard',array('jobcard'=>$p->add('xProduction/Model_JobCard')->load($p->id)));
		});
	}

	function setModel($job_card_model){
		$m=parent::setModel($job_card_model,array('orderitem','from_department','name','forwarded_to'));
		$this->addOrder()->move('col_name','last')->now();
		return $m;
	}
}