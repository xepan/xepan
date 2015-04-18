<?php
namespace xHR;

class Grid_MailParty extends \Grid{
	function init(){
		parent::init();
	}
	function setModel($model){
		$m=parent::setModel($model,array('name','customer_name','unread'));

		$this->removeColumn('unread');
		// $this->addFormatter('customer_name','wrap');

		return $m;
	}

	function formatRow(){
		$this->current_row_html['customer_name']=$this->model['customer_name']."  " ."<small class='atk-effect-danger'>"."(  ".$this->model['unread'] ."  )"."</small>";
		$this->current_row_html['name']=$this->model['name']."  " ."<small class='atk-effect-info'>"."(  ".$this->model['unread'] ."  )"."</small>";

		parent::formatRow();									
	}
}