<?php

namespace xCRM;

class Model_ReceivedEmail extends Model_Email{
	function init(){
		parent::init();

		$this->addCondition('direction','received');
	}
} 