<?php
namespace xHR;

class Grid_OfficialEmail extends \Grid{
	function init(){
		parent::init();


		$this->addColumn('Email_Setting');
		$this->addPaginator(50);
		$this->addQuickSearch(array('status',
						'email_transport',
						'encryption',
						'email_host',
						'email_port',
						'email_username',
						'email_password',
						'imap_email_host',
						'imap_email_port',
						'imap_email_username',
						'imap_email_password',
						'imap_flags',
						'is_support_email'
					));
		// $this->addColumn('IMAP');
	}
	
	function setModel($model,$fields=null){
		if($fields==null){
			$fields = array('status',
						'email_transport',
						'encryption',
						'email_host',
						'email_port',
						'email_username',
						'email_password',
						'imap_email_host',
						'imap_email_port',
						'imap_email_username',
						'imap_email_password',
						'imap_flags',
						'denied_email_subject',
						'denied_email_body',
						'email_body',
						'email_subject',
						'auto_reply',
						'is_support_email',
					);
		}


		$m=parent::setModel($model,$fields);
		if($this->hasColumn('email_transport'))$this->removeColumn('email_transport');
		if($this->hasColumn('encryption'))$this->removeColumn('encryption');
		if($this->hasColumn('email_host'))$this->removeColumn('email_host');
		if($this->hasColumn('email_port'))$this->removeColumn('email_port');
		if($this->hasColumn('email_username'))$this->removeColumn('email_username');
		if($this->hasColumn('email_password'))$this->removeColumn('email_password');
		if($this->hasColumn('imap_email_host'))$this->removeColumn('imap_email_host');
		if($this->hasColumn('imap_email_username'))$this->removeColumn('imap_email_username');
		if($this->hasColumn('imap_email_port'))$this->removeColumn('imap_email_port');
		if($this->hasColumn('imap_email_password'))$this->removeColumn('imap_email_password');
		if($this->hasColumn('imap_flags'))$this->removeColumn('imap_flags');
		if($this->hasColumn('status'))$this->removeColumn('status');
		if($this->hasColumn('denied_email_body'))$this->removeColumn('denied_email_body');
		if($this->hasColumn('denied_email_subject'))$this->removeColumn('denied_email_subject');
		if($this->hasColumn('email_body'))$this->removeColumn('email_body');
		if($this->hasColumn('email_subject'))$this->removeColumn('email_subject');
		if($this->hasColumn('auto_reply'))$this->removeColumn('auto_reply');
		if($this->hasColumn('is_support_email'))$this->removeColumn('is_support_email');
		// $this->addFormatter('name','name11');
		return $m;
	}


	function formatRow(){

		$status = "atk-swatch-green";
		if($this->model['status']!="active")
			$status = "atk-swatch-red";
		
		if($this->model['is_support_email']){
			$support_html = '<span class="icon-comment" title="This is Support Email"></span>';
		}else{
			$support_html = '<span class="icon-comment atk-swatch-red" title="Not a Support Email"></span>';
		}

		if($this->model['auto_reply']){
			$auto_class = "glyphicon glyphicon-send";
			$auto_title = "Auto Reply On";
		}else{
			$auto_class = "glyphicon glyphicon-send atk-swatch-red";
			$auto_title = "Auto Reply Off";
		}

		$auto_send_html = '<span class="'.$auto_class.'" title="'.$auto_title.'"> </span>';

		$str = '<div class="text-center atk-size-giga '.$status.' "> '.$this->model['email_username']." ".$support_html." ".$auto_send_html.'</div>';

		$str .= '<div class="atk-row">';

		$str.= '<div class="atk-col-6">';//OutGoing Email Setting Column1
		$str.= '<h4 class=""> OutGoing </h4>';
		$str.= 'Encryption : '.$this->model['encryption'].'</br>';
		$str.= 'Email Host : '.$this->model['email_host'].'</br>';
		$str.= 'Email Port : '.$this->model['email_port'].'</br>';
		$str.= 'Email TRansport : '.$this->model['email_transport'].'</br>';
		$str.=	'</div>';
		
		$str.= '<div class="atk-col-6">';//Imap Email Setting Column2
		$str.= '<h4 class=""> IMAP/POP3 </h4>';
		$str.= 'Host : '.$this->model['imap_email_host'].'</br>';
		$str.= 'Port : '.$this->model['imap_email_port'].'</br>';
		$str.= 'UserName : '.$this->model['imap_email_username'].'</br>';
		$str.= 'Flags : '.$this->model['imap_flags'].'</br>';
		
		$str.='</div>';
		
		$str.='</div>';


		$this->current_row_html['Email_Setting']=$str;
		parent::formatRow();
	}
}