<?php

namespace xCRM;

class Grid_Ticket extends \Grid{
	public $vp;
	function init(){
		parent::init();

		$this->ticket_vp = $this->add('VirtualPage');
		$this->ticket_vp->set(function($p){
			$ticket_id = $p->api->stickyGET('xcrm_ticket_id');
			
			$m=$p->add('xCRM/Model_Ticket')->load($ticket_id);
			$ticket_view=$p->add('xCRM/View_Ticket',array('model'=>$m));
			//Mark Read Email
			// $m->markRead();
		});
	}

	function format_preview($f){
		$this->current_row_html[$f]='<a href="javascript:void(0)" onclick="'. $this->js()->univ()->frameURL($this->model['subject'],$this->api->url($this->ticket_vp->getURL(),array('id'=>$this->model->id))) .'">'.$this->current_row[$f].'</a>';
	}

	function setModel($model,$fields = array()){
		$model->getElement('subject')->caption('Ticket');
		$m = parent::setModel($model,$fields);

		$this->addQuickSearch($model->getActualFields());
		$this->addPaginator($ipp=50);
		$this->add_sno();
		return $m;
	}

	function formatRow(){
		$assign_html = "";
		$name = '<a href="javascript:void(0)" onclick="'.$this->js(null,$this->js()->_selectorThis()->closest('td')->removeClass('atk-text-bold'))->univ()->frameURL('Ticket ['.$this->model['name'].']',$this->api->url($this->ticket_vp->getURL(),array('xcrm_ticket_id'=>$this->model->id))).'">'.$this->model['name'].'</a>';
		$str = '<div  class="atk-row">';
		//From Customer
		$str.= '<div class="atk-col-3" title="'.$this->model['customer'].'" style="overflow:hidden;   display:inline-block;  text-overflow: ellipsis; white-space: nowrap;">'.$name.'<br/>'.$this->model['customer'].'</div>';
		//Subject
		$str.= '<div class="atk-col-6" style="overflow:hidden; display:inline-block;  text-overflow: ellipsis; white-space: nowrap;" >'.$this->priority().' '.$assign_html.$this->model['subject'].' - ';
		//Message
		$str.= substr(strip_tags($this->model['message']),0,50).'</div>';
		//Attachments
		if($this->model->attachment()->count()->getOne())
			$str.= '<div class="atk-col-1"><i class="icon-attach"></i></div>';
		else
			$str.= '<div class="atk-col-1 text-right"></div>';
		//Date Fields
		$str.= '<div class="atk-col-2 atk-size-micro">'.$this->add('xDate')->diff(\Carbon::now(),$this->model['created_at']).'<br/>'.$this->model['created_at'].'</div>';
		$str.= '</div>';
		
		$this->current_row_html['subject'] = $str;
		parent::formatRow();
	}

	function priority(){
		switch ($this->model['priority']) {
			case 'Low':
			 $class = 'atk-label atk-swatch-ink';
			break;
			case 'Medium':
			 $class = 'atk-label atk-swatch-blue';
			break;
			case 'High':
			 $class = 'atk-label atk-swatch-yellow';
			break;
			case 'Urgent':
			 $class = 'icon-flash atk-label atk-swatch-red';
			break;
		}

		return '<div class=" '.$class.'">'.$this->model['priority'].'</div>';
	}

	function recursiveRender(){

		if($this->hasColumn('message'))$this->removeColumn('message');
		if($this->hasColumn('customer')){
			$this->removeColumn('customer_id');
			$this->removeColumn('customer');
		}
		if($this->hasColumn('priority'))$this->removeColumn('priority');
		if($this->hasColumn('name'))$this->removeColumn('name');

		parent::recursiveRender();
	}
}