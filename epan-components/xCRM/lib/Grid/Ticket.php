<?php

namespace xCRM;

class Grid_Ticket extends \Grid{
	public $vp;
	function init(){
		parent::init();

		$this->vp = $this->add('VirtualPage');
		$this->vp->set(function($p){
			$m=$p->add('xCRM/Model_Ticket')->load($_GET['id']);
			$p->add('View')->set('Created '. $p->add('xDate')->diff(\Carbon::now(),$m['created_at']) .', Last Modified '. $p->add('xDate')->diff(\Carbon::now(),$m['updated_at']) )->addClass('atk-size-micro pull-right')->setStyle('color','#555');
			$p->add('HR');
			$p->add('View')->setHTML($m['message']);
		});
	}

	function format_preview($f){
		$this->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $this->js()->univ()->frameURL($this->model['subject'],$this->api->url($this->vp->getURL(),array('id'=>$this->model->id))) .'">'.$this->current_row[$f].'</a>';
	}

	function setModel($model,$fields = array()){
		$m = parent::setModel($model,$fields);

		if($this->hasColumn('message'))$this->addFormatter('message','preview');
		if($this->hasColumn('customer_id'))$this->removeColumn('customer_id');

		$this->addQuickSearch($model->getActualFields());
		$this->addPaginator($ipp=50);
		$this->add_sno();
		return $m;
	}

	function formatRow(){
		$assign_html = "";
		//Read Or Unread Emails
		//Check for Email is Incomening or OutGoing
		$this->current_row_html['subject'] = $this->model['subject'];
		parent::formatRow();
	}


	function recursiveRender(){
		parent::recursiveRender();
	}
}