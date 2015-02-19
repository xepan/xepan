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
		'can_approve'=>'No',
		'can_reject'=>'No',
		'can_forward'=>'No',
		'can_receive'=>'No',
		'can_assign'=>'No',
		
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
			$this->document = get_class($this->owner->getModel());
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
			$tabs = $p->add('Tabs');
			$teams_tab = $tabs->addTab('Teams');
			// add teams to tab_teams
			$tabs->addTab('Employees');
			// 
			$tabs->addTab('My Team Members');
		}
	}

	function getAlc(){
		return $this->permissions;
	}

}