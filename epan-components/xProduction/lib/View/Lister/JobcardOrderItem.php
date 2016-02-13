<?php
namespace xProduction;
class View_Lister_JobcardOrderItem extends \CompleteLister{
	function init(){
		parent::init();
		$this->add('View_Info')->set('hellp'.rand(1,10));
		
	}
	function setModel($jobcard){
		parent::setModel($jobcard);
	}
	function defaultTemplate(){
		return array('view/jobcard-item');
	}
}