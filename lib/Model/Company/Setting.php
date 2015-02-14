<?php

class Model_Company_Setting extends SQL_Model{
	public $table='xepan-companies';

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		

	}

}