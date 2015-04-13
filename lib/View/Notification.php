<?php

class View_Notification extends View {
	
	function init(){
		parent::init();

		$acls = $this->api->current_employee->post()->documentAcls();
		
		$acls->addCondition('document',array('xShop\Customer'));
		$acls->addCondition('document','<>',array('xCRM\Activity'));

		foreach ($acls as $acl) {
			if($acl['can_view'] =='No') continue;

			$name = $acl['document'];
			$name = explode("\\", $name);
			$name = $name[0].'\\Model_'.$name[1];
			$no = $this->add($name)->myCounts(false,true);
		
			if($no)
				$this->add('View')->setHTML( $acl['department']. ' :: ' .$acl['document'] .' == ' . $no);
		}

	}
}