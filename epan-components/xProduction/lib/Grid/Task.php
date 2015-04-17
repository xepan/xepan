<?php
namespace xProduction;

class Grid_Task extends \Grid{

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
		return $m;
	}

	function formatRow(){
		$this->current_row_html['name']="<div class='panel-heading '>".$this->model['name'].
											"<h3 class='text-center well'>". $this->model['subject']."</h3>".
											"<div class='row'>".
													"<div class='col-md-6'>".
														"Created By.:- "."<b>".$this->model['created_by']."</b>".	
													"</div>". " ".
													"<div class='col-md-6'>".
														"Created At.:- ".$this->model['created_at'].	
													"</div>"."<br>".

													"<div class='col-md-6'>".
														"Starting Date.:- ".$this->model['expected_start_date'].	
													"</div>".
													"<div class='col-md-6'>".
														"Ending  Date.:- ".$this->model['expected_end_date'].	
													"</div>".
											"</div>".
											"<div>".
												
											"<div>".
												"<div class='col-md-12 well text-center'>".
												$this->model['content'].
												"</div>".
											"</div>".
											"<div class='row'>".
												"<div class='col-md-6'>".
												"Priority - "."<b class='btn btn-success btn-xs'>".$this->model['Priority']."</b>".
												"</div>".
												"<div class='col-md-6'>".
												"Assigned To.: - "."<b>".$this->model['employee']."</b>".
												"</div>".
											"</div>".
										"</div>";

		parent::formatRow();									
	}
}