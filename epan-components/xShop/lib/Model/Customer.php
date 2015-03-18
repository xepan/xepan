<?php

namespace xShop;

class Model_Customer extends Model_MemberDetails{
	function init(){
		parent::init();
		$this->getElement('name')->destroy();

		$user_j = $this->join('users','users_id');
		$user_j->addField('user_name','name');
		$user_j->addField('username');
		$user_j->addField('password');
		$user_j->addField('type')->setValueList(array(100=>'SuperUser',80=>'BackEndUser',50=>'FrontEndUser'))->defaultValue(50)->group('a~6')->sortable(true)->mandatory(false);
		$user_j->addField('email');

		$this->add('Controller_Validator');
		$this->is(array(
							// 'name|to_trim|required?type User name here',
							'email|email|unique','if','*','[email]',
							'username|to_trim|unique'
						)
				);

		$this->hasMany('xShop/Oppertunity','customer_id');
		$this->hasMany('xShop/Quotation','customer_id');
	}
}