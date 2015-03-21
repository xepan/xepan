<?php

namespace xShop;

class Grid_Order extends \Grid {
	public $vp;
	function init(){
		parent::init();
		$self = $this;
		
		$this->addSno();

		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_clicked']);
			$order = $p->add('xShop/View_Order');
			$order->setModel($o);
		});
	}

	function format_view($field){
		if($this->model['orderitem_count']==0){
			$this->setTDParam($field, 'class', ' atk-swatch-yellow ');
		}else{
			$this->setTDParam($field, 'class', '');
		}
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Sale Order', $this->api->url($this->vp->getURL(),array('sales_order_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}

	function setModel($model,$fields=null){

		if($fields==null){
			$fields = array(
						'name','order_from','created_at','member',
						'net_amount','last_action','created_by','orderitem_count'
						);
		}

		$m = parent::setModel($model,$fields);

		$this->addColumn('expander','details',array('page'=>'xShop_page_owner_order_detail','descr'=>'Details'));

		// $this->addColumn('Button','print');
		// if($_GET['print']){			
		// 	$this->js()->univ()->newWindow($this->api->url("xShop/page_printorder",array('order_id'=>$_GET['print'],'cut_page'=>1,'subpage'=>'xshop-junk')),null,'height=689,width=1246,scrollbar=1')->execute();
		// } 

		$this->addFormatter('name','view');
		$this->removeColumn('orderitem_count');

		$this->addPaginator(100);
		$this->addQuickSearch(array('order_id','order_from','on_date','discount_voucher'));
		return $m;
	}
}