<?php


class page_test extends Page {
	function init(){
		parent::init();

		
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