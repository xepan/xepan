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
        		'default_production_phases'=>3,
        		'wharehouse_count'=>9,
        	);

        return null;

    }

    function Test_CheckDefaults(){
    	return array(
            'OOps'
        	);
    }

    function prepare_defaultDocument(){
        $this->proper_responses['Test_defaultDocument']=array('Company'=>'xProduction/Model_JobCard','HR'=>'xProduction/Model_JobCard','Marketing'=>'xProduction/Model_JobCard','Sales'=>'xProduction/Model_JobCard','Accounts'=>'xProduction/Model_JobCard','CRM'=>'xProduction/Model_JobCard','Purchase'=>'xStore/Model_MaterialRequest','Store'=>'xStore/Model_MaterialRequest','Dispatch And Delivery'=>'xDispatch/Model_DispatchRequest');
    }

    function Test_defaultDocument(){
        $docs=array();
        $this->add('xHR/Model_Department')->each(function($d)use(&$docs){
            $docs[$d['name']] = $d->defaultDocument();
        });

        return $docs;
    }

    function prepare_createAssociationWithItem(){
        $this->proper_responses['Test_createAssociationWithItem']="?";
    }

    function Test_createAssociationWithItem(){
        return array("TODO");
    }


    function prepare_createNewPhase(){
        $this->proper_responses['Test_createNewPhase']=array(
                'total_production_phases'=>$this->api->db->dsql()->table('xhr_departments')->where('epan_id',$this->api->current_website->id)->where('is_production_department',1)->field('count(*)')->getOne(),
                'total_warehouses'=>$this->api->db->dsql()->table('xstore_warehouse')->where('epan_id',$this->api->current_website->id)->field('count(*)')->getOne(),
            );
    }

    function Test_createNewPhase(){
        return array();
    }    

}