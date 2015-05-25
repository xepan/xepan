<?php

namespace xShop;

class Model_Customer extends Model_MemberDetails{
	public $title_field ='customer_search_phrase';
	public $is_view = true;
	public $root_document_name="xShop\Customer";

	public $actions=array(
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_start_processing'=>array('caption'=>'Create Opportunity'),
			'can_manage_attachments'=>false
		);

	function init(){
		parent::init();

		
		$this->getElement('users_id')->destroy();
		$this->getElement('name')->destroy();
		$this->getElement('email')->destroy();

		$user_j = $this->join('users','users_id');
		$user_j->addField('user_epan_id','epan_id');
		$user_j->addField('username')->sortable(true)->group('b~6~Customer Login')->sortable(true);
		$user_j->addField('password')->type('password')->group('b~6');
		$user_j->addField('customer_name','name')->group('a~4~Basic Info')->mandatory(true);
		$user_j->addField('customer_email','email')->sortable(true)->group('a~4');
		$user_j->addField('type')->setValueList(array(100=>'SuperUser',80=>'BackEndUser',50=>'FrontEndUser'))->defaultValue(50)->group('a~6')->sortable(true)->mandatory(false);
		$user_j->addField('user_account_activation','is_active')->type('boolean')->defaultValue(true)->group('a~6')->sortable(true)->mandatory(false)->caption('Login User Account Activated');

		$this->addCondition('type',50);
		$this->addCondition('user_epan_id',$this->api->current_website->id);

		$this->addExpression('customer_search_phrase')->set($this->dsql()->concat(
				$this->getElement('customer_name'),
				' :: ',
				$this->getElement('customer_email'),
				' :: ',
				$this->getElement('mobile_number')
				
			));

		$this->addExpression('total_opportunity')->set(function($m,$q){
			return $m->refSQL('xShop/Opportunity')->count();
		})->sortable(true);

		$this->addExpression('total_quotation')->set(function($m,$q){
			return $m->refSQL('xShop/Quotation')->count();
		})->sortable(true);

		$this->addHook('beforeSave',array($this,'beforeCustomerSave'));

		$this->arrangeFields();		
	}

	function beforeCustomerSave(){
		$old_user = $this->add('Model_Users');
		$old_user->addCondition('username',$this['username']);
		$old_user->addCondition('username','<>',null);
		$old_user->addCondition('username','<>','');
		
		if(isset($this->api->current_website))
			$old_user->addCondition('epan_id',$this->api->current_website->id);
		
		if($this->loaded()){
			$old_user->addCondition('id','<>',$this->id);
		}

		$old_user->tryLoadAny();
		if($old_user->loaded()){
			throw $this->exception("This username is allready taken, Chose Another",'ValidityCheck')->setField('username');
		}
	}

	function arrangeFields(){
		$o=$this->add('Order');
		$o->move($this->getElement('mobile_number'),'first');
		$o->move($this->getElement('customer_email'),'first');
		$o->move($this->getElement('customer_name'),'first');
		$o->move($this->getElement('username'),'last');
		$o->move($this->getElement('password'),'last');

		$o->now();
	}

	function account(){
		$acc = $this->add('xAccount/Model_Account')
				->addCondition('customer_id',$this->id)
				->addCondition('group_id',$this->add('xAccount/Model_Group')->loadSundryDebtor()->get('id'));
		$acc->tryLoadAny();
		if(!$acc->loaded()){
			$acc['name'] = $this['customer_search_phrase'];
			$acc->save();
		}

		return $acc;
	}

	function email(){
		if(!$this->loaded())
			return false;
		return $this['customer_email'];
	}

	function mobileno(){
		if(!$this->loaded())
			return false;
		return $this['mobile_number'];	
	}

	function start_processing_page($page){
		$form = $page->add('Form_Stacked');
		$form->addField('text','opportunity');
		$form->addSubmit('Create Opportunity');
		if($form->isSubmitted()){
			$this->start_processing($form['opportunity']);
			return true;
		}

		return false;
	}

	//Actual Creating the Opportunity
	function start_processing($opportunity_text){
		$opportunity = $this->add('xShop/Model_Opportunity');
		$opportunity['customer_id'] = $this->id;
		$opportunity['status']='active';
		$opportunity['opportunity']=$opportunity_text;
		$opportunity->save();
	}
	
	function updateEmail($email){
		if(!$this->loaded()) return false;
		
		$this['customer_email'] = $this['customer_email'].', '.$email;
		$this->save();
	}

	function see_activities_page($page){
		$q=$this->dsql();
		$activities = $this->add('xCRM/Model_Activity')
								->addCondition(
									$q->orExpr()
										->where(
											$q->andExpr()
											->where('from','Customer')
											->where('from_id',$this->id)
											)
										->where(
											$q->andExpr()
												->where('to','Customer')
												->where('to_id',$this->id)
										)
					);
		$activities->setOrder('created_at','desc');

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
}