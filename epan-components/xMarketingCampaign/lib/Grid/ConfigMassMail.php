<?php
namespace xMarketingCampaign;
class Grid_ConfigMassMail extends \Grid{
	function init(){
		parent::init();
		$this->addPaginator($ipp=10);
		$this->add_sno();
	}
	function setModel($model){
		$m = parent::setModel($model,array('email_transport','encryption','email_host','email_port','email_username','email_password','is_active','email_reply_to','email_reply_to_name','from_email','from_name','sender_email','sender_name','return_path','smtp_auto_reconnect','email_threshold'));
		if($this->hasColumn('email_port')) $this->removeColumn('email_port');
		if($this->hasColumn('email_password')) $this->removeColumn('email_password');
		if($this->hasColumn('email_reply_to')) $this->removeColumn('email_reply_to');
		if($this->hasColumn('from_email')) $this->removeColumn('from_email');
		if($this->hasColumn('sender_email')) $this->removeColumn('sender_email');

		$this->addFormatter('email_host','wrap');
		$this->addFormatter('email_reply_to_name','wrap');
		$this->addFormatter('from_name','wrap');
		$this->addFormatter('sender_name','wrap');

		$this->fooHideAlways('email_transport');
		$this->fooHideAlways('encryption');
		$this->fooHideAlways('smtp_auto_reconnect');
		$this->fooHideAlways('email_threshold');

		return $m;
	}
	function formatRow(){
		$this->current_row_html['email_host']=$this->model['email_host'].":".$this->model['email_port'];
		$this->current_row_html['email_reply_to_name']=$this->model['email_reply_to_name']." <br/>".$this->model['email_reply_to'];
		$this->current_row_html['from_name']=$this->model['from_name']."<br/>".$this->model['from_email'];
		$this->current_row_html['sender_name']=$this->model['sender_name']."<br/>".$this->model['sender_email'];
		parent::formatRow();
	}
}