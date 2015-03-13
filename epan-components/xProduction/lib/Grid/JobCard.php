<?php
namespace xProduction;

class Grid_JobCard extends \Grid{

	function setModel($job_card_model){
		parent::setModel($job_card_model,array('orderitem','from_department','name','forwarded_to'));
	}
}