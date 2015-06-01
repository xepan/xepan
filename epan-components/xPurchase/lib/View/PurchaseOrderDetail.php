<?php

namespace xPurchase;

class View_PurchaseOrderDetail extends \CompleteLister{
	public $sno=1;
	public $show_price = false;
	function init(){
		parent::init();

	}

	function formatRow(){

		$this->current_row_html['sno']=$this->sno;
		$this->current_row_html['unit']=$this->model['unit'];
		$this->sno++;
	}

	function setModel($model){
		parent::setModel($model);

			$purchase= $model->ref('po_id');
			// $purchase= $model->ref('priority_id');
			// $this->template->set('gross_amount',$purchase['amount']);
			// $this->template->set('total_amount',$purchase['total_amount']);
			//$this->template->set('delivery_date',$purchase['delivery_date']);
			// $this->template->set('discount_voucher',$purchase['discount_voucher']);
			// $this->template->set('texted_amount',$purchase['tax']?:'0.00');
			// $this->template->set('net_amount',$purchase['net_amount']);
			// $this->template->set('departments',"1");
			// $this->template->set('purchase_item_custom_field',$model['id']);
		
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
		return array('view/purchaseorderDetail');
	}

}