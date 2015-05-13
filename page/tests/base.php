<?php

class page_tests_base extends Page_Tester {
	public $proper_responses=array('Test_empty'=>'');

	function init(){
		ini_set('memory_limit', '2048M');
		set_time_limit(0);		
		parent::init();
	}

	// function executeTest($test_obj,$test_func,$input){
 //        try{
 //    		$this->api->db->beginTransaction();
	// 	        $res = parent::executeTest($test_obj,$test_func,$input);
 //    		$this->api->db->commit();
 //    	}catch(\Exception_StopInit $e){
	// 		// $this->api->db->commit();
	// 		throw $e;
	// 	}catch(Exception $e){
 //    		$this->api->db->rollback();
 //    		throw $e;
 //    	}

 //    	return $res;
 //    }

 //    function silentTest($test_obj=null){
 //    	try{
 //    		$this->api->db->beginTransaction();
 //    			$res = parent::silentTest($test_obj);
 //    		$this->api->db->commit();
 //    	}catch(\Exception_StopInit $e){
	// 		// $this->api->db->commit();
	// 		throw $e;
	// 	}catch(Exception $e){
 //    		$this->api->db->rollback();
 //    		throw $e;
 //    	}
 //    	return $res;
 //    }

 //    function runTests($test_obj=null){
 //    	try{
 //    		$this->api->db->beginTransaction();
 //    			$res =parent::runTests($test_obj);
 //    		$this->api->db->commit();
 //    	}catch(\Exception_StopInit $e){
	// 		// $this->api->db->commit();
	// 		throw $e;
	// 	}catch(Exception $e){
 //    		$this->api->db->rollback();
 //    		throw $e;
 //    	}
 //    	return $res;
 //    }
}