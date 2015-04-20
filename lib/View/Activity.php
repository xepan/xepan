<?php

class View_Activity extends CompleteLister {


	function formatRow(){
		$this->current_row['activity_date'] = $this->add('xDate')->diff(Carbon::now(),$this->model['created_at']);
		
		$panel_html = "";
		$icon_html = "";
		switch ($this->model['action']) {
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
				$panel_html = '<div class="icon-phone atk-swatch-blue">';
				break;

			case 'sms':
				$panel_html = '<div class="panel ">';
				$panel_html = '<div class="icon-mobile atk-swatch-blue">';
				break;

			case 'personal':	
				$panel_html = '<div class="panel">';
				$panel_html = '<div class="icon-user atk-swatch-blue">';
				break;
		}

		//PANEL COLOR  AND ICON CHANGED ACCORDING TO ACTION LIKE GREEN FOR APPROVED AND ICON LOCK
		$this->current_row_html['panel_html'] = $panel_html;
		$this->current_row_html['icon'] = $icon_html;

		//DISPLAY NOTIFY VIA EMAIL  
		$notify_via_email_html = "";
		if($this->model['notify_via_email'])
			$notify_via_email_html = "Notify Via Email ".$this->model['email_to'];

		$this->current_row_html['notify_via_email'] = $notify_via_email_html;
		
		//DISPLAY NOTIFY VIA SMS  
		$notify_via_sms_html = "";
		if($this->model['notify_via_sms'])
			$notify_via_sms_html = "Notify Via SMS ".$this->model['sms_to'];

		$this->current_row_html['notify_via_sms'] = $notify_via_sms_html;

		//DISPLAY ATTACHMENT IF SEND VIA EMAIL
		$attachment_html = " ";
		if($this->model['attachment_id'])
			$attachment_html = '<a target="_blank" href="'.$this->model['attachment'].'"></a>';
		
		$this->current_row_html['attachments'] = $attachment_html;
	}

	function defaultTemplate(){
		return array('view/activity');
	}

}