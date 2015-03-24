<?php
namespace xStore;

class Grid_MaterialRequest extends \Grid{
		function init(){
		parent::init();
		$self= $this;
		$this->addSno();

		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$p->add('xStore/View_MaterialRequest',array('materialrequest'=>$p->add('xStore/Model_MaterialRequest')->load($_GET['material_request_clicked'])));
		});
	}
	
	function format_view($field){		
		$this->current_row_html[$field] = '<a href="#na" onclick="javascript:'.$this->js()->univ()->frameURL('Material Request', $this->api->url($this->vp->getURL(),array('material_request_clicked'=>$this->model->id))).'">'. $this->current_row[$field] ."</a>";
	}


	function setModel($model){
		$m=parent::setModel($model,array('name','created_by','from_department','forwarded_to'));
		$this->addFormatter('name','view');
		return $m;
	}
}
