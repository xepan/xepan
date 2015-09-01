<?php

class page_owner_notification extends page_base_owner{
		function init(){
			parent::init();
			
			set_time_limit(5);

			while(true){
				if(!$this->add('Controller_NotificationSystem')->getNotification()){
					echo json_encode([]);
					exit;
				}
				sleep(1);	
			}
		}
}