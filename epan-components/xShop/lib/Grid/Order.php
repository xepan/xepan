<?php

namespace xShop;

class Grid_Order extends \Grid {
	public $vp;
	public $ipp=100;

	function init(){
		parent::init();
		$self = $this;
		
		$this->addSno();

		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$o = $p->add('xShop/Model_Order')->load($_GET['sales_order_clicked']);
			$order = $p->add('xShop/View_Order');
			$order->setModel($o);
		});
		
		$print = $this->addColumn('Button','print');
		if($_GET['print']){
			$this->js()->univ()->newWindow($this->api->url('xShop_page_owner_printsaleorder',array('saleorder_id'=>$_GET['print'],'cut_page'=>0)))->execute();
		}
	}

	function format_view($field){
		if($this->model['orderitem_count']==0){
			$this->setTDParam($field, 'class', ' atk-swatch-yellow ');
		}else{
			$this->setTDParam($field, 'class', '');
		}

		$online="";
		if($this->model['order_from']=='online'){
			$online = "<i class='fa fa-shopping-cart fa-2x'> </i>";
		}

		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Sale Order', $this->api->url($this->vp->getURL(),array('sales_order_clicked'=>$this->model->id))).'">'. $this->current_row[$field] . ' '. $online."</a>".'<br><small style="color:gray;">'.$this->model['member']."</small>";
	}

	function format_lastaction($field){
		$this->current_row_html[$field] = $this->current_row[$field]. '<br/>Total Items: <small style="color:gray;">'.$this->model['orderitem_count']."</small>";
	}

	function setModel($model,$fields=null){

		if($fields==null){
			$fields = array(
						'name','order_from','created_at','member',
						'net_amount','last_action','created_by','orderitem_count','delivery_date','priority_id','priority'
						);
		}

		$m = parent::setModel($model,$fields);
		$this->removeColumn('priority_id');
		$this->addColumn('expander','details',array('page'=>'xShop_page_owner_order_detail','descr'=>'Details'));

		// $this->addColumn('Button','print');
		// if($_GET['print']){			
		// 	$this->js()->univ()->newWindow($this->api->url("xShop/page_printorder",array('order_id'=>$_GET['print'],'cut_page'=>1,'subpage'=>'xshop-junk')),null,'height=689,width=1246,scrollbar=1')->execute();
		// } 

		$this->addFormatter('name','view');
		if($this->hasColumn('last_action'))
			$this->addFormatter('last_action','lastaction');

		if($this->hasColumn('orderitem_count'))$this->removeColumn('orderitem_count');
		if($this->hasColumn('order_from'))$this->removeColumn('order_from');
		if($this->hasColumn('member'))$this->removeColumn('member');

		$this->addPaginator($this->ipp);
		if(!$fields)
			$fields = $this->model->getActualFields();
		$this->addQuickSearch($fields);
		return $m;
	}
}