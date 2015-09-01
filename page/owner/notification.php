<?php

class page_owner_notification extends page_base_owner{
		function init(){
			parent::init();

			set_time_limit(30);
			while(true){
				$this->add('Controller_NotificationSystem')->getNotification();
				usleep(1000);
			}
		}
}