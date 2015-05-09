<?php

class page_tests_10HRTesting extends page_tests_base {
	public $title = 'HR Testing';
    public $proper_responses=array('Test_empty'=>'');

    function prepare_CheckDefaults(){

        if(!$this->add('Model_Epan')->addCondition('id',$this->api->current_website->id)->tryLoadAny()->loaded())
            throw $this->exception('Epan Not Loaded','SkipTests');

        $departments = $this->add('xHR/Model_Department');

    	$this->proper_responses['Test_CheckDefaults']=array(
                'total_default_departments'=>9,
        		'default_inactive_departments'=>0,
                'member_detail_id'=>$last_member->id,
        		'member_user_id'=>$user->id
        	);

        return null;

    }

    function Test_CheckDefaults(){
    	return array(
            'OOps'
        	);
    }

    function Test_

}