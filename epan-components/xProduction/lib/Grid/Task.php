<?php
namespace xProduction;

class Grid_Task extends \Grid{
	public $ipp=10;
	function init(){
		parent::init();

	}

	function setModel($task_model){
		$m=parent::setModel($task_model,array('created_by','employee_id','employee','subject','content','created_at','name','Priority','expected_start_date','expected_end_date'));
		$this->removeColumn('employee_id');
		$this->removeColumn('team_id');
		$this->removeColumn('subject');
		$this->removeColumn('content');
		$this->removeColumn('created_by');
		$this->removeColumn('employee');
		$this->removeColumn('created_at');
		$this->removeColumn('expected_end_date');
		$this->removeColumn('expected_start_date');
		$this->removeColumn('Priority');

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
		$this->current_row_html['name']=
		"<div class='panel panel-success atk-size-micro '>".
			"<div class='atk-row '>".
					"<div class='atk-col-4 atk-effect-danger '>"
							."Task No.: ".$this->model['name'].'&nbsp;&nbsp'."<b class='btn btn-success btn-xs'>".$this->model['Priority']."</b><br>"
							.date('d M Y',strtotime($this->model['created_at'])).
					"</div>".
					"<div id='opener' class='atk-col-4 text-center atk-button'>
					<b>". $this->model['subject']."</b>
					</div>".
			"</div>".
			"<div class='atk-row'>".
				"<div class='atk-col-6'>".
					"Created By.:- "."<b>".$this->model['created_by']."</b>".	
				"</div>". " ".
				"<div class='atk-col-6 text-right'>".
					"Assign to.:- <b>".$this->model['employee']."</b>".	
				"</div>"."<br>".
				"<div class='atk-col-6'>".
					"Starting Date.:- ".$this->model['expected_start_date'].	
				"</div>".
				"<div class='atk-col-6 text-right'>".
					"Ending Date.:- ".$this->model['expected_end_date'].	
				"</div>".
			"</div>".
										
		"</div>".		


		parent::formatRow();									
	}
}