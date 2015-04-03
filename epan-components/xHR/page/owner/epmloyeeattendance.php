<?php
class page_xHR_page_owner_epmloyeeattendance extends page_xHR_page_owner_main{
	function init(){
		parent::init();
		$this->date=date('Y-m-d');

		$form=$this->add('Form');
		$form->addField('DatePicker','date')->set(date('Y-m-d'));
		$form->addSubmit('Go');

		$grid=$this->add('Grid');
		if($form->isSubmitted()){
			$grid->js()->reload(array(
				'date'=>$form->get('date'),
				))->execute();
		}
		if($this->api->stickyGET('date')){
			$this->date = $_GET['date'];	
		}
		$emp=$this->add('xHR/Model_Employee');
		// throw new \Exception($this->api->current_department->id, 1);
		
		// $emp->addCondition('department_id',$this->api->current_department->id);
		$grid->setModel($emp,array('name'));

		
		$grid->addColumn('Button','mark_present');	
		$grid->addColumn('Button','mark_absent');	
		$grid->addColumn('Button','mark_half_day');	

		if($_GET['mark_present']){			
			$emp_model=$this->add('xHR/Model_Employee')->load($_GET['mark_present']);
				$emp_model->markPresent($this->date);
				$grid->js(null,$this->js()->univ()->successMessage('Mark Present Successfully'))->reload()->execute();
		}
		
		if($_GET['mark_absent']){			
				$emp_model=$this->add('xHR/Model_Employee')->load($_GET['mark_absent']);
					$emp_model->markAbsent($this->date);
					$grid->js(null,$this->js()->univ()->successMessage('Mark Absent Successfully'))->reload()->execute();
		}

		if($_GET['mark_half_day']){			
				$emp_model=$this->add('xHR/Model_Employee')->load($_GET['mark_half_day']);
					$emp_model->markHalfDay($this->date);
					$grid->js(null,$this->js()->univ()->successMessage('Mark Half Day Successfully'))->reload()->execute();
		}
		
	}
}