<?php

namespace xShop;

class Grid_Quotation extends \Grid{
	function init(){
		parent::init();

		$this->addSno();
		$this->vp=$this->add('VirtualPage')->set(function($p){
			$p->api->stickyGET('quotation_clicked');
			$p->add('xShop/View_Quotation',array('quotation'=>$p->add('xShop/Model_Quotation')->tryLoadAny($_GET['quotation_clicked'])));
		});
	}
	
	function format_view($field){
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Quotation', $this->api->url($this->vp->getURL(),array('quotation_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}

	function format_myedit($field){
		if($this->model->status() == 'approved')
			$this->current_row_html[$field]='';
	}
	
	function setModel($quotation_model){
		$m=parent::setModel($quotation_model);
		$this->addFormatter('name','view');
		$this->addColumn('expander','items',array('page'=>'xShop_page_owner_quotation_items','descr'=>'Items'));

		return $m;
	}
	

	}	