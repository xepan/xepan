<?php

class View_Notification extends View {

	function init(){
		parent::init();

		if($_GET[$this->name]=='true'){

			$acls = $this->api->current_employee->post()->documentAcls();
			$acls->addExpression('department_id')->set(function($m,$q){
				return $m->refSQL('document_id')->fieldQuery('department_id');
			})->sortable(true);

			$acls->addCondition('document','<>',array('xCRM\Activity'));
			$acls->addCondition('can_view','<>','No');
			$acls->addCondition('document',array('xShop\Order_Submitted','xShop\Order_Approved','xShop\Order_Completed','xProduction\Jobcard_ToReceive','xShop\Invoice_Submitted','xShop\Quotation_Submitted','xProduction\Task_Assigned','xProduction\TaskCompleted'));

			foreach ($acls as $acl) {

				$name = $acl['document'];
				$name = explode("\\", $name);
				$name = $name[0].'\\Model_'.$name[1];
				$model = $this->add($name);

				if($model instanceof \xProduction\Model_JobCard){
					$model->addCondition('to_department_id',$acl['department_id']);
				}
				$no=$model->addCondition('updated_at','>',$acl['seen_till']);
				// echo $acl['department']. ' ' .$name .'<br/>';
				$no = $model->count()->getOne();
				if($no)
					$this->add('View')->setHTML( $acl['department']. ' :: ' .$acl['document'] .' == ' . $no);
			}
		}
	}

	function render(){
		$this->js(true)->_load('xnotifier')->xnotifier();
		parent::render();
	}
}