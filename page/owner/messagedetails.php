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
		$col=$this->add('Columns');
		$msg_detail=$col->addColumn(6);
		$contributers_detail=$col->addColumn(6);

		$v = $msg_detail->app->layout->add('View_Info')->set('Message Detail');		
		$msg_detail->add('View')->set('Name - '.$msg['name']);
		$msg_detail->add('View')->set('From - '.$msg['sender_signature']);
		$msg_detail->add('View')->set('Name Space - '.$msg['sender_namespace']);
		$msg_detail->add('View')->set('Message - '.$msg['message']);

		// $fomentry_model=$this->add('xEnquiryNSubscription/Model_CustomFormEntry')->tryLoad($_GET['form_submittion_id']);
		// $contributers_detail->add('View')->setHTML($fomentry_model['message']);		
		
	}
}		