<?php
namespace xProduction;

class Grid_Task extends \Grid{
	public $ipp=10;
	function init(){
		parent::init();

		$this->task_vp = $this->add('VirtualPage');
		$this->task_vp->set(function($p){
			$task_id=$this->api->stickyGET('task_id');
			$m=$p->add('xProduction/Model_Task')->load($task_id);
			$p->add('View')->setHTML('<div class="atk-row">'.
									 	'<div class="atk-col-8  text-center atk-size-mega page-header  ">'.
									 		'<h2 class="atk-size-mega page-header atk-text-bold atk-effect-danger">'.$m['subject'].'</h2>'.
									 	'</div>'.
									 	'<div class="atk-col-4 atk-align-right">'.
									 		'<div class="atk-row page-header">'.
											 	'<div class="atk-col-12 atk-effect-success">'."Starting Date :- ".$m['expected_start_date'].'</div>'.
											 	'<div class="atk-col-12 atk-effect-danger">'."Ending Date :- ".$m['expected_end_date'].'</div>'.
											 	'<div class="atk-col-12 atk-effect-warning">'."Created At :- ".$m['created_at'].'</div>'.
											 	'<div class="atk-col-12 atk-effect-info">'."Created By :-".$m['created_by'].'</div>'.
									 		'</div>'.
									 	'</div>'.
									 '</div>'.'<br/>'.
									 '<div class="well">'.
				$m['content']).'</div>'
			;
		});
	}

	function setModel($task_model){
		$m=parent::setModel($task_model,array('created_by','employee_id','employee','subject','content','created_at','name','Priority','expected_start_date','expected_end_date'));
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
		
		// $task_vp = $this->add('VirtualPage');
		// $task_vp->set(function($p){
		// 	$m=$p->add('xProduction/Model_Task')->tryLoad($_GET['task_id']);
		// 	$p->add('View')->setHTML($m['content'])->addCLass('well');
		// });

		// $this->addMethod('format_subject',function($g,$f)use($task_vp){
		// 	$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$g->js()->univ()->frameURL('Task Content',$g->api->url($task_vp->getURL(),array('task_id'=>$g->model->id))).'">'.$g->current_row[$f].'</a>';
		// });
		// $this->addFormatter('subject','subject');

		return $m;
	}

	function formatRow(){
		$task_v=$this->api->add('xProduction/View_Task',array('task_vp'=>$this->task_vp));
		$task_v->setModel($this->model);
		$this->current_row_html['name']=$task_v->getHtml();
		parent::formatRow();		
	}
}