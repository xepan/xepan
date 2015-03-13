<?php

class Model_GuideStep extends SQL_Model {
	public $table = 'epan_guide_steps';

	function init(){
		parent::init();

		$this->hasOne('Guide','guide_id');
		$this->addField('selector');
		$this->addField('intro')->type('text');
		$this->addField('order')->type('int');

		$this->_dsql()->order('order','asc');

		//$this->add('dynamic_model/Controller_AutoCreator');

	}
}