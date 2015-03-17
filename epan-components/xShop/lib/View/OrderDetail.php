<?php

namespace xShop;

class View_OrderDetail extends \CompleteLister{
	public $sno=1;
	public $show_price = 0;
	function init(){
		parent::init();
	}

	function formatRow(){

		$this->current_row_html['sno']=$this->sno;
		$this->current_row_html['departments']=$this->model->redableDeptartmentalStatus(true);
		// $this->current_row_html['custom_fields']=$this->model->ref('item_id')->genericRedableCustomFieldAndValue($this->model['custom_fields']);
		$this->sno++;
	}

	function setModel($model){
		parent::setModel($model);

		if($this->show_price){
			$order= $model->ref('order_id');
			$this->template->set('gross_amount',$order['amount']);
			// $this->template->set('discount_voucher',$order['discount_voucher']);
			$this->template->set('discount_voucher_amount',$order['discount_voucher_amount']);
			$this->template->set('net_amount',$order['net_amount']);
			// $this->template->set('departments',"1");
			// $this->template->set('order_item_custom_field',$model['id']);
		}else{
			$this->template->tryDel('order_amount_section');
		}
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
		return array('view/xShop-orderDetail');
	}

}