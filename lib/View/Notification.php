<?php

class View_Notification extends View {
	
	function recursiveRender(){

		$acls = $this->api->current_employee->post()->documentAcls();
		$doc_j =$acls->join('xhr_documents','document_id');
		$doc_j->addField('department_id');

		$last_seen_j = $doc_j->join('last_seen_updates.related_document_name','name');
		$last_seen_j->addField('employee_id');

		$acls->addCondition('employee_id',$this->api->current_employee->id);

		$acls->addCondition('document','<>',array('xCRM\Activity'));
		$acls->addCondition('can_view','<>','No');

		foreach ($acls as $acl) {

			$name = $acl['document'];
			$name = explode("\\", $name);
			$name = $name[0].'\\Model_'.$name[1];
			$model = $this->add($name);

			if($model instanceof \xProduction\Model_JobCard){
				$model->addCondition('to_department_id',$acl['department_id']);
			}
			$no=$model->myCounts(false,true);
		
			if($no)
				$this->add('View')->setHTML( $acl['department']. ' :: ' .$acl['document'] .' == ' . $no);
		}
		parent::recursiveRender();

	}
}