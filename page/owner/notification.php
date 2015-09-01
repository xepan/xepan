<?php

class page_owner_notification extends page_base_owner{
		function init(){
			parent::init();
			
			set_time_limit(60);

			while(true){
				$this->add('Controller_NotificationSystem')->getNotification();
				sleep(1);	
			}
		}
}