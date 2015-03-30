<?php

class page_owner_searchdoc extends page_base_owner{
	
	function page_index(){

		$data = $this->add('xAccount/Model_Account');
		$data->addCondition('name','like','%'.$_GET['term'].'%');

		$data= $data->getRows(array('id', 'name'));

		foreach ($data as &$row) {
            $row['id'] = (string)$row['id'];
        }
        echo json_encode($data);
        exit;

	}

	function page_display(){
		$this->add('View_Success');
	}
}