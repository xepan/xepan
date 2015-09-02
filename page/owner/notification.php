<?php

class page_owner_notification extends page_base_owner{
		function init(){
			parent::init();

			set_time_limit(30);
			$ns=$this->add('Controller_NotificationSystem');
			while(true){
				$ns->getNotification();
				usleep(1000);
			}
			exit;
		}
}