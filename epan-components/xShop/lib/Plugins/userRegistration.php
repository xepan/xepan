<?php

namespace xShop;

class Plugins_userRegistration extends \componentBase\Plugin{
	public $namespace = 'xShop';

	function init(){
		parent::init();

		$this->addHook('new_user_registered',array($this,'new_user_registered'));
		$this->addHook('user_before_delete',array($this,'user_before_delete'));
	}

	function new_user_registered($obj,$user_model){

		$member_detail_model = $this->add('xShop/Model_MemberDetails');
		$member_detail_model['users_id'] = $user_model['id'];
		$member_detail_model->save();
	}

	function user_before_delete($user_to_be_deleted){
		$this->add('xShop/Model_MemberDetails')
			->addCondition('users_id',$user_to_be_deleted->id)
			->_dsql()
			->set('users_id',null)
			->update();
	}

}

