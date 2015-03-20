<?php
namespace xStore;
class View_StockMovement extends \CompleteLister{
	
	public $stockmovement;
	public $sno=1;
	
	function init(){
		parent::init();

		$this->stockmovement['created_at']?$this->template->setHtml('created_at',"Created at: <b>".$this->stockmovement['created_at']."</b>"):"";
		$this->stockmovement['status']?$this->template->setHtml('status',"Status: <b>".ucwords($this->stockmovement['status'])."</b>"):"";
		$this->stockmovement['type']?$this->template->setHtml('type',"Type: <b>".ucwords($this->stockmovement['type'])."</b>"):"";
		$this->stockmovement['to_department']?$this->template->setHtml('to_dept',"To Department: <b>".$this->stockmovement['to_department']."</b>"):"";
		$this->stockmovement['from_warehouse']?$this->template->setHtml('from_warehouse',"From Warehouse: <b>".$this->stockmovement['from_warehouse']."</b>"):"";
		$this->stockmovement['to_warehouse']?$this->template->setHtml('to_warehouse',"To Warehouse: <b>".$this->stockmovement['to_warehouse']."</b>"):"";
		$this->stockmovement['from_supplier']?$this->template->setHtml('from_supplier',"From Supplier: <b>".$this->stockmovement['from_supplier']."</b>"):"";
		$this->stockmovement['to_supplier']?$this->template->setHtml('to_supplier',"To Supplier: <b>".$this->stockmovement['to_supplier']."</b>"):"";
		$this->stockmovement['from_memberdetails']?$this->template->setHtml('from_memberdetails',"From Customer: <b>".$this->stockmovement['from_memberdetails']."</b>"):"";
		$this->stockmovement['to_memberdetails']?$this->template->setHtml('to_memberdetails',"To Customer: <b>".$this->stockmovement['to_memberdetails']."</b>"):"";
		$this->stockmovement['jobcard']?$this->template->setHtml('jobcard',"Jobcard: <b>".$this->stockmovement['jobcard']."</b>"):"";
		$this->stockmovement['material_request_jobcard']?$this->template->setHtml('material_request_jobcard',"Material Request Jobcard: <b>".$this->stockmovement['material_request_jobcard']."</b>"):"";
		$this->stockmovement['po']?$this->template->setHtml('po',"Purchase Order No: <b>".$this->stockmovement['po']."</b>"):"";
		$this->stockmovement['dispatch_request']?$this->template->setHtml('dispatch_request',"Dispatch Request: <b>".$this->stockmovement['dispatch_request']."</b>"):"";
		// $this->template->set('form_dept',$this->stockmovement['from_department']);
	
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