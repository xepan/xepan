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

		parent::formatRow();									
	}
}