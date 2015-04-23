<?php

namespace xHR;
class View_Email extends \View{

	function setModel($model){
		$cc= "";
		if($model['cc'])
			$cc = ", ".$model['cc'];
		$this->template->trySetHTML('email_to',$model['to_email']."".$cc);
		$this->template->trySetHTML('created_at',$model['created_at']);
		$this->template->trySetHTML('subject',$model['subject']);
		$this->template->trySetHTML('email_message',$model['message']);

		if($model['from_id']){
			$this->template->trySetHTML('email_from',$model['from_email']);
		}
		parent::setModel($model);
	}

	function defaultTemplate(){
		return array('view/xemail-message');
	}
}