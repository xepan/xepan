<?php
namespace xStore;
class View_MaterialRequest extends \CompleteLister{
	
	public $materialrequest;
	
	function init(){
		parent::init();

		$this->add('View_Info')->set('Material Request Details Here');

		$this->template->set('order_on',$this->materialrequest['on_date']);
		$this->template->set('status',$this->materialrequest['status']);
	
		$this->setModel($this->materialrequest->itemrows());
	
	}

	function formatRow(){
		// $this->current_row['sno']=$this->sno;
		$this->current_row['custom_field'] = "sfsdf";
		// $this->sno++;
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
		
		
		return array('view/xStore-materialrequest');
	}
}