<?php

class Controller_Sms extends AbstractController{
	function sendMessage($no,$msg){
		$curl=$this->add('Controller_CURL');
		$msg=urlencode($msg);

		$gateway_url = $this->api->current_website['gateway_url'];
		$username = $this->api->current_website['sms_username'];
		$password = $this->api->current_website['sms_password'];
		$q_username = $this->api->current_website['sms_user_name_qs_param'];
		$q_password = $this->api->current_website['sms_password_qs_param'];
		$q_no = $this->api->current_website['sms_number_qs_param'];
		$q_msg = $this->api->current_website['sm_message_qs_param'];

		// $url="http://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&msg_type=TEXT&v=1.1&auth_scheme=plain&format=text&userid=*****&password=****&send_to=$no&msg=$msg";
		$url = $gateway_url . "$q_username=$username&$q_password=$password&$q_no=$no&$q_msg=$msg";
		ob_start();
			$curl->get($url);
		return ob_get_contents();
	}
}