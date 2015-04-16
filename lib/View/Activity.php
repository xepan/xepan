<?php

class View_Activity extends CompleteLister {


	function formatRow(){
		$this->current_row['activity_date'] = 'Activity '. $this->add('xDate')->diff(Carbon::now(),$this->model['created_at']);
	}

	function defaultTemplate(){
		return array('view/activity');
	}

}