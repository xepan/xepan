<?php
namespace xCRM;

class Model_Activity extends \Model_Document{
	
	public $status=array();
	public $table="xcrm_document_activities";
	public $root_document_name= 'xCRM\Activity';

		public $actions=array(
			'can_view'=>array('caption'=>'Whose created Quotation(draft) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Quotation this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Quotation'),
			'allow_del'=>array('caption'=>'Whose Created Quotation this post can delete'),
		);

	function init(){
		parent::init();

		$from_to = array('Lead','Opportunity','Customer','Employee','Supplier','OutSource Party');

		$this->addField('from')->enum($from_to)->defaultValue('Employee');
		$this->addField('from_id')->defaultValue($this->api->current_employee->id);
		$this->addField('to')->enum($from_to);
		$this->addField('to_id');

		$this->addExpression('action_from')->set(function($m,$q){

			$nq=$m->api->db->dsql();

			$emp_q = $nq->table('xhr_employees');
			$emp_q->where('id',$q->getField('from_id'));
			$emp_q->del('fields');

			$nq1=$m->api->db->dsql();
			$users = $nq1->table('users');
			$cust_j = $users->join('xshop_memberdetails.users_id');
			$users->where('users_id',$q->getField('from_id'));
			$users->del('fields');

			$nq2=$m->api->db->dsql();
			$suppliers = $nq2->table('xpurchase_supplier');
			$suppliers->where('id',$q->getField('from_id'));
			$suppliers->del('fields');



			$str="(
					CASE ".$q->getField('from')."
						WHEN 'Employee' THEN (".$emp_q->field('name')->render().")
						WHEN 'Customer' THEN (". $users->field('name')->render() ." )
						WHEN 'Supplier' THEN (". $suppliers->field('name')->render() ." )
					END
				)";

			return $str;
		});

		$this->addExpression('action_to')->set(function($m,$q){

			$nq=$m->api->db->dsql();

			$emp_q = $nq->table('xhr_employees');
			$emp_q->where('id',$q->getField('to_id'));
			$emp_q->del('fields');

			$nq1=$m->api->db->dsql();
			$users = $nq1->table('users');
			$cust_j = $users->join('xshop_memberdetails.users_id');
			$users->where('users_id',$q->getField('to_id'));
			$users->del('fields');



			$str="(
					CASE ".$q->getField('to')."
						WHEN 'Employee' THEN (".$emp_q->field('name')->render().")
						WHEN 'Customer' THEN (". $users->field('name')->render() ." )
					END
				)";

			return $str;
		});

		$this->addField('subject');
		$this->addField('message')->type('text')->display(array('form'=>'RichText'));
		
		$this->addField('action')->enum(array('created','comment','email','call','sms','personal','submitted','approved','rejected','redesign','canceled','forwarded','reply','received','processed','active','completed'))->mandatory(true);
		$this->addField('notify_via_email')->type('boolean')->defaultValue(false);
		$this->addField('email_to');
		$this->addField('notify_via_sms')->type('boolean')->defaultValue(false);
		$this->addField('sms_to');
		
		$this->add('filestore/Field_File','attachment_id');
		$this->setOrder('created_at','desc');

		$this->addHook('beforeSave,beforeDelete',function($obj){
			if($obj['created_by_id'] != $obj->api->current_employee->id)
				throw $this->exception('You are not authorized for action','Growl');
		});

		// $this->hasMany('Attachment','activity_id');
		$this->addHook('afterSave',$this);
		$this->addHook('beforeDelete',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		if($this->ref('attachment_id')->loaded()){
			$this->ref('attachment_id')->delete();
		}
	}

	function addAttachment($model){
		if($model) return;

		$attach_send = $this->add('Model_Attachment')->addCondition('related_document_id',$model->id);
		foreach ($attach_send as $attach) {
			$activity_attach = $this->add('xCRM/Model_ActivityAttachment');
			$activity_attach['related_document_id'] = $this->id;
			$activity_attach['related_document_name'] ='xCRM\ActivityAttachment';
			$activity_attach['created_by_id'] = $this->api->current_employee->id;
			$activity_attach['attachment_url_id'] = $attach['attachment_url_id'];
			$activity_attach['name'] = $attach['name'];
			$activity_attach->save();
		}

	}

	function afterSave(){
		if($this['notify_via_email'] OR $this['action']=='email'){
			$this->notifyViaEmail();
		}

		if($this['notify_via_sms'])
			$this->notifyViaSMS();
		
	}

	function getTo(){
		if($this['to']=='Customer'){
			return $this->add('xShop/Model_Customer')->load($this['to_id']);
		}

		if($this['to']=='Employee'){
			return $this->add('xHR/Model_Employee')->load($this['to_id']);
		}

		if($this['to']=='Supplier'){
			return $this->add('xPurchase/Model_Supplier')->load($this['to_id']);
		}

		return new \Dummy();

	}

	function notifyViaEmail(){
		$email_created = $this->add('xCRM/Model_Email')->createFromActivity($this);
		$email_created->send();
	}

	function notifyViaSMS(){
		$epan = $this->add('Model_Epan')->tryLoadAny();
		$sms_m = $this->add('xCRM/Model_SMS');
		$sms_m['name']=$this['sms_to'];
		$sms_m['message'] = $epan['sms_prefix']." ".$this['subject']." ".$epan['sms_postfix'];
		$sms_m->relatedDocument($this);
		$sms_m->save();
		$sms_m->send();
	}

}