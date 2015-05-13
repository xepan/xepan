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
						'imap_flags'
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
						'imap_flags'
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
		// $this->addFormatter('name','name11');
		return $m;
	}


	function formatRow(){

		$status = "atk-swatch-green";
		if($this->model['status']!="active")
			$status = "atk-swatch-red";
		
		$str = '<div class="text-center atk-size-giga '.$status.' "> Email Transport :: '.$this->model['email_transport'].'</div>';
		$str .= '<div class="atk-row">';

		$str.= '<div class="atk-col-6">';//OutGoing Email Setting Column1
		$str.= '<h4 class=""> OutGoing </h4>';
		$str.= 'Encryption : '.$this->model['encryption'].'</br>';
		$str.= 'Email Host : '.$this->model['email_host'].'</br>';
		$str.= 'Email Port : '.$this->model['email_port'].'</br>';
		$str.= 'Email UserName : '.$this->model['email_username'].'</br>';
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