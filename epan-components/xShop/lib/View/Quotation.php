<?php
namespace xShop;
class View_Quotation extends \CompleteLister{
	
	public $quotation;
	public $sno=1;
	
	function init(){
		parent::init();

		$this->template->set('created_at',$this->quotation['created_at']);
		$this->template->set('status',ucwords($this->quotation['status']));
	
		$this->setModel($this->quotation->itemrows());
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
		return array('view/xShop-quotaion');
	}
}