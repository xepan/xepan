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
			$order_id = $p->api->stickyGET('sales_order_clicked');

			$print_btn  = $p->add('Button','null')->set('Print');
			if($print_btn->isClicked()){
				$p->js()->univ()->newWindow($this->api->url('xShop_page_owner_printsaleorder',array('saleorder_id'=>$order_id,'sale_performa'=>0,'cut_page'=>0)))->execute();
			}
			$o = $p->add('xShop/Model_Order')->load($order_id);
			$order = $p->add('xShop/View_Order');
			$order->setModel($o);
			
		});
		
		$this->invoicevp = $this->add('VirtualPage')->set(function($p)use($self){
			$inv_id = $p->api->stickyGET('sales_invoice_clicked');
			$p->add('xShop/View_SalesInvoice',array('invoice'=>$p->add('xShop/Model_SalesInvoice')->load($inv_id)));
		});

		$print = $this->addColumn('Button','print');
		if($_GET['print']){
			$this->js()->univ()->newWindow($this->api->url('xShop_page_owner_printsaleorder',array('saleorder_id'=>$_GET['print'],'sale_performa'=>1,'cut_page'=>0)))->execute();
		}
	}

	function format_view($field){
		$this->setTDParam($field, 'style', 'width:200px;');
		if(!$this->model['orderitem_count']){
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
		$this->current_row_html[$field] = '<div style="width:50px;">'.$this->current_row[$field]. '<br/>Total Items: <small style="color:gray;">'.$this->model['orderitem_count']."</small></div>";
	}

	function setModel($model,$fields=null){
		$model->getField('created_at')->caption('Created');
		$model->getField('net_amount')->caption('Amount');

		if($fields==null){
			$fields = array(
						'name','order_from','created_at','member',
						'net_amount','last_action','created_by','orderitem_count','delivery_date','priority_id','priority','order_summary'
						);
		}

		$m = parent::setModel($model,$fields);
		$this->removeColumn('priority_id');
		$this->addColumn('expander','details',array('page'=>'xShop_page_owner_order_detail','descr'=>'Details'));

		// $this->addColumn('Button','print');
		// if($_GET['print']){			
		// 	$this->js()->univ()->newWindow($this->api->url("xShop/page_printorder",array('order_id'=>$_GET['print'],'cut_page'=>1,'subpage'=>'xshop-junk')),null,'height=689,width=1246,scrollbar=1')->execute();
		// } 
		// if($this->hasColumn('last_action'))
			// $this->addFormatter('last_action','view');
		
		$this->addFormatter('name','Wrap');
		$this->addFormatter('name','view');
		$this->addFormatter('created_at','Wrap');

		if($this->hasColumn('last_action')){
			$this->addFormatter('last_action','lastaction');
			$this->addFormatter('last_action','Wrap');
		}

		if($this->hasColumn('orderitem_count'))$this->removeColumn('orderitem_count');
		if($this->hasColumn('order_from'))$this->removeColumn('order_from');
		if($this->hasColumn('member'))$this->removeColumn('member');
		if($this->hasColumn('created_by'))$this->removeColumn('created_by');
		if($this->hasColumn('tax'))$this->removeColumn('tax');
		if($this->hasColumn('gross_amount'))$this->removeColumn('gross_amount');
		if($this->hasColumn('discount_voucher_amount'))$this->removeColumn('discount_voucher_amount');
		if($this->hasColumn('total_amount'))$this->removeColumn('total_amount');
		
		$this->addPaginator($this->ipp);
		if(!$fields)
			$fields = $this->model->getActualFields();
		$this->addQuickSearch($fields);
		return $m;
	}

	function RowHtml($col_left_info,$col_right_info,$col_left_title=null,$col_right_title=null,$separator=false){
		$hr = '<hr style="margin:0px;"/>';
		$str = '<div class="atk-row atk-size-micro">';
		$str .= '<div class="atk-col-6" title="'.$col_left_title.'">'.$col_left_info.'</div>';
		$str .= '<div class="atk-col-6" title="'.$col_right_title.'">'.$col_right_info.'</div>';
		$str .= '</div>';

		if($separator)$str.= $hr;	
		return $str;
	}

	function formatRow(){
		$amount = $this->RowHtml('Total Amount',$this->model['total_amount']);
		if($this->model['tax'])
			$amount .= $this->RowHtml('Tax',$this->model['tax'],null,null,true);
		$amount .= $this->RowHtml('Gross Amount',$this->model['gross_amount']);
		if($this->model['discount_voucher_amount'])
			$amount .= $this->RowHtml('Discount',$this->model['discount_voucher_amount'],null,null,true);
		$amount .= $this->RowHtml('Net Amount','<b>'.$this->model['net_amount'].'<b/>');

		$this->current_row_html['net_amount'] = $amount;

		$invoice = $this->model->invoice();
		$invoice_html = '<small class="atk-effect-warning">Not Created</small>';
		if($invoice){
			$invoice_html = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Sale Invoice', $this->api->url($this->invoicevp->getURL(),array('sales_invoice_clicked'=>$invoice['id']))).'">'. $invoice['name'] ."</a>".' <small class="atk-swatch-blue">'.$invoice['status']."</small>";
		}
		$invoice_html = $this->RowHtml('Invoice',$invoice_html);

		$this->current_row_html['created_at'] = $this->RowHtml('created Date',$this->model->human_date(),null,$this->model['created_at'],true).$this->RowHtml('created By',$this->model['created_by'],null,null,true).$invoice_html;
		parent::formatRow();
	}

}