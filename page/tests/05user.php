<?php

class page_tests_05user extends Page_Tester {
	public $title = 'USER ADD EDIT DELETE';
    public $proper_responses=array();


    function prepare_Add(){
        // $user->addCondition('email','');
        // $user->tryLoadAny();

        $last_user = $this->add('Model_Users')->setOrder('id','desc')->tryLoadAny();

    	$user = $this->add('Model_Users');
    	$user['name']="xepan";
    	$user['email']= "test". ($last_user->id + 1 )."@example.com";
    	$user['username']= "xepan".($last_user->id + 1 );
    	$user['password']="xepan";
    	$user['type'] = 100;
        $user->allow_re_adding_user = true;
    	$user->save();

        $last_member = $this->add('xShop/Model_MemberDetails')->setLimit(1)->setOrder('id','desc')->tryLoadAny();

    	$this->proper_responses['Test_Add']=array(
        		'user_id'=>$user['id'],
                'member_detail_id'=>$last_member->id,
        		'member_user_id'=>$user->id
        	);

        return array($user);

    }

    function Test_Add($new_user){
    	$new_member = $new_user->member()->tryLoadAny();
    	return array(
        		'user_id'=>$new_user->id,
                'member_detail_id'=>$new_member->id,
        		'member_user_id'=>$new_member->user(true)->get('id'),
        	);
    }

    function prepare_repeatedEmailCheck(){
        $this->proper_responses['Test_repeatedEmailCheck']=array(
                'repeated_email_exception'=>'Value "repeated@example.com" already exists',
                'empty_email_exception'=>'Must be a valid email address',
            );
    }

    function test_repeatedEmailCheck(){
        $is_exception_orrcured = 0;
        $is_emptyemail_exception_orrcured=0;

        try{
            
            $user = $this->add('Model_Users');
            $user['name']="xepan";
            $user['email']= "repeated@example.com";
            $user['username']="xepan";
            $user['password']="xepan";
            $user['type'] =100;
            $user->allow_re_adding_user = true;
            $user->save();

            $user = $this->add('Model_Users');
            $user['name']="xepan";
            $user['email']= "repeated@example.com";
            $user['username']="xepan";
            $user['password']="xepan";
            $user['type'] =100;
            $user->allow_re_adding_user = true;
            $user->save();


        }catch(Exception $e){
            $is_exception_orrcured = $e->getMessage();
        }

        try{
            
            $user = $this->add('Model_Users');
            $user['name']="xepan";
            // $user['email']= "";
            $user['username']="xepan";
            $user['password']="xepan";
            $user['type'] =100;
            $user->save();

        }catch(Exception $e){
            $is_emptyemail_exception_orrcured = $e->getMessage();
        }


        return array(
            'repeated_email_exception'=> $is_exception_orrcured,
            'empty_email_exception'=> $is_emptyemail_exception_orrcured,

            );
    }

    function prepare_Edit(){
    	
    }

    function Test_Edit(){

    }
    
}