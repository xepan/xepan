<?php

class page_tests_00reset extends Page_Tester {
	public $title = 'BASE ERP Testing';
    public $proper_responses=array(
        "Test_reset"=>array('epans'=>1,'activities'=>0,'emails'=>0,'smses'=>0,'sales_invoices'=>0,'sales_orders'=>0,'purchase_invoice'=>0,'purchase_order'=>0,'customers'=>0,'users'=>1,'suppliers'=>0,'job_cards'=>0,'ledgers'=>0,'transactions'=>0,'outsource_parties'=>0,'default_departments'=>9,'production_phases'=>0,'dispatch_requests'=>0,'delivery_notes'=>0,'material_requests'=>0,'warehouses'=>0,'stocks'=>0,'items'=>0,'items_category'=>0,'leads_category'=>0,'leads'=>0,'quotations'=>0,''),
    );

    function prepare_reset(){
    	$this->api->db->dsql()->table('xcrm_document_activities')->delete()->execute();
    	$this->api->db->dsql()->table('xcrm_emails')->delete()->execute();
    	$this->api->db->dsql()->table('xcrm_smses')->delete()->execute();
    	return null;
    }

    function test_reset(){
    	return array(
    			'activities'=>$this->add('xCRM/Model_Activity')->count()->getOne(),
    			'emails'=>$this->add('xCRM/Model_Email')->count()->getOne(),
    			'smses'=>$this->add('xCRM/Model_SMS')->count()->getOne(),
    		);
    }

}