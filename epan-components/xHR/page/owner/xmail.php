<?php
class page_xHR_page_owner_xmail extends page_xHR_page_owner_main{
	function init(){
		parent::init();


		$id= $this->api->stickyGET('department_id');

		$model = $this->add('xHR/Model_OfficialEmail');
		$model->addCondition('department_id',$id);
		$this->add('View_Success')->set($id);
		$crud=$this->add('Grid');
		$crud->setModel($model,array('email_username'));



		$col=$this->add('Columns');
			$left_col=$col->addColumn(3);

		$customer=$this->add('xShop/Model_Customer');
		$customer->addExpression('unread')->set(function($m,$q){
			return $m->add('xCRM/Model_Email')
				->addCondition(
						$q->orExpr()
							->where(
									$q->andExpr()
									->where('from','Customer')
									->where('from_id',$q->getField('id'))
								)
							->where(
									$q->andExpr()
										->where('to','Customer')
										->where('to_id',$q->getField('id'))
								)
					)
				->addCondition('read_by_employee_id',null)
				->count();
		});

		$customer_crud=$left_col->add('CRUD',array('grid_class'=>'xHR/Grid_MailParty','allow_add'=>false,'allow_edit'=>false,'allow_del'=>false));
		$customer_crud->setModel($customer);

		$supplier=$this->add('xPurchase/Model_Supplier');
		$supplier->addExpression('unread')->set(function($m,$q){
			return $m->add('xCRM/Model_Email')
				->addCondition(
						$q->orExpr()
							->where(
									$q->andExpr()
									->where('from','Supplier')
									->where('from_id',$q->getField('id'))
								)
							->where(
									$q->andExpr()
										->where('to','Supplier')
										->where('to_id',$q->getField('id'))
								)
					)
				->addCondition('read_by_employee_id',null)
				->count();
		});


		$supplier_crud=$left_col->add('CRUD',array('grid_class'=>'xHR/Grid_MailParty','allow_add'=>false,'allow_edit'=>false,'allow_del'=>false));
		$supplier_crud->setModel($supplier);
		
		$right_col=$col->addColumn(9);

		$mail_crud=$right_col->add('CRUD');
		$mail_crud->setModel('xCRM/Email',array(),array('subject'));
		$mail_crud->add('xHR/Controller_Acl');


	}
}