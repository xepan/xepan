<?php
class page_xHR_page_owner_department_outsource extends Page{

	function init(){
		parent::init();

		if(!$_GET['hr_department_id'])
			throw new \Exception('department_id must be in GET');
			
			// return;
		
		$department_id=$this->api->stickyGET('hr_department_id');
		$selected_dept_model = $this->add('xHR/Model_Department')->load($_GET['hr_department_id']);		
		
		if(!$selected_dept_model->loaded())
			return;
		$grid=$this->add('Grid')->addSno();
		$outsource_model=$this->add('xProduction/Model_OutSourceParty',array('table_alias'=>'mc'));

		// selector form
		$this->add('HR');
		$form = $this->add('Form');
		$outsource_party_field = $form->addField('hidden','outsource_party')->set(json_encode($selected_dept_model->getAssociatedOutsourceParty()));
		$form->addField('Checkbox','department_completely_outsourced')->set($selected_dept_model['is_outsourced']);
		$form->addSubmit('Update');
	
		$grid->setModel($outsource_model,array('name'));
		$grid->addSelectable($outsource_party_field);

		if($form->isSubmitted()){
			$outsource_dept_model = $this->add('xProduction/Model_OutSourcePartyDeptAssociation');
			$outsource_parties = $this->add('xProduction/Model_OutSourceParty');

			$selected_outsource_party = json_decode($form['outsource_party'],true);
			foreach ($outsource_parties as $party) {
				if(in_array($party->id, $selected_outsource_party))
					$selected_dept_model->addOutSourceParty($party);
				else
					$selected_dept_model->removeOutSourceParty($party);
			}	
			// Update Search String
			$selected_dept_model['is_outsourced']= $form['department_completely_outsourced'];
			$selected_dept_model->save();
			$form->js(null,$this->js()->univ()->successMessage('Updated'))->reload()->execute();
		}		

	}
}