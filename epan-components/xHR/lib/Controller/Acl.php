<?php

namespace xHR;

class Controller_Acl extends \AbstractController {

	public $document=null;
	public $my_model = null;
	public $show_acl_btn = true;
	public $override=array();

	public $permissions=array(
		
		'can_view'=>'No',
		
		'allow_add'=>'No',
		'allow_edit'=>'No',
		'allow_del'=>'No',

		'can_submit'=>'No',
		'can_select_outsource'=>'No',
		'can_approve'=>'No',
		'can_reject'=>'No',
		'can_redesign'=>'No',
		'can_forward'=>'No',
		'can_receive'=>'No',
		'can_accept'=>'No',
		'can_cancel'=>'No',
		'can_start_processing'=>'No',
		'can_mark_processed'=>'No',
		'can_assign'=>'No',
		'can_assign_to'=>false,
		
		'can_manage_attachments'=>'No',
		'can_manage_tasks'=>'No',
		'task_types'=>false,
		'can_send_via_email'=>'No',

		'can_see_activities'=>'No',
		'can_forceDelete'=>'No',

		'can_create_activity'=>'No',
		'can_create_ticket'=>'No',

		);

	public $self_only_ids=array();
	public $include_colleagues=array();
	public $include_subordinates=array();

	function init(){
		parent::init();
		// echo "i m here 1";
		if(! $this->document){
			if(!$this->owner instanceof \SQL_Model AND !$this->owner->getModel())
				throw $this->exception('document not setted and model not found');

			if(!$this->owner instanceof \SQL_Model AND !$this->owner->getModel() instanceof \Model_Document)
				throw $this->exception("Model ". get_class($this->owner->getModel()). " Must Inherit Model_Document");
			
			if($this->owner instanceof \SQL_Model AND !$this->owner instanceof \Model_Document)
				throw $this->exception("Model ". get_class($this->owner). " Must Inherit Model_Document");

			if($this->owner instanceof \SQL_Model){
				$this->document = get_class($this->owner);
			}
			else{
				$this->document = get_class($this->owner->getModel());
			}
		}

		if($this->owner instanceof \SQL_Model){
			$this->owner->acl_added=$this;
			$this->my_model = $this->owner;
		}else{
			$this->owner->model->acl_added=$this;
			$this->my_model = $this->owner->model;
		}

		$this->document = str_replace("Model_", "", $this->document);

		$dept_documents = $this->add('xHR/Model_Document');
		$dept_documents->addCondition('department_id', $_GET['department_id']?:$this->api->current_employee->department()->get('id'));
		$dept_documents->addCondition('name', $this->document);
		$dept_documents->tryLoadAny();
		if(!$dept_documents->loaded()) $dept_documents->save();

		$acl_model = $this->add('xHR/Model_DocumentAcl');
		$acl_model->addCondition('post_id',$this->api->current_employee->post()->get('id'));
		$acl_model->addCondition('document_id',$dept_documents->id);

		$acl_model->tryLoadAny();
		if(!$acl_model->loaded()){
			$acl_model->save();	
		} 

		foreach ($this->permissions as $key => $value) {
			if(isset($this->my_model->actions) && isset($this->my_model->actions[$key]) && ($this->my_model->actions[$key] === false || $this->my_model->actions[$key] === null )){
				// This Permission is set as false or null in model so .. just bypass this leaving itsvale as default in public variable
				// echo $key;
				unset($this->permissions[$key]);
			}else{
				$this->permissions[$key] = $acl_model[$key];
			}
		}

		foreach ($this->override as $key => $value) {
			$this->permissions[$key] = $value;
		}


		$this->self_only_ids = array($this->api->current_employee->id);
		
		$this->include_colleagues = $this->api->current_employee->getColleagues();
		$this->include_colleagues[] = $this->self_only_ids[0];

		$this->include_subordinates = $this->api->current_employee->getSubordinats();
		$this->include_subordinates[] = $this->self_only_ids[0];

		$this->my_teams = $this->api->current_employee->getTeams();
		
		// CRUD
		if($this->owner instanceof \CRUD){
			// check add edit delete
			$this->doCRUD();

			if($this->owner->isEditing()){
				$this->doFORM();
			}else{
				$this->doGRID();
			}

			$this->owner->model->setOrder('updated_at','desc');

		}elseif($this->owner instanceof \Grid){
			$this->doGRID();
		}elseif ($this->owner instanceof \Form){
			$this->doFORM();
		}elseif ($this->owner instanceof \SQL_Model){
			$this->doModel();
		}else{
			// its just view
			$this->doVIEW();
		}

		if(!$this->owner instanceof \SQL_Model){
			$this->my_model->myUnRead(true);
		}
		// Grid
		// Form
			// Fields ??? readonly 
		// Page
		// View

	}

