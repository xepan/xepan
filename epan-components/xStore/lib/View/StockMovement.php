<?php
namespace xStore;
class View_StockMovement extends \CompleteLister{
	
	public $stockmovement;
	public $sno=1;
	
	function init(){
		parent::init();

		$this->template->set('created_at',$this->stockmovement['created_at']);
		$this->template->set('status',ucwords($this->stockmovement['status']));
		$this->template->set('type',ucwords($this->stockmovement['type']));
		// $this->template->set('form_dept',$this->stockmovement['from_department']);
		$this->template->set('to_dept',$this->stockmovement['to_department']);
		$this->template->set('from_warehouse',$this->stockmovement['from_warehouse']);
		$this->template->set('to_warehouse',$this->stockmovement['to_warehouse']);
		$this->template->set('from_supplier',$this->stockmovement['from_supplier']);
		$this->template->set('to_supplier',$this->stockmovement['to_supplier']);
		$this->template->set('from_memberdetails',$this->stockmovement['from_memberdetails']);
		$this->template->set('to_memberdetails',$this->stockmovement['to_memberdetails']);
		$this->template->set('material_request_jobcard',$this->stockmovement['material_request_jobcard']);
		$this->template->set('jobcard',$this->stockmovement['jobcard']);
		$this->template->set('po',$this->stockmovement['po']);
		$this->template->set('dispatch_request',$this->stockmovement['dispatch_request']);
	
		$this->setModel($this->stockmovement->itemrows());
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
		return array('view/stockmovement');
	}
}