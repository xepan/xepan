<?php

namespace xShop;
class Grid_Opportunity extends \Grid{
	function init(){
		parent::init();
		$this->addPaginator($ipp=50);
		$this->add_sno();

	}
	function setModel($model,$fields=array()){
		if(!count($fields))
			$fields = array();
		
		$m = parent::setModel($model,$fields);

		// $this->addColumn('from','from');
		
		if($this->hasColumn('item_name')) $this->removeColumn('item_name');
		if($this->hasColumn('status')) $this->removeColumn('status');
		if($this->hasColumn('created_date')) $this->removeColumn('created_date');
		if($this->hasColumn('related_document')) $this->removeColumn('created_date');
		if($this->hasColumn('lead')) $this->removeColumn('lead');
		if($this->hasColumn('customer')) $this->removeColumn('customer');


		$this->addQuickSearch($fields);
		return $m;
	}

	function recursiveRender(){
		$this->fooHideAlways('opportunity');
		parent::recursiveRender();
	}
	function format_from(){
		$this->current_row['from'] = $this->current_row['lead']? '(L) ' . $this->current_row['lead'] :  '(C) ' . $this->current_row['customer'];
	}

	function formatRow(){
		$class="";
		if($this->model['status'] == 'active')
			$class="atk-effect-info";
		elseif($this->model['status']=='converted')
			$class="atk-effect-success";
		elseif($this->model['status']=='dead')
			$class="atk-effect-danger";

		$this->setTDParam('name','class',$class);
		$this->setTDParam('name','title',$this->model['status']);
		// $name="";
		$name = '<div class="atk-row">';
		$name .= '<div class="atk-col-4">'.$this->model['name'].'</div>';
		$name .= '<div title="'.$this->model['opportunity'].'"class="atk-col-5" style="text-overflow: ellipsis;overflow:hidden;white-space:nowrap;border:0px solid #000;width:200px;">'.$this->model['opportunity'].'</div>';
		$name .= '<div class="atk-col-3">'.'<div class="pull-right">'.$this->model['created_date'].'</div></div>';
		$name.= '</div>';
		
		$this->current_row_html['name'] = $name;
		parent::formatRow();
	}
}