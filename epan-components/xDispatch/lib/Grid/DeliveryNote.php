<?php
namespace xDispatch;
class Grid_DeliveryNote extends \Grid{
	function init(){
		parent::init();

		$this->vp_order = $this->add('VirtualPage')->set(function($p){
			$this->api->stickyGET('sales_order_no_clicked');
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_no_clicked']);
			$order = $p->add('xShop/View_Order',array('show_price'=>false));
			$order->setModel($o);
		});

		$this->vp_deliverynote = $this->add('VirtualPage')->set(function($p){
			$p->api->stickyGET('deliverynote_clicked');
			$p->add('xDispatch/View_DeliveryNote',
				array(
					'deliverynote'=>$this->add('xDispatch/Model_DeliveryNote')->load($_GET['deliverynote_clicked'])
					)
				);
		});

		$this->addQuickSearch(array('order','warehouse'));
		$this->addPaginator($ipp=50);
	}

	function format_orderview($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Order '. $this->model['order_no'], $this->api->url($this->vp_order->getURL(),array('sales_order_no_clicked'=>$this->model['order_id']))).'">'. $this->current_row[$field] ."</a>";
	}
	
	function format_deliverynote($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Delivery Note '. $this->model['name'], $this->api->url($this->vp_deliverynote->getURL(),array('deliverynote_clicked'=>$this->model['id']))).'">'. $this->current_row[$field] ."</a>";
	}

	function setModel($delivery_note, $fields=null){	
		if(!$fields)
			$fields= array('order','name','created_at','from_department','forwarded_to');

		$m=parent::setModel($delivery_note,$fields);

		if(in_array('order', $fields))
			$this->addFormatter('order','orderview');
		
		$this->addFormatter('name','deliverynote');
		$this->removeColumn('order_id');
		return $m;
	}

}