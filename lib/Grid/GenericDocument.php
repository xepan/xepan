<?php

class Grid_GenericDocument extends \Grid{
	public $content_vp;
	public $cat_vp;
	function init(){
		parent::init();
		
		$this->content_vp = $this->add('VirtualPage');
		$this->content_vp->set(function($p){
			$doc_id=$p->api->stickyGET('generic_document_id');
			$m=$p->add('Model_GenericDocument')->load($doc_id);
			$p->add('View')->setHTML($m['content']);
		});


		$this->cat_vp = $this->add('VirtualPage');
		$this->cat_vp->set(function($p){
		$status=$p->api->stickyGET('status');
		$cat=$p->add('Model_GenericDocumentCategory')->addCondition('status',$status);
		$crud=$p->add('CRUD');
		$crud->setModel($cat);
		$grid=$crud->grid;
		$grid->removeColumn('item_name');
		$grid->removeColumn('created_by');
		$grid->removeColumn('related_document');
		});


	}

	function formatRow(){
		parent::formatRow();
		if($this->model->hasElement('share_mode')){
			if($this->model['share_mode']=='view-only'){
				$this->current_row_html['edit']='';
			}
		}

		if(in_array($this->model['status'],['public','departmental'])){
			if(!$this->model['allow_edit_other'] && $this->model['created_by_id'] != $this->api->current_employee->id){
				$this->current_row_html['edit']='';
				$this->current_row_html['delete']='';
			}

		}

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
		if(!$this->hasColumn('share_mode') && $this->hasColumn('created_by')) $this->removeColumn('created_by');
		if($this->hasColumn('related_document'))$this->removeColumn('related_document');
		if($this->hasColumn('updated_date'))$this->removeColumn('updated_date');
		if($this->hasColumn('share_mode'))$this->removeColumn('share_mode');

		$this->addFormatter('content','preview');
		// $this->addFormatter('content','imagethumb');
		$this->addPaginator(50);
		$this->addSno();
		$flt=$this->addQuickSearch(array('name'),null,'Filter_Document');
		$flt->doc_cat_field->getModel()->addCondition('status',$model['status']);
		
		$btn= $this->addButton("Category Management");
		if(!$btn instanceof \Dummy and $btn->isClicked()){
			$this->js()->univ()->frameURL('Document Category',$this->api->url($this->cat_vp->getURL(),array('status'=>$model['status'])))->execute();
		}

		return $m;

	}

	
}