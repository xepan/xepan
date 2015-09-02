<?php

class Controller_NotificationSystem extends AbstractController {
	public $documents = null;
	function getNotification(){
		$this->app->current_employee = $this->add('xHR/Model_Employee');
		$this->app->current_employee->loadFromLogin();

		if(!($rules_documents_array = $this->recall('rules_documents',false))){
			$this->documents =  $this->add('xHR/Model_Document')->getDefaults();
			$rules_documents_array=[];

			foreach ($this->documents as $doc) {
				$class = explode("\\", $doc['name']);
				if(count($class) == 1)
					$class='Model_'.$class[0];
				else
					$class=$class[0].'/Model_'.$class[1];
				try{
					$obj = $this->add($class);
					$rules_documents_array[$doc['name']] = ['table'=>$obj->table,'rules'=>$obj->notification_rules];
				}catch(Exception $e){

				}
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
		// $activity->debug();
		$seen_till=0;
		foreach ($activity as $act) {
			$seen_till = $act['id'];
			$my_rules = $rules_documents_array[$act['related_document_name']]['rules'][$act['action']];
			if(!is_array($my_rules)) continue;
				foreach ($my_rules as $doc_name_and_action => $message) {
					$temp = explode("/", $doc_name_and_action);
					$temp_class = $temp[0].'/Model_'.$temp[1];
					$temp_action = $temp[2];
					$related_document = $this->add($temp_class)->tryLoad($act['related_document_id']);
					if($act->checkif($temp_action,$related_document)){
						$title=null;
						$type=null;
						$sticky=null;
						if(is_array($message)){
							$title = $message['title']; 
							$type = $message['type']; 
							$sticky = $message['sticky']; 
							$message = $message['message']; 
						}
						$this->api->current_employee->updateLastSeenActivity($act->id);
						$message_text = $this->add('View');
						$message_text->template->loadTemplateFromString($message);
						$message_text->setModel($related_document);
						$message_text= $message_text->getHTML();
						echo json_encode(['id'=>$act->id,'message'=>$message_text,'type'=>$type,'title'=>$title , 'sticky'=>$sticky]);
						exit;
					}
					else{
						// echo "Failed <br/>";
					}
				}
		}

		if($seen_till) $this->api->current_employee->updateLastSeenActivity($seen_till);
		
		/*
			RULE BASED Notifications :

			Get my Last seen time
			Get my getColleagues, getSubordinats, getTeams

			Current Employee .. all documents ACL/Permissions (can_view,can_approve => self, all , ???) .. Get all documents that emp can_view


			Get Rules from all those documents

			define rules in models
				$notification_rules[related_root_name] = 	[
											on_activity_action_this('submitted') => ['Document\Namespace'=>[
																			'can_approve' => '{count} DocumentName(s) to approve '
																			'can_view'=>'You have {count} Submitted Documents',
																			]
																		],
											'rejected'=> 	['Document\Rejected'
																'creator' => 'Your Document is rejected, please review {$message}'
																'last_status_changer' => '',
																'last_activity_by_employee' => 'sk  jfhskghj dkfgjh'
															],
											'email' => [
															'super_users' => 'EMail to {customer} about {document_detail} sent',
															'department_top_post' => 'EMail to {customer} about {document_detail} sent',
														]
										]


			$ativities
					-> IF(related_root_name == $d_array->key ) 
		*/

		/*

			examples: 
				1. QuotationDraft -> action -> submitted : 
													Those who can_approve SubmittedQuotation
													And this quotation satisfies can_approve condition of this employee
														created_by_id in as per can_approve condition Controller_Acl / 465 line
		*/

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