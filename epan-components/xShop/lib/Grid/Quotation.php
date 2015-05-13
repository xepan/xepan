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
			$p->add('xShop/View_Quotation',array('quotation'=>$p->add('xShop/Model_Quotation')->load($_GET['quotation_clicked'])));
		});

		$print = $this->addColumn('Button','print');
		if($_GET['print']){
			$this->js()->univ()->newWindow($this->api->url('xShop_page_owner_printquotation',array('quotation_id'=>$_GET['print'],'cut_page'=>0)))->execute();
		}
	}
	
	function format_view($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Quotation', $this->api->url($this->vp->getURL(),array('quotation_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}

	function format_myedit($field){
		if($this->model->status() == 'approved')
			$this->current_row_html[$field]='';
	}
	
	function setModel($quotation_model,$field=array()){
		if(empty($field))
			$field = array('to','quotation_number','name','customer','lead','opportunity','total_amount','tax','gross_amount','discount_voucher_amount','net_amount');
		
		$m=parent::setModel($quotation_model,$field);
		$this->addFormatter('name','view');

		$this->addMethod('format_to',function($g,$f){
				$g->current_row[$f]=$g->current_row['lead']? '(L) '.$g->current_row['lead']: '(C) '.$g->current_row	['customer'];
			});
		$this->addColumn('to','to');
		$this->addColumn('expander','items',array('page'=>'xShop_page_owner_quotation_items','descr'=>'Items'));
		
		$this->removeColumn('customer');
		$this->removeColumn('opportunity');
		$this->removeColumn('lead');
		
		return $m;
	}
	

	}	