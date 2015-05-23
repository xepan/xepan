<?php

class Grid_GenericDocument extends \Grid{
	public $content_vp;
	function init(){
		parent::init();
		
		$this->content_vp = $this->add('VirtualPage');
		$this->content_vp->set(function($p){
			$doc_id=$p->api->stickyGET('generic_document_id');
			$m=$p->add('Model_GenericDocument')->load($doc_id);
			$p->add('View')->setHTML($m['content']);
		});


	}
	function format_preview($f){
		$this->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $this->js()->univ()->frameURL('Content',$this->api->url($this->content_vp->getURL(),array('generic_document_id'=>$this->model->id))) .'">'.substr(strip_tags($this->model['content']),0,50).'</a>';
	}

	function format_imagethumb($f){
				$this->current_row_html[$f] = '<img style="height:40px;max-height:40px;" src="'.$this->current_row[$f].'"/>';
	}
	
	function setModel($model,$fields=null){
		if($fields==null){
			$fields = array();
		}
		$m=parent::setModel($model,$fields);

		if($this->hasColumn('item_name'))$this->removeColumn('item_name');
		if($this->hasColumn('created_by'))$this->removeColumn('created_by');
		if($this->hasColumn('related_document'))$this->removeColumn('related_document');
		if($this->hasColumn('updated_date'))$this->removeColumn('updated_date');

		$this->addFormatter('content','preview');
		// $this->addFormatter('content','imagethumb');
		$this->addPaginator(50);
		$this->addSno();
		$this->addQuickSearch(array('title'),null,'Filter_Document');
		
		$btn= $this->addButton("Category Management");
		if(!$btn instanceof \Dummy and $btn->isClicked()){
			$this->js()->univ()->frameURL('Document Category',$this->api->url('owner_documentscategory'))->execute();
		}

		return $m;

	}

	
}