<?php

class page_xDocApp_page_owner_main extends page_componentBase_page_owner_main {
	function initMainPage(){
		$this->add('H1')->set('Component Owner Main Page');
		$this->api->stickyGET('topic');
		$form = $this->add('Form');
		$content = $form->addField('xDocApp/Markdown','content');
	}


	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}