<?php
namespace xHR;

class Grid_MailParty extends \Grid{
	function init(){
		parent::init();
	}
	
	function setModel($model){
		$m=parent::setModel($model,array('name','customer_name','unread','last_email_on','total_email'));

		if($this->hasColumn('unread'))$this->removeColumn('unread');
		if($this->hasColumn('last_email_on'))$this->removeColumn('last_email_on');
		if($this->hasColumn('total_email'))$this->removeColumn('total_email');
		// $this->addFormatter('customer_name','wrap');

		return $m;
	}
	

	function formatRow(){

		parent::formatRow();									
	}
}