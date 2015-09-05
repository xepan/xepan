<?php

namespace xHR;
class View_Email extends \View{
	public $email=null;

	function init(){
		parent::init();

		if($this->email)
			$this->setModel($this->email);

	}

	function setModel($model){
		$cc= "";
		if($model['cc'])
			$cc = ", ".$model['cc'];
		$this->template->trySetHTML('email_to',$model['to_email']."".$cc);
		$this->template->trySetHTML('created_at',$model['created_at']);
		$this->template->trySetHTML('subject',$model['subject']);
		$this->template->trySetHTML('email_message',$model['message']);

		$from_email = "From: ";
		$from_email .= $model->fromMemberName();
		if($model['from_name'])
			$from_email .= " < ".$model['from_name'].' > ';
		$from_email .= $model['from_email'];

		$this->template->trySetHTML('email_from',$from_email);

		$attachment_html = "";
		// $att = $this->add('Model_Attachment')->addCondition('related_document_id',$model->id)->addCondition('related_root_document_name','xCRM\Email');

		foreach($model->attachment() as $attachment){
			$attachment_html .= '<br/><a target="_blank" href="'.$attachment['attachment_url'].'">'.$attachment->ref('attachment_url_id')->get('original_filename').'</a>'; 
		}

		$this->template->setHTML('attachment',$attachment_html);

		parent::setModel($model);
	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		return array('view/xemail-message');
	}

	function getAttachmentHtml(){

	}

}