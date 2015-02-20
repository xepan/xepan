<?php

namespace xShop;

class Form_Order extends \Form_Stacked {

	function init(){
		parent::init();

		$this->createForm();

		$this->addHook('submit',function($form){
			// save all values to order
			// check if member exists.. load or create
			// fill mandatory fields manually
			$m= $form->model;

			$m['amount'] = $form['amount'];

			$form->model->save();
		});
	}

	function setModel($model,$fields=null){
		return parent::setModel($model,array('x'));
	}

	function createForm(){
		$this->amount_field = $this->addField('line','amount');
	}

	function recursiveRender(){
		if($this->model->loaded()){
			// fill form values from model // editing
			$this->amount_field->set($this->model['amount']);
		}
		parent::recursiveRender();
	}
}