<?php
namespace xHR;

class Grid_MailParty extends \Grid{
	function init(){
		parent::init();
	}
	
	function setModel($model){
		$m=parent::setModel($model,array('name','customer_name','unread','last_email_on'));

		$this->removeColumn('unread');
		$this->removeColumn('last_email_on');
		// $this->addFormatter('customer_name','wrap');

		return $m;
	}
	

	function formatRow(){

		parent::formatRow();									
	}
}