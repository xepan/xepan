<?php


class page_test extends Page {

	function page_index(){
		$jc = $this->add('xProduction/Model_JobCard');
		$jc->addCondition('orderitem_id','1');
		$jc->addCondition('to_department_id','18');
		$jc->loadAny();
	}
	

	function page_setepanid(){
		$tables = $this->api->db->dsql()->expr('SHOW TABLES');
		foreach ($tables as $table) {
			$fields = $this->api->db->dsql()->describe($table['Tables_in_nebula']);
			foreach ($fields as $field) {
				$key = isset($field['name']) ? $field['name'] : $field['Field'];
				if($key=='epan_id'){
					// echo "doing in ". $table['Tables_in_nebula'] .'<br/>';
					$this->api->db->dsql()->table($table['Tables_in_nebula'])->set('epan_id',1)->update();
					continue;
				}
			}
		}
	}

	
}