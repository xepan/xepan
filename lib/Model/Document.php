<?php

class Model_Document extends SQL_Model{

	public $status = null;
	public $document_name=null;
	public $root_document_name=null;

	function init(){
		parent::init();

		if($this->status === null)
			throw $this->exception('Document Status property must be defined as array');

		if(count($this->status))
			$this->addField('status')->enum($this->status);

		if($this->root_document_name == null)
			throw $this->exception('Root Document Name Must Be defined');

		if($this->document_name == null){
			$class_name = get_class($this);
			// $class_name = explode('\\', $class_name);
			// if(count($class_name)==2) 
			// 	$class_name=$class_name[1];
			// else
			// 	$class_name=$class_name[0];

			$this->document_name = str_replace("Model_", "", $class_name);
		}

		$default_acl_options =array(
				'can_view'=>array('caption'=>'Whose created Order(draft) you can see'),
				'can_manage_attachments' =>array('caption'=>'Whose created Documents Attachemnt you can manage')
			);


		$this->addField('related_document_id')->system(true);
		$this->addField('related_root_document_name')->system(true);
		$this->addField('related_document_name')->system(true);
		
		$this->hasOne('xHR/Employee','created_by_id')->defaultValue($this->api->current_employee->id)->system(true);
		$this->hasMany('xProduction/Task','document_id');
		$this->hasMany('Attachment','document_id');
	}

	function getRootClass(){
		$class = explode("\\", $this->root_document_name);
		$class=$class[0].'/Model_'.$class[1];
		return $class;
	}

	function assign_page($page){
		$page->add('View')->set('In Model Document ... complete me ');
	}

	function assignTo($to,$subject="",$message=""){
			
		if(!in_array("assigned", $this->status))
			throw $this->exception('status must have "assigned" status in array');

		$model = $this->add('xProduction/Model_Task_Assigned');
		$model->addCondition('root_document_name',$this->root_document_name);
		$model->addCondition('document_id', $this->id);
		$model->addCondition('document_name', $this->document_name);

		$model->tryLoadAny();

		if($to instanceof \xHR\Model_Employee){
			$model['team_id']= null;
			$model['employee_id']= $to->id;
		}
		elseif ($to instanceof \xProduction\Model_Team){
			$model['team_id']= $to->id;
			$model['employee_id']= $to->teamLeader()->id;
		}
		else
			throw $this->exception('Not known TO Whome to assign task');

		$model['name'] = $subject;
		$model['content'] = $message;
		$model['is_default_jobcard_task'] = true;

		$model->save();

		$this['status']='assigned';
		$this->saveAndUnload();
	}
	
	function assignedTo(){
		$model = $this->add('xProduction/Model_Task');
		$model->addCondition('document_id', $this->id);
		$model->tryLoadAny();

		if($model['team_id']) return $model->ref('team_id');
		if($model['employee_id']) return $model->ref('employee_id');

		return false;
	}

	function relatedTask(){
		$rt = $this->ref('xProduction/Task')
			->addCondition('root_document_name',$this->root_document_name)
			// ->addCondition('document_name',$this->document_name)
			->addCondition('is_default_jobcard_task',true)
			->tryLoadAny();

		return $rt;
	}

	function relatedDocument($document=false,$root=true,$load_current_status=false){
		if($document){
			$this['related_document_id'] = $document->id;
			$this['related_root_document_name'] = $document->root_document_name;
			$this['related_document_name'] = $document->document_name;
		}else{
			if($root){
				$class = explode("\\", $this['related_root_document_name']);
			}else{
				$class = explode("\\", $this['related_document_name']);
			}
			$class=$class[0].'/Model_'.$class[1];
			$m=$this->add($class);
			$m->load($this['related_document_id']);
			return $m;
		}
	}

	function manage_attachements_page($page){
		$crud = $page->add('CRUD');
		$crud->setModel($this->ref('Attachements'));
		$crud->add('xHR/Controller_Acl');
	}

}