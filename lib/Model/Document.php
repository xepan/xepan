<?php

class Model_Document extends Model_Table{
	
	public $actions=array();
	public $acl_added = false;
	public $status = null;
	public $document_name=null;
	public $root_document_name=null;

	public $default_icons=array(
			'can_submit'=>'lock atk-swatch-red',
			'can_manage_attachments'=>'attach',
			'can_approve'=>'thumbs-up-alt atk-swatch-green',
			'can_reject'=>'ccw atk-swatch-red',
			'can_reject'=>'ccw atk-swatch-red',
			'can_see_activities'=>'comment atk-swatch-blue',
		);

	function init(){
		parent::init();

		if(!(isset($this->is_view) and $this->is_view) and  $this->status === null)
			throw $this->exception('Document Status property must be defined as array');

		if(count($this->status))
			$this->addField('status')->enum($this->status);

		if(!(isset($this->is_view) and $this->is_view) and $this->root_document_name == null)
			throw $this->exception('Root Document Name Must Be defined');

		if($this->document_name == null){
			$class_name = get_class($this);
			$this->document_name = str_replace("Model_", "", $class_name);
		}


		if(!$this instanceof \xCRM\Model_Activity){
			$this->actions = array_merge(array('can_view'=>array('caption'=>'Whose created Document you can see')),$this->actions);
			
			if(!$this instanceof \Model_Attachment){
				$this->actions = array_merge(array('can_manage_attachments' => array()),$this->actions);
				$this->actions = array_merge(array('can_see_activities' => array()),$this->actions);
			}
			
		}

		// set icons
		foreach ($this->actions as $ac_view=>$details) {
			if(!isset($details['icon']) and isset($this->default_icons[$ac_view]) and $this->actions[$ac_view] != false)
				$this->actions[$ac_view]['icon'] = $this->default_icons[$ac_view];
		}

		// if($this->document_name == 'xShop\Order_Draft'){
		// 	echo "<pre>";
		// 	echo print_r($this->actions,true);
		// 	echo "</pre>";
		// }

		$this->addExpression('item_name','"item_name"');

		$this->addField('related_document_id')->system(true);
		$this->addField('related_root_document_name')->system(true);
		$this->addField('related_document_name')->system(true);
		
		$this->addField('created_at')->type('datetime')->system(true)->defaultValue(date('Y-m-d H:i:s'))->sortable(true);
		$this->addField('updated_at')->type('datetime')->system(true)->defaultValue(date('Y-m-d H:i:s'));
		
		$this->hasOne('xHR/Employee','created_by_id')->defaultValue($this->api->current_employee->id)->system(true);
		$this->hasMany('xProduction/Task','related_document_id');
		
		//must be define in child class
		// Abstract $this->hasMany('Attachment','related_document_id');

		$this->addExpression('related_document')->set(function($m,$q){
			
			$doc_array = array(
						'xPurchase\\\\PurchaseOrder'=>'xpurchase_purchase_order',
						'xShop\\\\Order'=>'xshop_orders',
						'xProduction\\\\JobCard'=>'xproduction_jobcard',
						'xStore\\\\StockMovement'=>'xstore_stock_movement_master',
						'xDispatch\\\\DispatchRequest'=>'xdispatch_dispatch_request',
						'xShop\\\\SalesInvoice'=>'xshop_invoices',
						'xPurchase\\\\PurchaseInvoice'=>'xshop_invoices',
						'xProduction\\\\Task'=>'xproduction_tasks'
					);


			$str="(CASE ".$q->getField('related_root_document_name') . " ";
				foreach ($doc_array as $root_doc_name => $table) {
				$nq=$m->api->db->dsql();
				$q1 = $nq->table($table);
				$q1->where('id',$q->getField('related_document_id'));
				$q1->del('fields');

				$str .="WHEN '".$root_doc_name."' THEN (".$q1->field('name')->render().")";
					
				}
			$str .="END)";

			return $str;
		});

		$this->addHook('beforeSave',array($this,'defaultBeforeSave'));
		$this->addHook('afterInsert',array($this,'defaultAfterInsert'));
		$this->addHook('afterLoad',array($this,'defaultAfterLoad'));

		$this->addExpression('created_date')->set('DATE_FORMAT('.$this->dsql()->getField('created_at').',"%Y-%m-%d")');
		$this->addExpression('updated_date')->set('DATE_FORMAT('.$this->dsql()->getField('updated_at').',"%Y-%m-%d")');
	}


	function defaultAfterLoad(){
		if($this->hasElement('custom_fields') and $this['custom_fields'] and $this->hasElement('item_id')){
			$cf_array=json_decode($this['custom_fields'],true);
			$qty_json = json_encode(array('stockeffectcustomfield'=>$cf_array['stockeffectcustomfield']));
			$this['item_name'] = $this['item'] .' [' .$this->item()->genericRedableCustomFieldAndValue($qty_json) .' ]';
		}elseif($this->hasElement('item_id')){
			$this['item_name'] = $this['item'];
		}else{
			$this['item_name'] = $this['item'];
		}
		
	}

