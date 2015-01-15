<?php
class page_owner_messagedetails extends page_base_owner{
	function init(){
		parent::init();
		if($_GET['message_id']){
			$msg=$this->add('Model_Messages')->load($_GET['message_id']);
			try{
				$this->add('View')->set('Created '. $this->add('xDate')->diff(Carbon::now(),$msg['created_at']) )->addClass('atk-size-micro pull-right')->setStyle('color','#555');
				}catch(Exception $e){
					echo $e->getMessage();
				}
		}
			
		$this->add('HR');
		$v = $this->app->layout->add('View_Info')->set('Message Detail');		
		$this->add('View')->set('Name - '.$msg['name']);
		$this->add('View')->set('From - '.$msg['sender_signature']);
		$this->add('View')->set('Name Space - '.$msg['sender_namespace']);
		$this->add('View')->set('Message - '.$msg['message']);

		
	}
}		