<?php

class Model_Guide extends SQL_Model {
	public $table = "epan_guide";

	function init(){
		parent::init();

		$this->addField('name');
		$this->hasMany('GuideStep','guide_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}