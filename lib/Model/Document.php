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
			'can_see_activities'=>'comment atk-swatch-blue',
			'can_send_via_email'=>'mail atk-swatch-blue',
			'can_reject'=>'cancel-circled atk-swatch-red',
			'can_cancel'=>'cancel atk-swatch-red',
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
				if(!isset($this->actions['can_manage_attachments']))
					$this->actions = array_merge(array('can_manage_attachments' => array()),$this->actions);
				// if(!isset($this->actions['can_see_activities']))
				// 	$this->actions = array_merge(array('can_see_activities' => array()),$this->actions);
			}
			
		}

		// set icons
		foreach ($this->actions as $ac_view=>$details) {
			if(!isset($details['icon']) and isset($this->default_icons[$ac_view]) and $this->actions[$ac_view] !== false and $this->actions[$ac_view] !== null)
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
		$this->addHook('beforeDelete',array($this,'defaultBeforeDelete'));
		$this->addHook('afterInsert',array($this,'defaultAfterInsert'));
		$this->addHook('afterLoad',array($this,'defaultAfterLoad'));

		$this->addExpression('created_date')->set('DATE_FORMAT('.$this->dsql()->getField('created_at').',"%Y-%m-%d")');
		$this->addExpression('updated_date')->set('DATE_FORMAT('.$this->dsql()->getField('updated_at').',"%Y-%m-%d")');
	}

	function defaultBeforeDelete(){
		$this->add('xCRM/Model_Activity')
				->addCondition('related_root_document_name',$this->root_document_name)
				->addCondition('related_document_id',$this->id)
		->each(function($obj){
			$obj->forceDelete();
		});
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

	function getNextSeriesNumber($config_value=0){
		$i = $this->add('xShop/Model_Invoice');
		return $config_value + 1 + $i->dsql()->del('fields')->field('max(name)')->getOne();
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

	function attachments_page($page){
		$crud = $page->add('CRUD');
		$crud->setModel($this->ref('Attachments'),array('name','attachment_url_id'),array('name','attachment_url','updated_date'));

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

	function activities_page($page){

		$activities = $this->activities();

		$crud = $page->add('CRUD');

		if($crud->isEditing('add')){
			$activities->getElement('action')->setValueList(array('comment'=>'Comment','email'=>'E-mail','call'=>'Call','sms'=>'SMS','personal'=>'Personal','action'=>'Action Taken'))->display(array('form'=>'Form_Field_DropDownNormal'));
		}

		if($crud->isEditing('edit')){
			$activities->getElement('action')->display(array('form'=>'Readonly'));
		}

		$crud->addHook('crud_form_submit',function($crud,$form){
			$form->model->notify = true;
			return true;
		});

		$crud->setModel($activities,array('created_at','action_from','action','subject','message','notify_via_email','email_to','notify_via_sms','sms_to','attachment_id'));

		if(!$crud->isEditing()){
			$crud->grid->controller->importField('created_at');
			$g = $crud->grid;
			$g->addMethod('format_activity',function($g,$f)use($activities){
					$v = $g->api->add('View_Activity');
					$v->setModel($g->model);
					$g->current_row_html[$f]= $v->getHTML();
				});
			$g->addFormatter('action','Wrap');
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

			$g->addQuickSearch($g->model->getActualFields());
			$g->addPaginator($ipp=10);
		}


		if($crud->isEditing('add')){
			$form = $crud->form;
			$action_field = $crud->form->getElement('action');
			$send_email_field = $crud->form->getElement('notify_via_email');
			$send_sms_field = $crud->form->getElement('notify_via_sms');
			
			$party= $this->getParty();

			$email_to_field = $crud->form->getElement('email_to')->set($party->email());
			$sms_to_field = $crud->form->getElement('sms_to')->set($party->mobileno());
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
		return $this->saveAs($this->getRootClass());
	}

	function createActivity($action,$subject,$message,$from=null,$from_id=null, $to=null, $to_id=null,$email_to=null,$notify_via_email=false, $notify_via_sms=false){
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
		if($email_to){
			$new_activity['email_to'] = $email_to;
		}

		$new_activity['subject']= $subject;
		$new_activity['message']= $message;
		$new_activity->notify = $notify_via_email;
		
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

	function sendEmail($email,$subject,$email_body,$cc=array(),$bcc=array(),$attachements=array(),$from_official_email=array()){
		$tm=$this->add( 'TMail_Transport_PHPMailer' ,array('email_settings'=>$from_official_email));	
		try{
			$tm->send($email, $email,$subject, $email_body ,false,$cc,$bcc,false,'',$attachements);
		}catch( phpmailerException $e ) {
			throw $this->exception($e->errorMessage(),'Growl');
		}catch( Exception $e ) {
			throw $e;
		}
	}


	function amountInWords($amount){
		
	}

	function getParty(){
		
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
		}elseif($this instanceof \xShop\Model_Customer){
			return $this;		
		}elseif($this instanceof \xShop\Model_MemberDetails){
			return $this;
		}elseif($this instanceof \xShop\Model_Affiliate){
			return $this;
		}

		return new \Dummy();
	}

	function setEmployeeNull(){
		$this['created_by_id'] = null;
		$this->saveAndUnload();
	}

	function emailSubjectPrefix($subject){
		return "[".$this->root_document_name.' '. ($this['name']?:$this['customer_name']?:""). '] ' . $subject;
	}

	function populateSendFrom(&$form, $department, $setDefault=null){
		$oe= $department->officialEmails();

		$field = $form->addField('DropDown','department_send_from','Send From');
		$field->setEmptyText('From Company Email');
		$field->setModel($oe);

		if($oe->count()->getOne() > 0){
			if($setDefault){
				$field->set($oe->addCondition('email_username',$setDefault)->tryLoadAny()->get('id'));
			}else{
				$field->set($oe->tryLoadAny()->get('id'));
			}
		}
	}

	function getPopulatedSendFrom(&$form){
		if(!$form['department_send_from']) return $this->api->current_website;

		return $this->add('xHR/Model_OfficialEmail')->load($form['department_send_from']);
	}


	function convert_number_to_words($number) {
	    $hyphen      = '-';
	    $conjunction = ' and ';
	    $separator   = ', ';
	    $negative    = 'negative ';
	    $decimal     = ' point ';
	    $dictionary  = array(
	        0                   => 'zero',
	        1                   => 'one',
	        2                   => 'two',
	        3                   => 'three',
	        4                   => 'four',
	        5                   => 'five',
	        6                   => 'six',
	        7                   => 'seven',
	        8                   => 'eight',
	        9                   => 'nine',
	        10                  => 'ten',
	        11                  => 'eleven',
	        12                  => 'twelve',
	        13                  => 'thirteen',
	        14                  => 'fourteen',
	        15                  => 'fifteen',
	        16                  => 'sixteen',
	        17                  => 'seventeen',
	        18                  => 'eighteen',
	        19                  => 'nineteen',
	        20                  => 'twenty',
	        30                  => 'thirty',
	        40                  => 'fourty',
	        50                  => 'fifty',
	        60                  => 'sixty',
	        70                  => 'seventy',
	        80                  => 'eighty',
	        90                  => 'ninety',
	        100                 => 'hundred',
	        1000                => 'thousand',
	        1000000             => 'million',
	        1000000000          => 'billion',
	        1000000000000       => 'trillion',
	        1000000000000000    => 'quadrillion',
	        1000000000000000000 => 'quintillion'
	    );

	    if (!is_numeric($number)) {
	        return false;
	    }

	    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
	        // overflow
	        trigger_error(
	            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
	            E_USER_WARNING
	        );
	        return false;
	    }

	    if ($number < 0) {
	        return $negative . $this->convert_number_to_words(abs($number));
	    }

	    $string = $fraction = null;

	    if (strpos($number, '.') !== false) {
	        list($number, $fraction) = explode('.', $number);
	    }

	    switch (true) {
	        case $number < 21:
	            $string = $dictionary[$number];
	            break;
	        case $number < 100:
	            $tens   = ((int) ($number / 10)) * 10;
	            $units  = $number % 10;
	            $string = $dictionary[$tens];
	            if ($units) {
	                $string .= $hyphen . $dictionary[$units];
	            }
	            break;
	        case $number < 1000:
	            $hundreds  = $number / 100;
	            $remainder = $number % 100;
	            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
	            if ($remainder) {
	                $string .= $conjunction .$this->convert_number_to_words($remainder);
	            }
	            break;
	        default:
	            $baseUnit = pow(1000, floor(log($number, 1000)));
	            $numBaseUnits = (int) ($number / $baseUnit);
	            $remainder = $number % $baseUnit;
	            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
	            if ($remainder) {
	                $string .= $remainder < 100 ? $conjunction : $separator;
	                $string .= $this->convert_number_to_words($remainder);
	            }
	            break;
	    }

	    if (null !== $fraction && is_numeric($fraction)) {
	        $string .= $decimal;
	        $words = array();
	        foreach (str_split((string) $fraction) as $number) {
	            $words[] = $dictionary[$number];
	        }
	        $string .= implode(' ', $words);
	    }

	    return $string;
	}


}