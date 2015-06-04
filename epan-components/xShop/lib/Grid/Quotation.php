<?php

namespace xShop;

class Grid_Quotation extends \Grid{
	function init(){
		parent::init();
		$this->addQuickSearch(array('name','lead','created_by','status'));
		$this->addPaginator($ipp=50);
		$this->addSno();
		
		$this->vp=$this->add('VirtualPage')->set(function($p){
			$p->api->stickyGET('quotation_clicked');
			$p->add('xShop/View_Quotation',array('quotation'=>$p->add('xShop/Model_Quotation')->load($_GET['quotation_clicked']),'show_customfield'=>true,'show_specification'=>true));
		});

		$print = $this->addColumn('Button','print');
		if($_GET['print']){
			$this->js()->univ()->newWindow($this->api->url('xShop_page_owner_printquotation',array('quotation_id'=>$_GET['print'],'cut_page'=>0)))->execute();
		}
	}
	
	function format_view($field){
		$to = $this->model['lead']? '(L) '.$this->model['lead']: '(C) '.$this->model['customer'];

		if($this->model['quotationitem_count']==0){
			$this->setTDParam($field, 'class', ' atk-swatch-yellow ');
		}else{
			$this->setTDParam($field, 'class', '');
		}


		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Quotation', $this->api->url($this->vp->getURL(),array('quotation_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>".'<br><small style="color:gray;">'.$to.'</small>';
	}

	function format_myedit($field){
		if($this->model->status() == 'approved')
			$this->current_row_html[$field]='';
	}
	
	function setModel($quotation_model,$field=array()){
		if(empty($field))
			$field = array('quotation_number','name','customer','lead','opportunity','total_amount','tax','gross_amount','discount_voucher_amount','net_amount','quotationitem_count');
		
		$m=parent::setModel($quotation_model,$field);

		$this->addMethod('format_to',function($g,$f){
				$g->current_row[$f]=$g->current_row['lead']? '(L) '.$g->current_row['lead']: '(C) '.$g->current_row	['customer'];
			});
		$this->addColumn('to','to');
		$this->addColumn('expander','items',array('page'=>'xShop_page_owner_quotation_items','descr'=>'Items'));
		
		$this->addFormatter('name','Wrap,view');
		
		if($this->hasColumn('customer'))$this->removeColumn('customer');
		if($this->hasColumn('opportunity'))$this->removeColumn('opportunity');
		if($this->hasColumn('lead'))$this->removeColumn('lead');
		if($this->hasColumn('to'))$this->removeColumn('to');
		
		if($this->hasColumn('tax'))$this->removeColumn('tax');
		if($this->hasColumn('gross_amount'))$this->removeColumn('gross_amount');
		if($this->hasColumn('discount_voucher_amount'))$this->removeColumn('discount_voucher_amount');
		if($this->hasColumn('net_amount'))$this->removeColumn('net_amount');
		if($this->hasColumn('quotationitem_count'))$this->removeColumn('quotationitem_count');

		return $m;
	}

	function formatRow(){
		$hr = '<hr style="margin:0px;">';
		$amount = '<div class="atk-row atk-size-micro">';
			$amount .= '<div class="atk-col-4">';
				$amount.= 'Total Amount<br/>';
				if($this->model['tax']>0)	
					$amount.= 'Tax'.$hr;
				$amount.= 'Gross Amount<br/>';
				if($this->model['discount_voucher_amount']>0)	
					$amount.= 'Discount Amount'.$hr;;
				$amount.= 'Net Amount';
			$amount .= '</div>';
			
			$amount .= '<div class="atk-col-8 pull-right">';
				$amount .= $this->model['total_amount'].'<br/>';
				if($this->model['tax']>0)
					$amount .= $this->model['tax'].$hr;
				$amount .= $this->model['gross_amount'].'<br/>';
				if($this->model['discount_voucher_amount']>0)
					$amount .= $this->model['discount_voucher_amount'].$hr;
				$amount .= $this->model['net_amount'];
			$amount .= '</div>';
		$amount .= '</div>';

		$this->current_row_html['total_amount'] = $amount; 

		parent::formatRow();		
	}

}	