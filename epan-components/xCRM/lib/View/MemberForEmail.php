<?php

namespace xCRM;

class View_MemberForEmail extends \CompleteLister{
	public $model;
	public $member_type;
	public $sno=1;
	public $panel_open="off";

	function init(){
		parent::init();

		if(!$this->model){
			$this->add('View_Warning')->set('Pass One Of Model Customer, Supplier or affiliate');
		}
		
		$this->model->_dsql()->order(array('unread desc','last_email_on desc'));
		$this->setModel($this->model);
		$this->template->trySetHtml('member_type',$this->member_type);

		$this->js(true)->_selector('.xcrm-member')->xtooltip();
	}

	function setModel($model){
		parent::setModel($model);	
	}

	function formatRow(){
		$member_name="";
		if($this->member_type=="Customer")
			$member_name = $this->model['customer_name'];
		elseif($this->member_type=="Supplier")
			$member_name = $this->model['name'];
		elseif($this->member_type=="Affiliate") 
			$member_name = $this->model['name'];

		$this->current_row_html['member_name'] = $member_name;

		if($this->model['unread'])
			$this->current_row_html['unread_email'] = '<span class="badge atk-swatch-green" title="Unread Emails">'.$this->model['unread'].'</span>';
		else
			$this->template->tryDel('unread_email');

		if($this->panel_open == "on")
			$this->template->trySetHtml('panel_open','in');

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
		return array('view/xcrm-memberforemail');
	}


}