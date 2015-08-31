<?php

class Controller_NotificationSystem extends AbstractController {
	function init(){
		parent::init();

		/*
			What documents I can View
			What status of those document I can do what actions

			Create that array first 
			[
				doc_id=>[
						in_status=>[
								action1,action2
								]
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