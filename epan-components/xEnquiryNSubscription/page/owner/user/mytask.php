<?php

class page_xEnquiryNSubscription_page_owner_user_mytask extends page_xEnquiryNSubscription_page_owner_main{
	
	function init(){
		parent::init();

		$this->add('View_Error')->set('my All Task Here');

	}
}