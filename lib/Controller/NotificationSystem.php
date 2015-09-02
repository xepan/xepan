<?php

class Controller_NotificationSystem extends AbstractController {
	public $documents = null;
	function getNotification(){
		$this->app->current_employee = $this->add('xHR/Model_Employee');
		$this->app->current_employee->loadFromLogin();

		if(!($rules_documents_array = $this->recall('rules_documents',false))){
			$rules_documents_array=[];
			if(!($rules_documents_array=$this->add('xHR/Model_Document')->getRules())){
				$rules_documents_array = $this->add('xHR/Model_Document')->saveRules();
			}
			$this->memorize('rules_documents',$rules_documents_array);
		}

		session_write_close();

		$activity = $this->add('xCRM/Model_Activity');
		// $q= $activity->dsql();

		$activity->getElement('action_from')->destroy();
		$activity->getElement('action_to')->destroy();
		$activity->getElement('related_document')->destroy();

		// $doc_of_activity = $activity->join('xhr_documents.name','related_document_name');
		// $acl_for_doc = $doc_of_activity->join('xhr_departments_acl.document_id');
		// $acl_for_doc->addField('post_id');
		// $acl_for_doc->addField('can_view');
		// $acl_for_doc->addField('can_approve');

		// $activity->addCondition('post_id',$this->api->current_employee['post_id']);

		$activity->addCondition('id','>',$this->api->current_employee['seen_till']);
		$activity->setOrder('id');
		$activity->setLimit(10);
		// $activity->debug();
		$activity = $activity->getRows();
		$seen_till=0;
		foreach ($activity as $act) {
			$seen_till = $act['id'];
			$my_rules = $rules_documents_array[$act['related_root_document_name']]['rules'][$act['action']];
			if(!is_array($my_rules)) continue;
				foreach ($my_rules as $doc_name_and_action => $message) {
					$temp = explode("/", $doc_name_and_action);
					$temp_class = $temp[0].'/Model_'.$temp[1];
					$temp_action = $temp[2];
					$related_document = $this->add($temp_class)->tryLoad($act['related_document_id']);
					if($related_document->checkif($temp_action)){
						$title=null;
						$type=null;
						$sticky=null;
						if(is_array($message)){
							$title = $message['title']; 
							$type = $message['type']; 
							$sticky = $message['sticky']; 
							$message = $message['message']; 
						}
						

						$this->api->current_employee->updateLastSeenActivity($act['id']);


						$message_text = $this->add('View');
						$message_text->template->loadTemplateFromString($message);

						$message_text->template->set(array_merge($related_document->getRows(),$act));
						$message_text= $message_text->getHTML();
						echo json_encode(['id'=>$act['id'],'message'=>$message_text,'type'=>$type,'title'=>$title , 'sticky'=>$sticky]);
						exit;
					}
					else{
						// echo "Failed <br/>";
					}
				}
		}

		if($seen_till) $this->api->current_employee->updateLastSeenActivity($seen_till);
		

	}

	function prepareSystem(){
		// get Current User Applications
			// store allowed app napespaces in x array

		$acts = $this->add('xCRM/Activity');

		// loop through xhR/Documents that fits you for can_view => d
			// If document namespace is not in x array continue
			// If I have muted notifications for this continue
			// LOAD MODELS OF THE DOCUMENTS AND READ NOTIFICAITON PUBLIC VARIABLE FOR RULES
			// store these document in array da whose to look for in next 
			// store this array in session .. next time just take this
	}

	function setUpMain(){
		// Check User level application access
		// Check Post and AcL
		// Check Tasks also
		// Activity of your can_see_activity document as notifications


		// Check what is required for current user to be notified .. dunno what
		// tu kaun 
		// tereko 
			// kis kis document main 
			// kis kis status pe
			// kis kis transition pe
		// notification ki jaroorat

		// Store this to session

		// Get Updated
		// Set some in array for menus and display instantly
	}

	function setUpLive(){
		// Add Hook in owner (Mostly Document MOdel)
		// before save .. check status and do something  .... $model->data_original 
	}
}