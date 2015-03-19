<?php

namespace xShop;

class Grid_Quotation extends \Grid{
	function init(){
		parent::init();

		$this->addQuickSearch(array('name','status','quotation_no'));
		$this->addPaginator($ipp=50);
	}

	function setModel($m){
		parent::setModel($m);

		$self= $this;
		$vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xShop/View_Quotation',array('quotation'=>$self->add('xShop/Model_Quotation')->load($_GET['quotation_clicked'])));
		});

		$this->js(true)->find('tr')->css('cursor','pointer');
		$this->on('click','tbody td:not(:has(button))',$this->js()->univ()->frameURL('Quotation',array($this->api->url($vp->getURL()),'quotation_clicked'=>$this->js()->_selectorThis()->closest('tr')->data('id'))));
		
		$this->addColumn('expander','items',array('page'=>'xShop_page_owner_quotation_items','descr'=>'Items'));
		// $this->addFormatter('edit','myedit');
	}

	function format_myedit($field){
		if($this->model->status() == 'approved')
			$this->current_row_html[$field]='';
	}
	

}	