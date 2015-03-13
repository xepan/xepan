<?php

namespace xProduction;

class View_Jobcard extends \CompleteLister{
	public $jobcard;
	public $sno=1;
	function init(){
		parent::init();

		
		
	}

	function setModel($model){
		$m=parent::setModel($model);
		$order= $m->ref('orderitem_id');
		$this->template->set('gross_amount',$order['amount']);
		$this->template->set('net_amount',$order['net_amount']);
	echo "hgjh";
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
		
		
		return array('view/jobcard');
	}
	
  
}