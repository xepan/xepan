<?php
namespace xShop;
class View_Quotation extends \CompleteLister{
	
	public $quotation;
	public $sno=1;
	
	function init(){
		parent::init();
		
		$this->template->setHtml('name',"Quotation No: <b>".$this->quotation['name']."</b>");
		$this->template->setHtml('created_at',"Created At: <b>".$this->quotation['created_at']."</b>");
		$this->template->setHtml('status',"Status: <b>".ucwords($this->quotation['status'])."</b>");
		$this->quotation['customer']?$this->template->setHtml('customer',"Customer: <b>".ucwords($this->quotation['customer'])."</b>"):"";
		$this->quotation['lead']?$this->template->setHtml('lead',"Lead: <b>".ucwords($this->quotation['lead'])."<b>"):"";
		
		$this->setModel($this->quotation->itemrows());
	}

	function formatRow(){
		$this->current_row['sno']=$this->sno;
		$this->current_row_html['departments']=$this->model['item_name'];
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
		return array('view/quotation');
	}
}