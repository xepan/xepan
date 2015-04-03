<?php

class page_xHR_page_owner_leave_leavetype extends page_xHR_page_owner_main{
	function init(){
		parent::init();

		$this->add('View_Success')->set('Leave Type Here Todoooo');

		$crud=$this->add('CRUD');
		$crud->setModel('xHR/LeaveType');
	}
}