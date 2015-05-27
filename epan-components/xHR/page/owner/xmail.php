<?php
class page_xHR_page_owner_xmail extends page_xHR_page_owner_main{
	
	function init(){
		parent::init();
		
		$this->app->title='x-Mail';
		$dept_id = $this->api->stickyGET('department_id');
		
		$dept = $this->add('xHR/Model_Department')->load($dept_id);
		$official_email_array = $dept->getOfficialEmails();
		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-envelope"></i> '.$dept['name'].' Mails <small> '.implode(", ", $official_email_array).'  </small>');

		$col = $this->add('Columns');
		$left_col=$col->addColumn(2);
		$right_col=$col->addColumn(10);

//CUSTOMER SECTION----------------------------------------------------------------------
		$left_col->add('xCRM/View_MemberForEmail',array('model'=>$this->add('xShop/Model_CustomerForEmail'),'member_type'=>'Customer'));

//SUPPLIER SECTION--------------------------------------------------------------------------------------------------------------------------
		$left_col->add('xCRM/View_MemberForEmail',array('model'=>$this->add('xPurchase/Model_SupplierForEmail'),'member_type'=>'Supplier'))->addStyle('margin-top','5%');

//AFFILIATE SECTION-----------------------------------------------------------------------
		$left_col->add('xCRM/View_MemberForEmail',array('model'=>$this->add('xShop/Model_AffiliateForEmail'),'member_type'=>'Affiliate'))->addStyle('margin-top','5%');

//Emails--------------------------------------------------------------------------------------
		$email = $this->add('xCRM/Model_Email');
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

		$mail_crud=$right_col->add('CRUD',array('grid_class'=>'xCRM/Grid_Email'));
		$mail_crud->setModel($emails,array(),array('subject','to_email','from_email','message','from','id','from_id','direction','task_id','task_status','from_name','cc','bcc'));
	
		$mail_crud->add('xHR/Controller_Acl');
		// $this->js(true)->_selector('*')->xtooltip();
	}


}