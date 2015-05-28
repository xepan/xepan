<?php

class page_cron_bouncecheck extends Page {
	
	function init(){
		parent::init();


		$cwsMailBounceHandler = new CwsMailBounceHandler();
		$cwsMailBounceHandler->test_mode = true; // default false
		// $cwsMailBounceHandler->debug_verbose = CWSMBH_VERBOSE_DEBUG; // default CWSMBH_VERBOSE_QUIET
		$cwsMailBounceHandler->purge = true; // default false
		//$cwsMailBounceHandler->disable_delete = false; // default false
		//$cwsMailBounceHandler->open_mode = CWSMBH_OPEN_MODE_IMAP; // default CWSMBH_OPEN_MODE_IMAP
		//$cwsMailBounceHandler->move_soft = false; // default false
		//$cwsMailBounceHandler->folder_soft = 'INBOX.soft'; // default 'INBOX.hard' - NOTE: for open_mode IMAP it must start with 'INBOX.'
		//$cwsMailBounceHandler->move_hard = false; // default false
		//$cwsMailBounceHandler->folder_hard = 'INBOX.hard'; // default 'INBOX.soft' - NOTE: for open_mode IMAP it must start with 'INBOX.'
		/**
		* .eml folder
		*/
		//$cwsMailBounceHandler->open_mode = CWSMBH_OPEN_MODE_FILE;
		//if ($cwsMailBounceHandler->openFolder('emls/')) {
		//$cwsMailBounceHandler->processMails();
		//}
		/**
		* .eml file
		*/
		//$cwsMailBounceHandler->open_mode = CWSMBH_OPEN_MODE_FILE;
		//if ($cwsMailBounceHandler->openFile('test/01.eml')) {
		// $cwsMailBounceHandler->processMails();
		//}
		/**
		* Local mailbox
		*/
		//$cwsMailBounceHandler->open_mode = CWSMBH_OPEN_MODE_IMAP;
		//if ($cwsMailBounceHandler->openImapLocal('/home/email/temp/mailbox')) {
		// $cwsMailBounceHandler->processMails();
		//}
		/**
		* Remote mailbox
		*/
		$cwsMailBounceHandler->open_mode = CWSMBH_OPEN_MODE_IMAP;
		$cwsMailBounceHandler->host = 'sun.rightdns.com'; // Mail host server ; default 'localhost'
		$cwsMailBounceHandler->username = 'bounce@xavoc.com'; // Mailbox username
		$cwsMailBounceHandler->password = ''; // Mailbox password
		$cwsMailBounceHandler->port = 993; // the port to access your mailbox ; default 143, other common choices are 110 (pop3), 995 (gmail)
		//$cwsMailBounceHandler->service = 'imap'; // the service to use (imap or pop3) ; default 'imap'
		$cwsMailBounceHandler->service_option = 'ssl'; // the service options (none, tls, notls, ssl) ; default 'notls'
		//$cwsMailBounceHandler->cert = CWSMBH_CERT_NOVALIDATE; // certificates validation (CWSMBH_CERT_VALIDATE or CWSMBH_CERT_NOVALIDATE) if service_option is 'tls' or 'ssl' ; default CWSMBH_CERT_NOVALIDATE
		//$cwsMailBounceHandler->boxname = 'TEST'; // the mailbox to access ; default 'INBOX'
		if ($cwsMailBounceHandler->openImapRemote()) {
			$cwsMailBounceHandler->processMails();
		}
		echo "<pre>";
		print_r($cwsMailBounceHandler->result);
		echo "</pre>";
		$result = $cwsMailBounceHandler->result;
		
		if($result['counter']['processed']){
			foreach ($result['msgs'] as $msg) {
				if($msg['type']=='bounce'){
					foreach ($msg['recipients'] as $receipent) {
						if($receipent['remove']){
							$this->removeEmail($receipent['email']);
						}
					}
				}
			}
		}
	}

	function removeEmail($email){
		echo "removing $email from customers<br/>";
		echo "removing $email from suppliers<br/>";
		echo "removing $email from affiliates<br/>";
		echo "removing $email from employees<br/>";
		echo "removing $email from subscribers<br/>";

		$check = array(
				'xShop/Model_Customer' => array('customer_email','other_emails'),
				'xPurchase/Model_Supplier' => array('email'),
				'xShop/Model_Affiliate' => array('email_id'),
				'xHR/Model_Employee' => array('personal_email','company_email_id'),
				'xEnquiryNSubscription/Model_Subscription' => array('email'),
			);

		$q = $this->api->db->dsql();
		foreach ($check as $model => $fields) {
			foreach ($fields as $f) {
				$or = $q->orExpr($f,'like',"%$email%");
			}
			$this->add($model)
			->addCondition($or)
			->each(function($obj)use($email, $fields){
				foreach ($fields as $f) {
					$emails_count=explode(",", $obj[$f]);
					if(count($emails_count)>1){
						if(($key = array_search($email, $emails_count)) !== false) {
						    unset($emails_count[$key]);
						}
						$obj[$f] = implode(", ", $emails_count);
						$obj->save();
					}else{
						$obj->deactivate();
					}
					// create activity
						// $email has been bounced hard and removed
					$subject = $obj[$f]."has been bounced Hard and Removed";
					$to_arry =explode('\\', $obj->root_document_name());
					$obj->createActivity("action",$subject,"",$from=null,$from_id=null, $to=$to_arry[1], $to_id=$obj->id,$email_to=$obj[$f]);
				}
			});
		}
	}

}