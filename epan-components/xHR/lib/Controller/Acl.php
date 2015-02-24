<?php

namespace xHR;

class Controller_Acl extends \AbstractController {

	public $document=null;
	public $permissions=array(
		
		'can_view'=>'No',
		
		'allow_add'=>'No',
		'allow_edit'=>'No',
		'allow_del'=>'No',

		'can_submit'=>'No',
		'can_select_outsource'=>'No',
		'can_approve'=>'No',
		'can_reject'=>'No',
		'can_forward'=>'No',
		'can_receive'=>'No',
		'can_assign'=>'No',
		
		'can_manage_tasks'=>'No',
		'task_types'=>false,
		'can_send_via_email'=>'No',

		'can_see_communication'=>'No',
		'can_see_deep_communicatoin'=>'No',

		);

	public $self_only_ids=array();
	public $include_colleagues=array();
	public $include_subordinates=array();

	function init(){
		parent::init();

		if(! $this->document){
			if(!$this->owner->getModel())
				throw $this->exception('document not setted and model not found');

			if(! $this->owner->getModel() instanceof \Model_Document)
				throw $this->exception("Model ". get_class($this->owner->getModel()). " Must Inherit Model_Document");
			
			if($this->owner->getModel() instanceof \xProduction\Model_Task){
				$this->document = get_class($this->owner->getModel()). '\\'.$this->owner->getModel()->get('document_type');
			}else{
				$this->document = get_class($this->owner->getModel());
			}

		}

		$this->document = str_replace("Model_", "", $this->document);

		$dept_documents = $this->add('xHR/Model_Document');
		$dept_documents->addCondition('department_id', $this->api->current_employee->department()->get('id'));
		$dept_documents->addCondition('name', $this->document);
		$dept_documents->tryLoadAny();

		if(!$dept_documents->loaded()) $dept_documents->save();

		$acl_model = $this->add('xHR/Model_DocumentAcl');
		$acl_model->addCondition('post_id',$this->api->current_employee->post()->get('id'));
		$acl_model->addCondition('document_id',$dept_documents->id);

		$acl_model->tryLoadAny();
		if(!$acl_model->loaded()) $acl_model->save();

		foreach ($this->permissions as $key => $value) {
			$this->permissions[$key] = $acl_model[$key];
		}

		$this->self_only_ids = array($this->api->current_employee->id);
		
		$this->include_colleagues = $this->api->current_employee->getColleagues();
		$this->include_colleagues[] = $this->self_only_ids[0];

		$this->include_subordinates = $this->api->current_employee->getSubordinats();
		$this->include_subordinates[] = $this->self_only_ids[0];

		
		// CRUD
		if($this->owner instanceof \CRUD){
			// check add edit delete
			$this->doCRUD();

			if($this->owner->isEditing()){
				$this->doFORM();
			}else{
				$this->doGRID();
			}
		}elseif($this->owner instanceof \Grid){
			$this->doGRID();
		}elseif ($this->owner instanceof \Form){
			$this->doFORM();
		}else{
			// its just view
			$this->doVIEW();
		}

		// Grid
		// Form
			// Fields ??? readonly 
		// Page
		// View

	}

	function doCRUD(){

		if($this->permissions['can_view'] != 'All'){
			$this->filterModel(isset($this->owner->model->acl_field)?$this->owner->model->acl_field:'created_by_id');
		}

		if(!$this->permissions['allow_add']){
			$this->owner->allow_add=false;
			// $this->owner->add_button->destroy();
		}

		if($this->permissions['allow_edit']=='No'){
			$this->owner->allow_edit=false;
			$this->owner->grid->removeColumn('edit');
		}else{
			$this->filterGrid('edit');
		}

		if($this->permissions['allow_del'] == 'No'){
			$this->owner->allow_del=false;
			$this->owner->grid->removeColumn('delete');
		}else{
			$this->filterGrid('delete');
		}

		if($this->permissions['can_submit'] != 'No' AND $this->owner->model->hasMethod('submit')){
			$this->owner->addAction('submit',array('toolbar'=>false));		
			$this->filterGrid('submit');
		}
	
		if($this->permissions['can_select_outsource'] !='No'){
			$col_name = $this->addOutSourcePartiesPage();
			// $this->filterGrid($col_name);
		}		

		if($this->permissions['can_approve'] !='No' AND $this->owner->model->hasMethod('approve')){
			$this->owner->addAction('approve',array('toolbar'=>false));		
			$this->filterGrid('approve');
		}	
		
		if($this->permissions['can_reject'] !='No'  AND $this->owner->model->hasMethod('reject')){
			$this->owner->addAction('reject',array('toolbar'=>false));		
			$this->filterGrid('reject');
		}

		if($this->permissions['can_assign'] !='No'){
			$this->addAssignPage();
		}

		if($this->permissions['can_receive'] AND $this->owner->model->hasMethod('receive')){
			$this->owner->addAction('receive',array('toolbar'=>false));		
			$this->filterGrid('receive');
		}

		if($this->permissions['can_forward'] !='No' AND $this->owner->model->hasMethod('forward')){
			$this->owner->addAction('forward',array('toolbar'=>false));		
			$this->filterGrid('forward');
		}

		if($this->permissions['can_manage_tasks'] !='No'){
			if($tt=$this->permissions['task_types']){
				switch ($tt) {
					case 'job_card_tasks':
						$this->addRootDocumentTaskPage();
						break;
					case "job_card_current_status_tasks":
						$this->addDocumentSpecificTaskPage();
					break;

					case "job_card_all_status_tasks":
					break;

					default:
						# code...
						break;
				}
			}
		}

		if($this->permissions['can_see_communication'] != 'No'){
			$p=$this->owner->addFrame('Comm',array('icon'=>'user'));
			if($p){
				$p->add('xCRM/View_Communication',array('include_deep_communication'=>$this->permissions['can_see_deep_communication'],'document'=>$this->owner->getModel()->load($this->owner->id)));
			}
		}

		if($this->permissions['can_send_via_email'] !='No' AND $this->owner->model->hasMethod('send_via_email')){
			$this->owner->addAction('send_via_email',array('toolbar'=>false));		
			$this->filterGrid('send_via_email');
		}
	}

