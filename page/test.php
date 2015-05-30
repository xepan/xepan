<?php


class page_test extends Page {

	function page_index(){
		$email = $this->add('xCRM/Model_Email')
			->addCondition('id',array(339,340))
			->each(function($obj){
				$obj->guessDocumentAndCreateActivityOrTicket();
			});

		// print_r(timezone_identifiers_list());
	}

	function page_cst_organization_name_update(){

		$cst = $this->add('xShop/Model_Customer')->each(function($obj){
			if(!$obj['organization_name']){
				$obj['organization_name'] = $obj['customer_name'];
				$obj->save();
			}

		});

	}

	function page_defdocwrite(){
		$filename = getcwd().'/epan-components/xHR/default-documents.xepan';
		$d= $this->add('xHR/Model_Document');
		$arr = $d->getRows();
		file_put_contents($filename, json_encode($arr));

	}
	

	function page_setepanid(){
		$tables = $this->api->db->dsql()->expr('SHOW TABLES');
		foreach ($tables as $table) {
			$fields = $this->api->db->dsql()->describe($table['Tables_in_'.$this->api->db->dbname]);
			foreach ($fields as $field) {
				$key = isset($field['name']) ? $field['name'] : $field['Field'];
				if($key=='epan_id'){
					// echo "doing in ". $table['Tables_in_nebula'] .'<br/>';
					$this->api->db->dsql()->table($table['Tables_in_'.$this->api->db->dbname])->set('epan_id',1)->update();
					continue;
				}
			}
		}
	}

	// function page_invremove(){
	// 	$this->add('xShop/Model_SalesInvoice')->each(function ($obj){
	// 		echo $obj['name'];
	// 		$obj->forceDelete();
	// 	});

	// 	$i=0;
	// 	$this->add('xAccount/Model_Transaction')->each(function ($obj)use(&$i){
	// 		echo $obj['name']."<br>";
	// 		$obj->forceDelete();
	// 		$i++;
	// 	});

	// 	echo $i;


	// }
	
}