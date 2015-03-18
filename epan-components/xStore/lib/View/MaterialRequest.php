<?php
namespace xStore;
class View_MaterialRequest extends \CompleteLister{
	
	public $materialrequest;
	public $sno=1;
	
	function init(){
		parent::init();
		// $this->add('View_Info')->set('Material Request Details Here');

		$this->template->set('request_on',$this->materialrequest['created_at']);
		$this->template->set('status',ucwords($this->materialrequest['status']));
		$this->template->set('form_dept',$this->materialrequest['from_department']);
		$this->template->set('to_dept',$this->materialrequest['to_department']);
	
		$this->setModel($this->materialrequest->itemrows());
	}

	function formatRow(){
		$this->current_row['sno']=$this->sno;
		$this->current_row_html['custom_field'] =  $this->add('xShop/Model_Item')->genericRedableCustomFieldAndValue($this->model['custom_fields']);
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
		return array('view/xStore-materialrequest');
	}
}