	function doGRID(){
	}

	function doFORM(){

	}

	function doVIEW(){

	}

	function filterModel($filter_column='created_by_id'){
		if(!$this->owner->model->hasField($filter_column)){
			throw $this->exception("$filter_column must be defined in model " . get_class($this->owner->model));
		}

		switch ($this->permissions['can_view']) {
			case 'Self Only':
				$filter_ids = $this->self_only_ids;
				break;
			case 'Include Subordinats':
				$filter_ids = $this->include_subordinates;
				break;
			case 'Include Colleagues':
				$filter_ids = $this->include_colleagues;
				break;
			case 'Include Subordinats & Colleagues':
				$filter_ids = $this->include_subordinates;
				$filter_ids = array_merge($filter_ids,$this->include_colleagues);
				break;
			
			default: // No 
				$filter_ids = array(0);
				break;
		}
		if($filter_ids) 
			$this->owner->model->addCondition($filter_column,$filter_ids);
	}

	function filterGrid($column){
		switch ($this->permissions['can_'.$column]) {
			case 'Self Only':
				$filter_ids = $this->self_only_ids;
				break;
			case 'Include Subordinats':
				$filter_ids = $this->include_subordinates;
				break;
			case 'Include Colleagues':
				$filter_ids = $this->include_colleagues;
				break;
			case 'Include Subordinats & Colleagues':
				$filter_ids = $this->include_subordinates;
				$filter_ids = $filter_ids + $this->include_colleagues; 
				break;
			
			default: // All
				$filter_ids = null;
				break;
		}

		if($filter_ids!=null){
			$this->owner->grid->addMethod('format_flt_'.$column,function($g,$f)use($filter_ids){
				if(!in_array($g->model['created_by_id'], $filter_ids)){
					$g->current_row_html[$f] = "";//$g->model['created_by_id'] . " -- " .print_r($filter_ids,true);
				}
			});

			$this->owner->grid->addFormatter($column,'flt_'.$column);
		}


	}

	function addAssignPage(){
		$p= $this->owner->addFrame("Assign to");
		if($p){
			switch ($this->permissions['can_assign']) {
				case 'Dept. Teams':
					$dept_teams = $p->api->current_employee->department()->teams();

					$form = $p->add('Form');
					
					$team_field = $form->addField('DropDown','teams')->setEmptyText('Please Select Team')->validateNotNull(true);
					$team_field->setModel($dept_teams);
					
					$form->addSubmit('Update');

					if($form->isSubmitted()){
						$dept_teams->load($form['teams']);
						$this->owner->model->load($this->owner->id);
						$this->owner->model->assignToTeam($dept_teams);

						$form->js()->univ()->successMessage("sdfsd")->execute();
					}

				break;

				case 'Dept. Employee':
				break;

				case 'Self Team Members':
				break;

			}
		}
	}

	function addOutSourcePartiesPage(){
		$p= $this->owner->addFrame("Select Outsource",array('label'=>'OutSrc Parties','icon'=>'plus'));
		if($p){
			$current_job_card = $p->add('xProduction/Model_JobCard');
			$current_job_card->load($this->owner->id);

			$form = $p->add('Form');
			$osp = $form->addField('DropDown','out_source_parties')->setEmptyText('Not Applicable');
			$osp->setModel($current_job_card->department()->outSourceParties());
			
			if($selected_party = $current_job_card->outSourceParty()){
				$osp->set($selected_party->id);
			}

			$form->addSubmit('Update');

			if($form->isSubmitted()){
				
				if($form['out_source_parties']){
					$party = $p->add('xProduction/Model_OutSourceParty');
					$party->load($form['out_source_parties']);
					$current_job_card->outSourceParty($party);
				}else{
					$current_job_card->removeOutSourceParty();
				}

				$p->js()->univ()->closeDialog()->execute();
			}


		}

		return 'fr_'.$this->api->normalizeName("Select Outsource");
	}

	function addRootDocumentTaskPage(){
		$p = $this->owner->addFrame("Task management");
		if($p){
			$crud = $p->add('CRUD');
			$task_model = $this->add('xProduction/Model_Task');
			$task_model->addCondition('document_type',$this->owner->getModel()->root_document_name);
			$task_model->addCondition('document_id',$this->owner->id);
			$crud->setModel($task_model);
			$crud->add('xHR/Controller_Acl');
		}
	}

	function getAlc(){
		return $this->permissions;
	}

}