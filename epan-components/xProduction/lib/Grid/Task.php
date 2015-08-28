<?php
namespace xProduction;

class Grid_Task extends \xGrid{
	public $ipp=100;
	public $grid_template='task-grid';
	function init(){
		parent::init();
		$this->task_vp = $this->add('VirtualPage');
		$this->task_vp->set(function($p){
			$task_id=$p->api->stickyGET('task_id');
			$m=$p->add('xProduction/Model_Task')->tryLoad($_GET['task_id']);
			
			$start_date = "";
			if($m['expected_start_date'])
				$start_date = $m['expected_start_date'];

			$end_date = "";
			if($m['expected_end_date'])
				$end_date = $m['expected_end_date'];

			$html = '<div class="atk-row atk-padding page-header">
						<span class="atk-col-4 icon-calendar"> Expected Start Date: '.$start_date.'</span>
						<span class="atk-col-4"><i class="icon-pencil atk-swatch-blue"></i> Created By: '.$m['created_by'].'</span>
						<span class="atk-col-4"> <i class="icon-calendar atk-swatch-red"></i> Dead Line: '.$end_date.'</span>
					</div>'.
					'<div class="atk-padding">'.$m['content'].'</div>'
					;
			$p->add('View')->setHTML($html);
		});
	}

	function setModel($task_model){
		$task_model->getField('name')->caption('Task');
		$m=parent::setModel($task_model,array('created_by','employee_id','employee','subject','content','created_at','name','Priority','expected_start_date','expected_end_date','priority'));
		if($this->hasColumn('employee_id')) $this->removeColumn('employee_id');
		if($this->hasColumn('team_id'))  $this->removeColumn('team_id');
		if($this->hasColumn('subject'))  $this->removeColumn('subject');
		if($this->hasColumn('content'))  $this->removeColumn('content');
		if($this->hasColumn('created_by'))  $this->removeColumn('created_by');
		if($this->hasColumn('employee'))  $this->removeColumn('employee');
		if($this->hasColumn('created_at'))  $this->removeColumn('created_at');
		if($this->hasColumn('expected_start_date'))  $this->removeColumn('expected_start_date');
		if($this->hasColumn('expected_end_date'))  $this->removeColumn('expected_end_date');
		if($this->hasColumn('Priority'))  $this->removeColumn('Priority');

		$this->addFormatter('name','wrap');
		$this->addPaginator($this->ipp);
		
		return $m;
	}

	function formatRow(){
		// $task_v=$this->api->add('xProduction/View_Task',array('task_vp'=>$this->task_vp));
		// $task_v->setModel($this->model);
		// $this->current_row_html['name']=$task_v->getHtml();
		$this->current_row_html['task_subject'] = '<a href="javascript:void(0)" onclick="'.$this->js()->univ()->frameURL($this->model['subject'],$this->api->url($this->task_vp->getURL(),array('task_id'=>$this->model->id))).'">'.substr(strip_tags($this->model['subject']),0,40).'</a>';
		
		$this->template->trySetHtml('created_at',$this->add('xDate')->diff(\Carbon::now(),$this->model['created_at']));

		$icon_html = "";
		switch ($this->model['priority']) {
			case 'Low':
				$icon_html = '<i class="atk-effect-warning">'.$this->model['priority'].'</i>';
				break;

			case 'Medium':
				$icon_html = '<i class="">'.$this->model['priority'].'</i>';
				break;
			case 'High':
				$icon_html = '<i class="atk-effect-info">'.$this->model['priority'].'</i>';
				break;

			case 'Urgent':
				$icon_html = '<i class="atk-effect-danger">'.$this->model['priority'].'</i>';
				break;
		}
				
		$this->current_row_html['priority_icon']  = $icon_html;
		parent::formatRow();		
	}

	function defaultTemplate(){
		return array($this->grid_template);
	}

}