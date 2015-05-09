<?php


class page_test extends Page {

	function page_index(){
		$table="xaccount_account";

		$q="
			SELECT * FROM 
				information_schema.TABLE_CONSTRAINTS 
				WHERE information_schema.TABLE_CONSTRAINTS.CONSTRAINT_TYPE='FOREIGN KEY' AND information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA='".$this->api->db->dbname."' AND information_schema.TABLE_CONSTRAINTS.TABLE_NAME='".$table."'
		";

		$keys = $this->api->db->dsql()->expr($q)->get();
		
		foreach ($keys as $key) {
			$drop_q= "alter table $table drop FOREIGN KEY ". $key['CONSTRAINT_NAME'];
			echo $drop_q."<br>";
		}

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