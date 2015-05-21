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

		$from_email = "";
		$from_email .= $model->fromMemberName();
		$from_email .= $model['from_name'].'<br/>';
		$from_email .= $model['from_email'];

		$this->template->trySetHTML('email_from',$from_email);

		$attachment_html = "";
		$att = $this->add('Model_Attachment')->addCondition('related_document_id',$this->id)->addCondition('related_root_document_name','xCRM\Email');
		foreach($att as $attachment){
			$attachment_html .= '<a target="_blank" href="'.$attachment['attachment_url'].'">'.$attachment['attachment_url'].'111</a>'; 
		}

		$this->template->setHTML('attachment',$attachment_html);

		parent::setModel($model);
	}

	function defaultTemplate(){
		return array('view/xemail-message');
	}

	function getAttachmentHtml(){

	}

}