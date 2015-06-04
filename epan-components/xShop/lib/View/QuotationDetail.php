<?php

namespace xShop;

class View_QuotationDetail extends \CompleteLister{
	public $sno=1;
	public $show_price = false;
	public $show_department = true;
	public $show_customfield = false;
	public $show_specification = false;
	function init(){
		parent::init();
	}

	function formatRow(){

		$this->current_row_html['sno']=$this->sno;
		$this->current_row_html['unit']=$this->model['unit'];
		if($this->show_department)
			$this->current_row_html['departments']=$this->model->redableDeptartmentalStatus(true,true,false,true);
		if(!$this->show_price){
			$this->current_row_html['order_amount_section']= " ";
		}
		if($this->show_customfield){
			$this->current_row_html['departments']=$this->model->item()->genericRedableCustomFieldAndValue($this->model['custom_fields']);
		}
		if($this->show_specification){
			$this->current_row_html['specifications']= '[ '.$this->model->item()->redableSpecification(",").' ]';
		}

		$this->sno++;
	}

	function setModel($model){
		parent::setModel($model);

		if($this->show_price){
			$order= $model->ref('quotation_id');
			// $order= $model->ref('priority_id');
			// $this->template->set('gross_amount',$order['amount']);
			$this->template->set('total_amount',$order['gross_amount']);
			//$this->template->set('delivery_date',$order['delivery_date']);
			// $this->template->set('discount_voucher',$order['discount_voucher']);
			if($order['discount_voucher_amount'])
				$this->template->set('discount_voucher_amount',$order['discount_voucher_amount']?:'0.00');
			else{
				$this->template->set('discount_amount_section',"");
			}

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
		return array('view/xShop-quotationDetail');
	}

}