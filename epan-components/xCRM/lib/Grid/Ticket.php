<?php

namespace xCRM;

class Grid_Ticket extends \Grid{
	public $vp;
	function init(){
		parent::init();

		$this->vp = $this->add('VirtualPage');
		$this->vp->set(function($p){
			$m=$p->add('xCRM/Model_Ticket')->load($_GET['id']);
			$p->add('View')->set('Created '. $p->add('xDate')->diff(\Carbon::now(),$m['created_at']) .', Last Modified '. $p->add('xDate')->diff(\Carbon::now(),$m['updated_at']) )->addClass('atk-size-micro pull-right')->setStyle('color','#555');
			$p->add('HR');
			$p->add('View')->setHTML($m['message']);
		});
	}

	function format_preview($f){
		$this->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $this->js()->univ()->frameURL($this->model['subject'],$this->api->url($this->vp->getURL(),array('id'=>$this->model->id))) .'">'.$this->current_row[$f].'</a>';
	}

	function setModel($model){
		$m = parent::setModel($model,array('name','uid','from',
										'from_id','from_email',
										'from_name','to','to_id',
										'to_email','cc','bcc','subject',
										'message','priority'));

		$this->fooHideAlways('uid');
		$this->fooHideAlways('from_id');
		$this->fooHideAlways('to_id');
		$this->fooHideAlways('cc');
		$this->fooHideAlways('bcc');

		$this->addPaginator(50);
		$this->add_sno();
		$this->addFormatter('message','preview');
		return $m;
	}
}