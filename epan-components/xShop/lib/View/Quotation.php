<?php
namespace xShop;
class View_Quotation extends \CompleteLister{
	
	public $quotation;
	public $sno=1;
	
	function init(){
		parent::init();

		$this->template->set('name',$this->quotation['name']);
		$this->template->set('created_at',$this->quotation['created_at']);
		$this->template->set('status',ucwords($this->quotation['status']));
		$this->template->set('customer',ucwords($this->quotation['customer']));
		$this->template->set('lead',ucwords($this->quotation['lead']));
		
		$this->setModel($this->quotation->itemrows());
	}

	function formatRow(){
		$this->current_row['sno']=$this->sno;
		$this->current_row_html['departments']=$this->model->redableDeptartmentalStatus(true);
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