	function defaultBeforeSave(){
		$this['updated_at']= date('Y-m-d H:i:s');

		//Create Log entry
	}

	function getSeries(){
		return $this->root_document_name;
	}

	function defaultAfterInsert($newobj,$id){
		$x=$this;//->newInstance();
		$x->load($id);
		if($x['name']==''){
			$x['name'] = /* $this->getSeries() .' ' .*/ sprintf("%05d", $x->id);
			$x->save();
		}
	}

	function getRootClass($specific_calss=false){
		if($specific_calss)
			$class = explode("\\", $this->document_name);
		else
			$class = explode("\\", $this->root_document_name);

		$class=$class[0].'/Model_'.$class[1];
		return $class;
	}

	// function assign_page($page){
	// 	$page->add('View')->set('In Model Document ... complete me ');
	// }m

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
			->addCondition('related_root_document_name',$this->root_document_name)
			// ->addCondition('document_name',$this->document_name)
			->addCondition('is_default_jobcard_task',true)
			->tryLoadAny();

		return $rt;
	}

	function loadWhoseRelatedDocIs($document,$specific=false){
		$this->addCondition('related_root_document_name',$document->root_document_name);
		$this->addCondition('related_document_id',$document->id);
		if($specific)
			$this->addCondition('related_document_name',$document->document_name);

		$this->tryLoadAny();

		if($this->loaded()) return $this;

		return false;
	}

	function relatedDocument($document=false,$root=true,$load_current_status=false){
		if($document){
			$this['related_document_id'] = $document->id;
			$this['related_root_document_name'] = $document->root_document_name;
			$this['related_document_name'] = $document->document_name;
		}else{
			if(!$this['related_document_id']) return new \Dummy();
			
			if($root){
				$class = explode("\\", $this['related_root_document_name']);
			}else{
				$class = explode("\\", $this['related_document_name']);
			}
			$class=$class[0].'/Model_'.$class[1];
			$m=$this->add($class);
			$m->tryLoad($this['related_document_id']);
			if(!$m->loaded()){
				// Remove related document information 
				// May be related document is removed
				return new \Dummy();
			}
			return $m;
		}
	}

	function manage_attachments_page($page){
		$crud = $page->add('CRUD');
		$crud->setModel($this->ref('Attachments'),array('name','attachment_url','updated_date'));

		if(!$crud->isEditing()){
			$self = $this;
			$crud->grid->add('VirtualPage')
                ->addColumn('open', 'View file', array('Open','icon'=>'users'))
                ->set(function($page)use($self, $crud){
                    $id = $_GET[$page->short_name.'_id'];
                    $id = $page->add('Model_Attachment')->load($id)->get('attachment_url_id');
                    // find Filestore file
                    $m = $page->add('filestore/Model_File')->load($id);
                    
                    // open as object
                    $url = $m->get('url');
                    $page->add('View')
                        ->setElement('object')
                        ->setAttr('type', $m->ref('filestore_type_id')->get('mime_type'))
                        ->setAttr('data', $m->get('url'))
                        // ->setAttr('width', '100%')
                        // ->setAttr('height', '100%')
                        ->setHTML('Your browser is to old to open this file inline<br/><a href="'.$url.'" target=_blank>'.$url.'</a>')
                        ;
             });
				// $crud->grid->addformatter('attachment_url','image');
		}

		$crud->add('xHR/Controller_Acl');
	}

	function activities(){
		$activities = $this->add('xCRM/Model_Activity');
		$activities->addCondition('related_root_document_name',$this->root_document_name);
		$activities->addCondition('related_document_id',$this->id);
		$activities->setOrder('created_at','desc');
		return $activities;
	}

	function see_activities_page($page){

		$activities = $this->activities();

		$crud = $page->add('CRUD');

		if($crud->isEditing('add')){
			$activities->getElement('action')->setValueList(array('comment'=>'Comment','email'=>'E-mail','call'=>'Call','sms'=>'SMS','personal'=>'Personal','action'=>'Action Taken'))->display(array('form'=>'Form_Field_DropDownNormal'));
		}

		if($crud->isEditing('edit')){
			$activities->getElement('action')->display(array('form'=>'Readonly'));
		}

		$crud->setModel($activities,array('created_at','action_from','action','subject','message','notify_via_email','email_to','notify_via_sms','sms_to','attachment_id'));

		if(!$crud->isEditing()){
			$crud->grid->controller->importField('created_at');
			$g = $crud->grid;
			$g->addMethod('format_activity',function($g,$f)use($activities){
					$v = $g->api->add('View_Activity');
					$v->setModel($g->model);
					$g->current_row_html[$f]= $v->getHTML();
				});
			$g->addFormatter('action','activity');

			$g->removeColumn('created_at');
			$g->removeColumn('action_from');
			$g->removeColumn('subject');
			$g->removeColumn('message');
			$g->removeColumn('notify_via_email');
			$g->removeColumn('email_to');
			$g->removeColumn('notify_via_sms');
			$g->removeColumn('sms_to');
			$g->removeColumn('attachment_id');

		}


		if($crud->isEditing('add')){
			$form = $crud->form;
			$action_field = $crud->form->getElement('action');
			$send_email_field = $crud->form->getElement('notify_via_email');
			$send_sms_field = $crud->form->getElement('notify_via_sms');
			
			$email_to_field = $crud->form->getElement('email_to')->set($this->getTo()->email());
			$sms_to_field = $crud->form->getElement('sms_to')->set($this->getTo()->mobileno());
			//Actions if Email
			$action_field->js('change')->univ()->bindConditionalShow(array(
				'comment'=>array('email_to','notify_via_email'),
				'call'=>array('email_to','notify_via_email'),
				'sms'=>array('email_to','notify_via_email'),
				'action'=>array('email_to','notify_via_email'),
				'personal'=>array('email_to','notify_via_email'),
				'email'=>array('email_to')
				));

			//Send Email
			$send_email_field->js('change')->univ()->bindConditionalShow(array(
				''=>'',
				'*'=>array('email_to')
			),'div.atk-form-row');

			//Send SMS
			$send_sms_field->js('change')->univ()->bindConditionalShow(array(
				''=>'',
				'*'=>array('sms_to')
			),'div.atk-form-row');

			
			//File Type for Attachment

		}

		$crud->add('xHR/Controller_Acl',array('override'=>array('can_view'=>'All','allow_add'=>true,'allow_edit'=>'Self Only','allow_del'=>'Self Only')));

	}

	function setStatus($status,$message=null,$subject=null,$from=null,$from_id=null,$to=null,$to_id=null){
		$this['status']=$status;
		$this->createActivity($status, $subject?:ucwords($status) ,$message?:'Document Status Changed',$from,$from_id,$to,$to_id);
		$this->saveAs($this->getRootClass());
	}

	function createActivity($action,$subject,$message,$from=null,$from_id=null, $to=null, $to_id=null){
		if(!$from){
			$from = 'Employee';
			$from_id = $this->api->current_employee->id;
		}

		$new_activity = $this->add('xCRM/Model_Activity');
		$new_activity['related_root_document_name'] = $this->root_document_name;
		$new_activity['related_document_name'] = $this->document_name;
		$new_activity['related_document_id'] = $this->id;

		$new_activity['action'] = $action;
		$new_activity['from']= $from;
		$new_activity['from_id']= $from_id;
		
		if($to){
			$new_activity['to']= $to;
			$new_activity['to_id']= $to_id;
		}

		$new_activity['subject']= $subject;
		$new_activity['message']= $message;

		$new_activity->save();
		 return $new_activity;

	}

	function searchActivity($action,$from_on_date=null, $to_date=null, $from=null,$from_id=null,$to=null,$to_id=null){
		$m = $this->add('xCRM/Model_Activity');
		$m->addCondition('action',$action);

		$m->addCondition('related_root_document_name',$this->root_document_name);
		if($this->root_document_name != $this->document_name)
			$m->addCondition('related_document_name',$this->document_name);
		$m->addCondition('related_document_id',$this->id);
		$m->tryLoadAny();
		
		if($m->loaded())
			return $m;

		return new Dummy();
	}

	function myCounts($string=false, $new_only = true){
		if(!$this->acl_added){
			$this->add('xHR/Controller_Acl');
		}
		return $this->acl_added->getCounts($string, $new_only);
	}

	function myUnRead($set=null){
		if(!$set)
			return $this->myCounts(true,true);

		$current_lastseen = $this->add('Model_MyLastSeen');
		$current_lastseen->addCondition('related_root_document_name',$this->root_document_name);
		$current_lastseen->addCondition('related_document_name',$this->document_name);
		$current_lastseen->tryLoadAny();

		$current_lastseen['seen_till'] = date('Y-m-d H:i:s');
		$current_lastseen->save();
	}

	function sendEmail($email,$subject,$email_body,$cc=array(),$bcc=array(),$attachements=array()){
		$tm=$this->add( 'TMail_Transport_PHPMailer' );	
		try{
			$tm->send($email, $email,$subject, $email_body ,false,$cc,$bcc,false,'',$attachements);
		}catch( phpmailerException $e ) {
			$this->api->js(null,'$("#form-'.$_REQUEST['form_id'].'")[0].reset()')->univ()->errorMessage( $e->errorMessage() . " " . $email )->execute();
		}catch( Exception $e ) {
			throw $e;
		}
	}


	function amountInWords($amount){
		
	}

	function getTo(){		
		if($this instanceof \xShop\Model_Order){		
			return $this->customer();
		}elseif($this instanceof \xShop\Model_Quotation){
			return $this->customer();
		}elseif($this instanceof \xShop\Model_SalesInvoice){
			return $this->customer();
		}elseif($this instanceof \xPurchase\Model_PurchaseOrder){
			return $this->supplier();
		}elseif($this instanceof \xPurchase\Model_PurchaseInvoice){
			return $this->supplier();
		}elseif($this instanceof \xCRM\Model_Ticket){
			return $this->customer();
		}

		return new \Dummy();

	}

	function setEmployeeNull(){
		$this['created_by_id'] = null;
		$this->saveAndUnload();
	}

}