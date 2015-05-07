<?php

class page_xProduction_page_owner_printjobcard extends Page{

	function init(){
		parent::init();

		$css=array(
			'templates/css/epan.css',
			'templates/css/compact.css'
		);
		
		foreach ($css as $css_file) {
			$link = $this->add('View')->setElement('link');
			$link->setAttr('rel',"stylesheet");
			$link->setAttr('type',"text/css");
			$link->setAttr('href',$css_file);
		}

		$job_id = $this->api->StickyGET('jobcard_id');
		if(!$job_id) 
			$this->add('View_Warning')->set('Jobcard Not Found');

		$jobcard=$this->add('xProduction/Model_JobCard')->tryLoad($job_id);
		
		if(!$jobcard->loaded()) 
			$this->add('View_Warning')->set('Jobcard Not Found');

		$this->add('xProduction/View_Jobcard',array('jobcard'=>$jobcard));
		
	}
}