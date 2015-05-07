<?php

namespace xCRM;

class Model_SentEmail extends Model_Email{
	function init(){
		parent::init();

		$this->addCondition('direction','sent');
	}
} 