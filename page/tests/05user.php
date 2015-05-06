<?php

class page_tests_05user extends Page_Tester {
	public $title = 'USER ADD EDIT DELETE';
    public $proper_responses=array();


    function prepare_Add(){
    	$user = $this->add('Model_Users');
    	// $user->addCondition('email','');
    	// $user->tryLoadAny();

    	$user['name']="xepan";
    	$user['email']="email@example.com";
    	$user['username']="xepan";
    	$user['password']="xepan";
    	$user['type'] =100;
    	$user->save();

    	$this->api->memorize('new_user',$user->id);

    	$this->proper_responses['Test_Add']=array(
        		'user_id'=>$user['id'],
        		'member_detail_id'=>$user->member()->tryLoadAny()->id
        	);

    }

    function Test_Add(){
    	$new_user = $this->api->recall('new_user');
    	$new_user_model = $this->add('Model_Users')->load($new_user);
    	$new_member = $new_user_model->member()->tryLoadAny();
    	return array(
        		'user_id'=>$new_user,
        		'member_detail_id'=>$new_member->id
        	);
    }

    function prepare_Edit(){
    	
    }

    function Test_Edit(){

    }
    
}