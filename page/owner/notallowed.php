<?php

class page_owner_notallowed extends page_base_owner{
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Your not Authorized to Access this <small> Adding is not Allowed </small>');
	}
	
}