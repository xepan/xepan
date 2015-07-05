<?php

namespace xCRM;

class View_Email extends \View{

	function init(){
		parent::init();
		
		$tab = $this->add('Tabs');
		$associate_tab = $tab->addTab('Associate')->addClass('atk-box');
		$other_tab = $tab->addTab('Other')->addClass('atk-box');
		
		$email = $associate_tab->add('xCRM/Model_AssociatedEmail');
		$email->getElement('subject')->caption('Emails');
		$emails = $email->loadDepartmentEmails();
		if(!$emails){
			$emails = $email->addCondition('id',-1);
		}

		//SHOW ONLY CUSTOMER EMAILS
		if($_GET['customer_id']){
			$emails->addCondition(
				$emails->dsql()->orExpr()
							->where(
									$emails->dsql()->andExpr()
									->where('from','Customer')
									->where('from_id',$_GET['customer_id'])
								)
							->where(
									$emails->dsql()->andExpr()
										->where('to','Customer')
										->where('to_id',$_GET['customer_id'])
								)
					);

		}

		if($_GET['supplier_id']){

			$emails->addCondition(
				$emails->dsql()->orExpr()
							->where(
									$emails->dsql()->andExpr()
									->where('from','Supplier')
									->where('from_id',$_GET['supplier_id'])
								)
							->where(
									$emails->dsql()->andExpr()
										->where('to','Supplier')
										->where('to_id',$_GET['supplier_id'])
								)
					);			
		}

		if($_GET['affiliate_id']){

			$emails->addCondition(
				$emails->dsql()->orExpr()
							->where(
									$emails->dsql()->andExpr()
									->where('from','Affiliate')
									->where('from_id',$_GET['affiliate_id'])
								)
							->where(
									$emails->dsql()->andExpr()
										->where('to','Affiliate')
										->where('to_id',$_GET['affiliate_id'])
								)
					);			
		}

		$mail_crud=$associate_tab->add('CRUD',array('grid_class'=>'xCRM/Grid_Email'));
		$mail_crud->setModel($emails,array(),array('subject','to_email','from_email','message','from','id','from_id','direction','task_id','task_status','from_name','cc','bcc','to','to_id','from','from_id'));
		$mail_crud->add('xHR/Controller_Acl');


		$other_mail = $this->add('xCRM/Model_OtherEmail');
		$other_mail = $other_mail->loadDepartmentEmails();
		$other_mail_crud = $other_tab->add('CRUD',array('grid_class'=>'xCRM/Grid_Email'));
		$other_mail_crud->setModel($other_mail,array(),array('subject','to_email','from_email','message','from','id','from_id','direction','task_id','task_status','from_name','cc','bcc','to','to_id','from','from_id'));

		$other_mail_crud->add('xHR/Controller_Acl');
	}
}