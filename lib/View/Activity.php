<?php

class View_Activity extends View {

	function setModel($model){
		//Set Date
		$this->template->trySetHtml('activity_date',$this->add('xDate')->diff(Carbon::now(),$model['created_at']));

		$panel_html = "";
		$icon_html = "";
		switch ($model['action']) {
			case 'created':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-lock-open"></i>';
				break;

			case 'submitted':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-lock"></i>';
				break;

			case 'approved':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-lock atk-swatch-green"></i>';
				break;

			case 'rejected':
				$panel_html = '<div class="panel atk-swatch-black">';
				$icon_html = '<i class="icon-cancel"></i>';
				break;

			case 'redesign':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-edit btn btn-warning"></i>';
				break;

			case 'canceled':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-trash atk-swatch-red"></i>';
				break;

			case 'forwarded':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-forward atk-swatch-green"></i>';
				break;

			case 'reply':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-comment atk-swatch-blue"></i>';
				break;

			case 'received':
				$panel_html = '<div class="panel ">';
				$icon_html = '<i class="icon-lock atk-swatch-green"></i>';
				break;

			case 'processed':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-ok atk-swatch-green"></i>';
				break;
			
			case 'active':
				$panel_html = '<div class="panel atk-swatch-green">';
				break;

			case 'completed':	
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="glyphicon glyphicon-flag atk-swatch-green"></i>';
				break;

			case 'comment':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-comment atk-swatch-blue"></i>';
				break;
			
			case 'email':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-mail atk-swatch-blue"></i>';
				break;

			case 'call':
				$panel_html = '<div class="panel">';
				$icon_html = '<i class="icon-phone atk-swatch-blue"></i>';
				break;

			case 'sms':
				$panel_html = '<div class="panel ">';
				$icon_html = '<i class="icon-mobile atk-swatch-blue"></i>';
				break;

			case 'personal':	
				$panel_html = '<div class="panel">';
				$icon_html = '<div class="icon-user atk-swatch-blue">';
				break;
		}

		//PANEL COLOR  AND ICON CHANGED ACCORDING TO ACTION LIKE GREEN FOR APPROVED AND ICON LOCK
		// $this->current_row_html['panel_html'] = $panel_html;
		$this->template->trySetHtml('action_icon',$icon_html);
		$this->template->trySetHtml('action_name',$model['action']);
		$this->template->trySetHtml('action_name',$model['action']);
		$this->template->trySetHtml('action_from',$model['action_from']);

		//DISPLAY NOTIFY VIA EMAIL 
		$notify_via_email_html = "";
		if($model['notify_via_email'])
			$notify_via_email_html = '<div class="atk-move-right atk-box-small"><i class="atk-swatch-green icon-mail"></i> Notify Via Email: '.$model['email_to'].'</div>';

		$this->template->trySetHtml('notify_via_email', $notify_via_email_html);
		
		//DISPLAY NOTIFY VIA SMS  
		$notify_via_sms_html = "";
		if($model['notify_via_sms'])
			$notify_via_sms_html = '<div class="atk-move-right atk-box-small"><i class="atk-swatch-green icon-phone"></i> Notify Via SMS: '.$model['sms_to'].'</div>';

		$this->template->trySetHtml('notify_via_sms',$notify_via_sms_html);

		//DISPLAY ATTACHMENT IF SEND VIA EMAIL
		$attachment_html = " ";
		if($this->model['attachment_id'])
			$attachment_html = '<a target="_blank" href="'.$model['attachment'].'"></a>';
		
		$this->template->trySetHtml('attachments',$attachment_html);

		//Subject 
		$this->template->trySetHtml('subject',$model['subject']);
		$this->template->trySetHtml('message',$model['message']);
		
		//Load Actor Image
		//<img class="img-box atk-shape-rounded"></img>
		$img = '<span class="img-box glyphicon glyphicon-user atk-size-yotta text-center" style="width:100%;"></span>';
		$this->template->trySetHtml('actor_img',$img);

		$attachment = "";
		foreach ($model->attachments() as $attachment) {
			$attachment .='<a target="_blank" href="'.$attachment['attachment_url'].'"></a>';
		}
		
		$this->template->trySetHtml('attchments',$attachment);
	}


	function defaultTemplate(){
		return array('view/activity');
	}

}