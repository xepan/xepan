<?php
namespace xStore;
class View_MaterialRequest extends \CompleteLister{
	
	public $materialrequest;
	public $sno=1;
	
	function init(){
		parent::init();
		// $this->add('View_Info')->set('Material Request Details Here');

		$this->template->setHtml('request_on',"Request On: <b>".$this->materialrequest['created_at']."</b>");
		$this->template->setHtml('status',"Status: <b>".ucwords($this->materialrequest['status'])."</b>");
		$this->template->setHtml('form_dept',"From Department: <b>".$this->materialrequest['from_department']."</b>");
		$this->template->setHtml('to_dept',"To Department: <b>".$this->materialrequest['to_department']."</b>");
		$this->template->setHtml('name',"Job Number: <b>".$this->materialrequest['name']."</b>");
	
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