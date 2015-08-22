<?php

namespace xCRM;

class View_EmailCompose extends \View{
	function init(){
		parent::init();

			$tab = $this->add('Tabs');

			//Customer Tab
			$customer_tab = $tab->addTab('Customer');
			$customer_form=$customer_tab->add('Form');
			$cf =$customer_form->addField('autocomplete/Basic','customer');
			$cf->setModel('xShop/Model_Customer');
			$cf->other_field->on('blur',$customer_form->js()->submit());

			//Supplier Tab
			$supplier_tab = $tab->addTab('Supplier');
			$supplier_form = $supplier_tab->add('Form');
			$sf = $supplier_form->addField('autocomplete/Basic','supplier');
			$sf->setModel('xPurchase/Model_Supplier');
			$sf->other_field->on('blur',$supplier_form->js()->submit());

			//Affiliate Tab
			$affiliate_tab = $tab->addTab('Affiliate');
			$affiliate_form = $affiliate_tab->add('Form');
			$af = $affiliate_form->addField('autocomplete/Basic','affiliate');
			$af->setModel('xShop/Model_Affiliate');
			$af->other_field->on('blur',$affiliate_form->js()->submit());


			$this->add('HR');
			$department = $this->add('xHR/Model_Department')->tryload($_GET['department_id']);
			$official_email = $department->officialEmails();

			$footer ="";
			$from_official_email ="";
			$attachments_array = array();

			$form = $this->add('Form_Stacked');
			$to_f = $form->addField('line','to');
			$cc_f = $form->addField('line','cc');
			$bcc_f = $form->addField('line','bcc');
			$from_email_f = $form->addField('dropdown','from_email');
			$from_email_f->setModel($official_email);

			$type_f = $form->addField('hidden','type');
			$id_f = $form->addField('hidden','to_id');

			$form->addField('line','subject');
			$form->addField('RichText','message');
			$form->addSubmit('Send');	

			if($form->isSubmitted()){

				$subject = $form['subject'];
				$email_body = $form['message'] . $footer;	

				$email = $this->add('xCRM/Model_Email');
				$email['from'] = "Employee";
				$email['from_name'] = $this->api->current_employee['name'];
				$email['from_id'] = $this->api->current_employee->id;
				$email['to_id'] = $form['to'];
				$email['to'] = $form['to'];
				$email['cc'] = $form['cc'];
				$email['bcc'] = $form['bcc'];
				$email['subject'] = $subject;
				$email['message'] = $email_body;
				$email['from_email'] = $from_official_email; 
				$email['to_email'] = $form['to'];
				$email['direction'] = "sent";
				
				$to_type = explode('_',explode('/', $form['type']));

				$model = $this->add($form['type'])->load($form['to_id']);
				$model->createActivity('email',$subject,$email_body,null,null, $to_type[1], $form['to_id'],$form['to'],true);
				$email->save();
				$form->js(null,$this->js()->univ()->closeDialog())->univ()->successMessage('Email Send Successfully')->execute();
			}
		 
			$customer_form->onSubmit(function($f)use($to_f,$cc_f,$type_f,$id_f){

				$customer = $f->add('xShop/Model_Customer')->addCondition('id',$f['customer'])->tryLoadAny();
				$emails = explode(',', $customer['customer_email']);
				$to_email = $emails[0];
				unset($emails[0]);
				$js = array(
						$to_f->js()->val($to_email),
						$type_f->js()->val('xShop/Model_Customer'),
						$id_f->js()->val($f['customer'])
					);
				return $cc_f->js(null,$js)->val(implode(',',$emails));
			});

			$supplier_form->onSubmit(function($f)use($to_f,$cc_f,$type_f,$id_f){
				$supplier = $f->add('xPurchase/Model_Supplier')->addCondition('id',$f['supplier'])->tryLoadAny();
				$emails = explode(',', $supplier['email']);
				$to_email = $emails[0];
				unset($emails[0]);
				$js = array(
						$to_f->js()->val($to_email),
						$type_f->js()->val('xPurchase/Model_Supplier'),
						$id_f->js()->val($f['supplier'])
					);
				return $cc_f->js(null,$js)->val(implode(',',$emails));
			});

			$affiliate_form->onSubmit(function($f)use($to_f,$cc_f,$type_f,$id_f){
				$affiliate = $f->add('xShop/Model_Affiliate')->addCondition('id',$f['affiliate'])->tryLoadAny();
				$emails = explode(',', $affiliate['email_id']);
				$to_email = $emails[0];
				unset($emails[0]);
				$js = array(
						$to_f->js()->val($to_email),
						$type_f->js()->val('xShop/Model_Affiliate'),
						$id_f->js()->val($f['affiliate'])
					);
				return $cc_f->js(null,$js)->val(implode(',',$emails));
			});
		// $this->js(true)->_selector('.xcrm-emailreply')->xtooltip();
	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		return array('view/xcrm-emailcompose');
	}


}