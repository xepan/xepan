<?php
class page_xHR_page_owner_xmail extends page_xHR_page_owner_main{
	function init(){
		parent::init();

		$message_vp = $this->add('VirtualPage')->set(function($p){
			$email_id=$p->api->stickyGET('xcrm_email_id');
			$m=$p->add('xCRM/Model_Email')->tryLoad($email_id);
			$email_view=$p->add('xHR/View_Email');
			$email_view->setModel($m);
		});

		$dept_id= $this->api->stickyGET('department_id');
		
		$this->add('View_Success')->set($dept_id);

		$col=$this->add('Columns');
		$left_col=$col->addColumn(3);
		$right_col=$col->addColumn(9);

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
		
		if(!$customer_crud->isEditing()){
			$customer_crud->grid->addMethod('format_anchor',function($g,$f)use($right_col){
					$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$right_col->js()->reload(array('customer_id'=>$g->model->id)).'">'.$g->model['customer_name'].' ( '.$g->model['unread'].' ) '.'</a>';
				});
			$customer_crud->grid->addFormatter('customer_name','anchor');
		}


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

		if(!$supplier_crud->isEditing()){
			$supplier_crud->grid->addMethod('format_anchor',function($g,$f)use($right_col){
					$g->current_row_html[$f]='<a href="javascript:void(0)" onclick="'.$right_col->js()->reload(array('supplier_id'=>$g->model->id)).'">'.$g->model['name'].' ( '.$g->model['unread'].' ) '.'</a>';
				});
			$supplier_crud->grid->addFormatter('name','anchor');
		}
		


		$email = $this->add('xCRM/Model_Email');
		$emails = $email->loadDepartmentEmails();
		if(!$emails){
			$emails = $email->addCondition('id',-1);
		}
		// $official_email = $this->add('xHR/Model_OfficialEmail');
		// $official_email->addCondition('department_id',$dept_id);

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

		$mail_crud=$right_col->add('CRUD');
		$mail_crud->setModel($emails,array(),array('subject','to_email','from_email'));
		$mg=$mail_crud->grid;
		
		if(!$mail_crud->isEditing()){
			$mg->addMethod('format_subject',function($g,$f)use($message_vp){
				//Check for Email is Incomening or OutGoing
				$snr = "";									
				if($g->model->isReceive()){	
					$snr = '<small class="atk-swatch-green">In</small>';
				}elseif($g->model->isSent()){
					$snr = '<small class="atk-swatch-yellow">Out</small>';
				}

				$str = '<div  class="atk-row">';
				$str.= '<div class="atk-col-5">'.$g->model['from_email'].'</div>';
				$str.= '<small class="atk-col-2">'.$snr.'</small>';
				$str.= '<div class="atk-col-5">'.$g->model['to_email'].'</div>';
				$str.= '</div>';

				$g->current_row_html[$f] = '<a href="javascript:void(0)" onclick="'.$g->js()->univ()->frameURL('E-mail',$g->api->url($message_vp->getURL(),array('xcrm_email_id'=>$g->model->id))).'">'.$g->current_row[$f].'</a>'.$str;
			});
			$mg->addFormatter('subject','subject');
			
			$mg->removeColumn('to_email');
			$mg->removeColumn('from_email');
		}

		

		$mail_crud->add('xHR/Controller_Acl');

		$reload_btn = $mail_crud->addButton('Reload');
		if( !($reload_btn instanceof \Dummy) and $reload_btn->isClicked()){
			$this->add('xCRM/Model_Email')->fetchDepartment($this->api->current_department);
			$this->js()->univ()->successMessage('Fetch Successfully')->execute();
		}

	}
}