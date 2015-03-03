<?php

namespace xShop;

class Form_Order extends \Form_Stacked {

	function init(){
		parent::init();

		if(in_array($this->api->stickyGET($this->owner->short_name),array('add','edit'))){
			$this->createForm();
		}

		$this->addHook('submit',function($form){
			// save all values to order
			// check if member exists.. load or create
			// fill mandatory fields manually
			
			// check user
			if($form['member']){				
				$member_id = $form['member'];
			}else{
				if(!$form['name'])
					$form->displayError('name','name is must');




				$users= $form->add('Model_Users');
				$users->addCondition('email',$form['email']);
				$users->tryLoadAny();
				if(!$users->loaded()){
					// try searching member with another user by mobile number
					$members = $form->add('xShop/Model_MemberDetails');
					$members->addCondition('mobile_number',$form['mobile']);
					$members->tryLoadAny();
					
					if(!$members->loaded()){
						// create new user 
						// name and email
						$new_user = $form->add('Model_Users');
						$new_user['name']=$form['name'];
						$new_user['email']=$form['email'];
						$new_user->save();

						// .. member will be created by event automatically
						$new_member= $form->add('xShop/Model_MemberDetails');
						$new_member->loadBy('users_id',$new_user->id);
						// get member and update mobile no
						$new_member['mobile_number'] = $form['mobile'];
						$new_member->save();
						$member_id = $new_member->id;
					}else{
						$member_id = $member->id;
					}
				}else{
					$existing_member = $form->add('xShop/Model_MemberDetails');
					$existing_member->loadBy('users_id',$users->id);
					$member_id = $existing_member->id;
				}
			}

			$m = $form->model;

			$m['member_id'] = $member_id;
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

		$this->create_new_field = $this->addField('Checkbox','create_new_member');

		$this->member_field = $this->addField('autocomplete/Basic','member');
		$member_model = $this->add('xShop/Model_MemberDetails');
		// $member_model->addExpression('search_field')->set(function($m,$q){
		// 	return "(concat(".$q->getField('name').",' ','mobile_number'))";
		// });

		$this->member_field->setModel($member_model);

		$this->name_field = $this->addField('line','name');
		$this->email_field = $this->addField('line','email');
		$this->mobile_field = $this->addField('line','mobile');
		

		$this->create_new_field->js(true)->univ()->bindConditionalShow(array(
				''=>array('member'),
				'*'=>array('name','email','mobile'),
			));

		$this->billing_address_field = $this->addField('text','billing_address');
		$this->shipping_address_field = $this->addField('text','shipping_address');
		$this->order_summary_field = $this->addField('text','order_summary');


	}

	function recursiveRender(){
		if($this->model AND $this->model->loaded()){
			// fill form values from model // editing
			$this->member_field->set($this->model['member_id']);
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