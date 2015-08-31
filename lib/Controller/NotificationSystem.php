<?php

class Controller_NotificationSystem extends AbstractController {
	function init(){
		parent::init();

		/*
			What documents I can View
			What status of those document I can do what actions

			Create that array first 
			d_array =[
				related_document_root_name => [
						in_status => [
									enter => [action1,action2],
									life => []
								]
						]
			]


			Activity that's related document root name is in d_array
			And Last Seen is less then activity created_at

		*/


		/*
			Get my Last seen time
			Get my getColleagues, getSubordinats, getTeams

			Activities COUNT that's last seen is greater then my last seen
			and that's can_view is permission is as per Controller_Acl line 425
			in SQL mode ->expr() ;)

			group by root_document_name, document_name

		*/

		/*
			RULE BASED Notifications :
			define rules in models
				$notification_rules = 	[
											on_activity_action_this('submitted') => ['Document\Namespace'=>[
																			'can_approve' => '{count} DocumentName(s) to approve '
																			'can_view'=>'You have {count} Submitted Documents',
																			]
																		],
											'rejected'=> 	['Document\Rejected'
																'creator' => 'Your Document is rejected, please review {$message}'
															]
										]
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