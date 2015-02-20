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

			$m['name'] = $form['name'];
			$m['email'] = $form['email'];
			$m['mobile'] = $form['mobile'];
			$m['billing_address'] = $form['billing_address'];
			$m['shipping_address'] = $form['shipping_address'];
			$m['order_summary'] = $form['order_summary'];

			$form->model->save();
		});
	}

	function setModel($model,$fields=null){
		return parent::setModel($model,array('x'));
	}

	function createForm(){
		//$this->amount_field = $this->addField('line','amount');
		$this->name_field = $this->addField('line','name');
		$this->email_field = $this->addField('line','email');
		$this->mobile_field = $this->addField('line','mobile');
		$this->billing_address_field = $this->addField('text','billing_address');
		$this->shipping_address_field = $this->addField('text','shipping_address');
		$this->order_summary_field = $this->addField('text','order_summary');
	}

	function recursiveRender(){
		if($this->model->loaded()){
			// fill form values from model // editing
			$this->name_field->set($this->model['name']);
			$this->email_field->set($this->model['email']);
			$this->mobile_field->set($this->model['mobile']);
			$this->billing_address_field->set($this->model['billing_address']);
			$this->shipping_address_field->set($this->model['shipping_address']);
			$this->order_summary_field->set($this->model['order_summary']);

		}
		parent::recursiveRender();
	}
}