<?php

class page_owner_searchdoc extends page_base_owner{
	
	function init(){
		parent::init();

		$data = $this->add('xAccount/Model_Account')->getRows(array('id', 'name'));
		foreach ($data as &$row) {
            //var_dump($row['_id']->__toString()); echo '<hr>';
            $row['id'] = (string)$row['id'];
        }
        echo json_encode($data);
        exit;

	}
}