	function doCRUD(){
		// echo "i m here 2 <br>";
		if(!$this->api->auth->model->isDefaultSuperUser() AND $this->show_acl_btn AND !$this->owner->isEditing()){
			if($this->api->getConfig('open_acl_for_all',false) OR $this->api->auth->model->isDefaultSuperUser()){
				$btn = $this->owner->grid->buttonset->addButton()->set('ACL APPLIED');
				$self= $this;
				$vp = $this->owner->add('VirtualPage')->set(function($p)use($self){
					// $p->add('View')->set($self->owner->model->document_name);
					$p->api->stickyGET('department_id');

					$m = $p->add('xHR/Model_DocumentAcl');
					$j=$m->leftJoin('xhr_documents','document_id');
					$j->addField('doc_name','name');
					$j->addField('department_id');
					$m->addCondition('doc_name',$self->owner->model->document_name);
					$m->addCondition('post_id','<>',null); // is admin is not associated with any post athen post=null wali entries bhi dikhayega
					
					if(! $p->api->current_department instanceof \Dummy)
						$m->addCondition('department_id',$p->api->current_department->id);
					
					$m->getElement('post_id')->display(array('form'=>'Readonly'));
					$m->addExpression('post_department')->set($m->refSQL('post_id')->fieldQuery('department'))->caption('Department');

					$c = $p->add('CRUD',array('allow_add'=>false));
					$fields=null;
					if(isset($self->owner->model->actions)){
						$fields = array_merge(array('post_department','post','post_id'),array_keys($self->owner->model->actions));
					}
					$c->setModel($m,$fields);
					if(!$c->isEditing()){
						$c->grid->removeColumn('post_id');
					}
				});

				if($btn->isClicked()){
					$dept = '';
					if(!$this->api->current_department instanceof \Dummy)
						$dept = ' In ' . $this->api->current_department['name'];
					$this->owner->js()->univ()->frameURL('ACL Status for '.$self->owner->model->document_name . $dept , $vp->getURL())->execute();
				}
			}else{
				if(!$this->permissions['can_view'] OR $this->permissions['can_view']=='No'){
					$this->owner->grid->add('View',null,'subheader')->set(' Records Accessibility Restrictions Applied')->addClass('atk-swatch-red');
				}
			}
		}

		if(!$this->api->auth->model->isDefaultSuperUser() AND $this->permissions['can_view'] != 'All'){
			$this->filterModel($this->owner->model, isset($this->owner->model->acl_field)?$this->owner->model->acl_field:'created_by_id');
		}

		if(!$this->api->auth->model->isDefaultSuperUser() AND !$this->permissions['allow_add']){
			$this->owner->allow_add=false;
			if($this->owner->add_button instanceof \View)
				$this->owner->add_button->destroy();
		}

		if(!$this->api->auth->model->isDefaultSuperUser() and $this->permissions['allow_edit'] and $this->permissions['allow_edit'] =='No'){
			$this->owner->allow_edit=false;
			$this->owner->grid->removeColumn('edit');
		}else{
			if(!$this->api->auth->model->isDefaultSuperUser())
				$this->filterGrid('edit','allow_');
		}

		if(!$this->api->auth->model->isDefaultSuperUser() AND $this->permissions['allow_del'] == 'No'){
			$this->owner->allow_del=false;
			$this->owner->grid->removeColumn('delete');
		}else{
			if(!$this->api->auth->model->isDefaultSuperUser())
				$this->filterGrid('delete','allow_','del');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_submit'] != 'No'){
			$this->manageAction('submit','can_submit');
		}
	
		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_select_outsource'] and $this->permissions['can_select_outsource'] !='No'){
			$this->manageAction('select_outsource','can_select_outsource');
		}		

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_approve'] and $this->permissions['can_approve'] !='No'){
			$this->manageAction('approve','can_approve');
		}	
		
		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_reject'] !='No'){
			$this->manageAction('reject','can_reject');
		}
		
		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_redesign'] !='No'){
			$this->manageAction('redesign','can_redesign');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_assign'] !='No'){			
			$this->manageAction('assign','can_assign');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_receive']){
			$this->manageAction('receive','can_receive');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_accept'] and $this->permissions['can_accept'] !='No'){
			$this->manageAction('accept','can_accept');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_cancel'] and $this->permissions['can_cancel'] !='No'){
			$this->manageAction('cancel','can_cancel');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_forward'] !='No'){
			$this->manageAction('forward','can_forward');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_start_processing'] !='No'){
			$this->manageAction('start_processing','can_start_processing');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_mark_processed'] !='No'){
			$this->manageAction('mark_processed','can_mark_processed');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_manage_attachments'] !='No'){
			$this->manageAction('manage_attachments','can_manage_attachments');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_forcedelete'] && $this->permissions['can_forcedelete'] !='No'){
			$this->manageAction('forcedelete','can_forcedelete');
		}
		
		

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_manage_tasks'] !='No'){
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

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_see_activities'] AND $this->permissions['can_see_activities'] != 'No'){
			$this->manageAction('see_activities','can_see_activities');
		}

		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_send_via_email'] !='No'){
			$this->manageAction('send_via_email','can_send_via_email');
		}
		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_create_activity'] !='No'){
			$this->manageAction('create_activity','can_create_activity');
		}
		if($this->api->auth->model->isDefaultSuperUser() OR $this->permissions['can_create_ticket'] !='No'){
			$this->manageAction('create_ticket','can_create_ticket');
		}

		// if($this->permissions['can_send_via_email'] !='No' AND $this->owner->model->hasMethod('send_via_email')){
		// 	$this->owner->addAction('send_via_email',array('toolbar'=>false));		
		// 	$this->filterGrid('send_via_email');
		// }
	}

	function doGRID(){
	}

	function doFORM(){

	}

	function doModel(){
		if($this->permissions['can_view'] != 'All'){
			$this->filterModel($this->owner, isset($this->owner->acl_field)?$this->owner->acl_field:'created_by_id');
		}
	}

	function doVIEW(){

	}

	function manageAction($action_name, $full_acl_key=null , $icon = null){

		if(!isset($this->permissions[$full_acl_key])) return;

		if(!$icon and isset($this->my_model->actions)){
			$icon = $this->my_model->actions[$full_acl_key]['icon']?:'edit';
		}
		else
			$icon = 'target';

		if($this->owner->model->hasMethod($action_name.'_page')){
			$action_page_function = $action_name.'_page';
			
			$title = explode("_", $action_name);
			for($i=0;$i<count($title);$i++){
				if(in_array($title[$i],array('manage','see','can'))){
					unset($title[$i]);
				}
			}

			$title = implode(" ", $title);
			
			if(isset($this->my_model->actions) and isset($this->my_model->actions[$full_acl_key]['caption']))
				$title = $this->my_model->actions[$full_acl_key]['caption'];

			$p = $this->owner->addFrame(ucwords($title),array('icon'=>$icon));
			if($p and $this->owner->isEditing('fr_'.$this->api->normalizeName(ucwords($title)))){
				$this->owner->model->tryLoad($this->owner->id);
				if($this->owner->model->loaded()){
					try{
						$this->api->db->beginTransaction();
							$function_run = $this->owner->model->$action_page_function($p);
						$this->api->db->commit();
						if($function_run ){
							$js=array();
							$js[] = $p->js()->univ()->closeDialog();
							$js[] = $this->owner->js()->reload(array('cut_object'=>'',$p->short_name=>'',$p->short_name.'_id'=>''));
							$this->owner->js(null,$js)->execute();
						}
					}
					catch(\Exception_StopInit $e){
						$this->api->db->commit();
						throw $e;
					}catch(\Exception $e){
						$this->api->db->rollback();
						if($this->api->getConfig('developer_mode',false)){
							throw $e;
						}else{
							$this->owner->js()->univ()->errorMessage($e->getMessage())->execute();
						}
					}
				}
			}
			$this->filterGrid('fr_'.$this->api->normalizeName(ucwords($title)));
		}elseif($this->owner->model->hasMethod($action_name)){
			try{
				$this->api->db->beginTransaction();
					$this->owner->addAction($action_name,array('toolbar'=>false,'icon'=>$icon));		
				$this->api->db->commit();
			}
			catch(\Exception_StopInit $e){
					$this->api->db->commit();
					throw $e;
			}catch(\Exception $e){
				$this->api->db->rollback();
					throw $e;
				if($this->api->getConfig('developer_mode',false)){
					$this->owner->js()->univ()->errorMessage($e->getMessage())->execute();
				}else{
					throw $e;
				}
			}
			$this->filterGrid($action_name);
		}
	}

	function filterModel($model, $filter_column='created_by_id'){
		// $acl =array('No'=>'No','Self Only'=>'Created By Employee',
		// 'Include Subordinats'=>'Created By Subordinates','Include Colleagues'=>'Created By Colleagues',
		// 'Include Subordinats & Colleagues'=>'Created By Subordinats or Colleagues',
		// 'Assigned To Me'=>'Assigned To Me','Assigned To My Team'=>'Assigned To Me & My Team',
		// 'If Team Leader'=>'If Team Leader','All'=>'All');
		if($this->api->auth->model->isDefaultSuperUser()) return;

		if(!$model->hasField($filter_column)){
			throw $this->exception("$filter_column must be defined in model " . get_class($model));
		}
		$filter_ids = false;
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

			case 'Assigned To Me':
				$this->owner->model->addCondition('employee_id',$this->self_only_ids);
			break;
			
			case 'Assigned To My Team':
				$model->addCondition(
					$model->dsql()->orExpr()
					->where('employee_id',$this->self_only_ids)
					->where('team_id',$this->my_teams)
					)
					;
			break;

			case 'If Team Leader':
			break;

			default: // No
				$filter_ids = array(0);
				break;
		}
		if($filter_ids) 
			$model->addCondition($filter_column,$filter_ids);
	}

	function filterGrid($column, $prefix = 'can_', $col_name=false){
		if($this->api->auth->model->isDefaultSuperUser()) return;
		// echo $prefix.($col_name?:$column) . ' = ' . $this->permissions[$prefix.($col_name?:$column)] . ' <br/>';
		$filter_ids = null;
		switch ($this->permissions[$prefix.($col_name?:$column)]) {
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


			case 'Assigned To Me':
				$this->owner->grid->addMethod('format_flt_'.$column,function($g,$f){
					if($g->model->get('employee_id') != $g->api->current_employee->id){
						$g->current_row_html[$f] = "";
					}
				});

				$this->owner->grid->addFormatter($column,'flt_'.$column);
			break;
			
			case 'Assigned To My Team':
				$this->owner->grid->addMethod('format_flt_'.$column,function($g,$f){
					if($g->model->get('employee_id') != $g->api->current_employee->id AND !in_array($g->api->current_employee->id, $g->model->getTeamMembers())){
						$g->current_row_html[$f] = "";
					}
				});

				$this->owner->grid->addFormatter($column,'flt_'.$column);
			break;

			case 'If Team Leader':
				$this->owner->grid->addMethod('format_flt_'.$column,function($g,$f){
					if(!in_array($g->api->current_employee->id ,$g->model->getTeamLeaders())){
						$g->current_row_html[$f] = "";
					}
				});

				$this->owner->grid->addFormatter($column,'flt_'.$column);
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

	// function addAssignPage(){
	// 	$p= $this->owner->addFrame("Assign");
		
	// 	if($p){
	// 		$document = $this->owner->model->load($this->owner->id);
	// 		$assigned_to = $document->assignedTo();
	// 		$set_existing_assigned_to = false;
	// 		switch ($this->permissions['can_assign_to']) {
	// 			case 'Dept. Teams':
	// 				$model = $p->api->current_employee->department()->teams();
	// 				$field_caption = "Teams";
	// 				$set_existing_assigned_to = $assigned_to instanceof \xProduction\Model_Team ? $assigned_to->id: false;
	// 			break;

	// 			case 'Dept. Employee':
	// 				$model = $p->api->current_employee->department()->employees();
	// 				$field_caption = "Employees";
	// 				$set_existing_assigned_to = $assigned_to instanceof \xHR\Model_Employee ? $assigned_to->id: false;
	// 			break;

	// 			case 'Self Team Members':
	// 				// $model = $p->api->current_employee->department()->teams();
	// 				// $field_caption = "Teams";
	// 			break;
	// 		}

	// 		$form = $p->add('Form');
	// 		$field= $form->addField('DropDown','selected',$field_caption)->setEmptyText('Please Select Team')->validateNotNull(true);
	// 		$form->addField('line','subject');
	// 		$form->addField('text','message');
	// 		$field->setModel($model);
			
	// 		if($set_existing_assigned_to){
	// 			$field->set($set_existing_assigned_to);
	// 		}

	// 		$form->addSubmit('Update');

	// 		if($form->isSubmitted()){
	// 			$model->load($form['selected']);
	// 			$document->assignTo($model,$form['subject'],$form['message']);

	// 			$form->js()->univ()->successMessage("sdfsd")->execute();
	// 		}
	// 	}
	// 	return 'fr_'.$this->api->normalizeName("assign");
	// }

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


	function getCounts($string=false, $new_only = true){
		$doc= $this->my_model;

		$current_lastseen = $this->add('Model_MyLastSeen');
		$current_lastseen->addCondition('related_root_document_name',$doc->root_document_name);
		
		if($doc->document_name != $doc->root_document_name)
			$current_lastseen->addCondition('related_document_name',$doc->document_name);
		
		$current_lastseen->tryLoadAny();

		$new_docs_q = clone $doc->_dsql();
		
		$new_docs_q->where($new_docs_q->getField('updated_at'),'>',$current_lastseen['seen_till']?:'1970-01-01');
		$new_doc_count = $new_docs_q->del('fields')->field('count(*)')->getOne();
		

		if($string and $new_only){
			if($new_doc_count)
				return "<span class='label label-danger'>$new_doc_count</span>";
			else
				return "";
		}

		if(!$string and $new_only){
			return $new_doc_count;
		}

		$total_docs_q= clone $doc->_dsql();
		$total_doc_count = $total_docs_q->del('fields')->field('count(*)')->getOne();
		
		if($string and !$new_only){
			$out="";
			if($new_doc_count)
				$out .= "<span class='label label-danger'>$new_doc_count</span>";
			if($total_doc_count)
				$out .= "<span class='label label-default'>$total_doc_count</span>";
			return $out;
		}


		return array('new'=>$new_doc_count,'total'=>$total_doc_count);

	}

	function myUnRead($set=null){
		return $this->my_model->myUnRead($set);
	}

}