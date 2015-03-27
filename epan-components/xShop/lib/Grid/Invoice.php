<?php

namespace xShop;

class Grid_Invoice extends \Grid{
	function init(){
		parent::init();

		//$self= $this;
		$this->addSno();

		// $this->vp=$this->add('VirtualPage')->set(function($p)use($self){
		// 	$p->add('xShop/View_Quotation',array('quotation'=>$p->add('xshop/Model_Quotation')->load($p->api->stickyGET('quotation_clicked'))));
		// });
	}
	
	// function format_view($field){
	// 	$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Quotation', $this->api->url($this->vp->getURL(),array('quotation_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	// }



	// 	$this->addQuickSearch(array('name','status','quotation_no'));
	// 	$this->addPaginator($ipp=50);
	// }

	// function setModel($m){
	// 	parent::setModel($m);

	// 	$self= $this;
	// 	$vp = $this->add('VirtualPage')->set(function($p)use($self){
	// 		$p->add('xShop/View_Quotation',array('quotation'=>$self->add('xShop/Model_Quotation')->load($_GET['quotation_clicked'])));
	// 	});

	// 	$this->js(true)->find('tr')->css('cursor','pointer');
	// 	$this->on('click','tbody td:not(:has(button))',$this->js()->univ()->frameURL('Quotation',array($this->api->url($vp->getURL()),'quotation_clicked'=>$this->js()->_selectorThis()->closest('tr')->data('id'))));
		
		// $this->addFormatter('edit','myedit');

	// function format_myedit($field){
	// 	if($this->model->status() == 'approved')
	// 		$this->current_row_html[$field]='';
	// }
	function setModel($invoice_model){
		$m=parent::setModel($invoice_model,array('name','created_at'));
		//$this->addFormatter('name','view');
		$this->addColumn('expander','items',array('page'=>'xShop_page_owner_invoice_items','descr'=>'Items'));

		return $m;
	}
	

	}	