<?php
class page_xHR_page_owner_xmail extends page_xHR_page_owner_main{
	
	function init(){
		parent::init();
		
		$this->app->title='x-Mail';
		$dept_id = $this->api->stickyGET('department_id');
		
		$dept = $this->add('xHR/Model_Department')->load($dept_id);
		$official_email_array = $dept->getOfficialEmails();
		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-envelope"></i> '.$dept['name'].' Mails <small> '.implode(", ", $official_email_array).'  </small>');

		$message_vp = $this->add('VirtualPage')->set(function($p){
			$email_id = $p->api->stickyGET('xcrm_email_id');
			$m = $p->add('xCRM/Model_Email')->tryLoad($email_id);			
			//Mark Read Email
			$m->markRead();
			$email_view=$p->add('xHR/View_Email');
			$email_view->setModel($m);
				return true;

		});
		
		$reply_vp = $this->add('VirtualPage')->set(function($p){
			$email_id = $p->api->stickyGET('xcrm_email_id');
			$official_email = $m->loadOfficialEmail();

			$m = $p->add('xCRM/Model_Email')->tryLoad($email_id);
			
			$reply_form = $p->add('Form_Stacked');
			//Load Official/Support Email According to,cc,bcc
			$reply_message = '<p>On Date: '.$m['created_at'].', '.$m['from_name'].' <'.$m['from_email'].'> Wrote </p>'.$m['message'];
			$reply_message	= '<blockquote>'.$reply_message.'</blockquote>';
			$reply_message .= $official_email?$official_email['footer']:"";

			$reply_form->addField('line','to')->set($m['from_email']);
			$reply_form->addField('line','cc')->set($m['cc']);
			$reply_form->addField('line','bcc')->set($m['bcc']);
			$reply_form->addField('line','subject')->set("Re. ".$m['subject']);
			$reply_form->addField('RichText','message')->set($reply_message)->setStyle('cursor','');
			$reply_form->addSubmit('reply');

			if($reply_form->isSubmitted()){
				$related_activity = $m->relatedDocument();
				$related_document = $related_activity->relatedDocument();
				$email_body = $reply_form['message'];
				$subject = $reply_form['subject'];
				
				//if this(Email) ka Related Document he to
				if( !($related_document instanceof \Dummy)){
					//Create karo Related Document Ki Activity
					$email_to = $reply_form['to'].','.$reply_form['cc'].$reply_form['bcc'];
					$related_document->createActivity('email',$subject,$email_body,$m['from'],$m['from_id'], $m['to'], $m['to_id'],$email_to,true,true);
				}else{//Create Karo Email 
					$email = $this->add('xCRM/Model_Email');
					$email['from'] = "Employee";
					$email['from_name'] = $this->api->current_employee['name'];
					$email['from_id'] = $this->api->current_employee->id;
					$email['to_id'] = $m['from_id'];
					$email['to'] = $m['from'];
					$email['cc'] = $m['cc'];
					$email['bcc'] = $m['bcc'];
					$email['subject'] = $subject;
					$email['message'] = $email_body;
					$email['from_email'] = $m['to_email'];//TODO Official Email 
					$email['to_email'] = $reply_form['to'];
					$email['direction'] = "sent";
					$email->save();
					$email->send();
					// $email->send($reply_form['to'],$subject,$email_body,explode(",",trim($reply_form['cc'])),explode(",",trim($reply_form['bcc'])),array(),$m->loadOfficialEmail());
				}

				$reply_form->js()->univ()->successMessage('Reply Message Send')->execute();
			}

		});

		$col = $this->add('Columns');
		$left_col=$col->addColumn(2);
		$right_col=$col->addColumn(10);

//CUSTOMER SECTION----------------------------------------------------------------------
		$customer=$this->add('xShop/Model_Customer');
		$customer->addExpression('unread')->set(function($m,$q)use($official_email_array){
			$to_search_cond = $q->orExpr();

			foreach ($official_email_array as $oe) {
				$to_search_cond->where('cc','like','%'.$oe.'%');
			}

			$to_search_cond->where('to_email',$official_email_array);

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
				->addCondition($to_search_cond)
				->count();
		});

		$customer->addExpression('last_email_on')->set(function($m,$q)use($official_email_array){
			$to_search_cond = $q->orExpr();

			foreach ($official_email_array as $oe) {
				$to_search_cond->where('cc','like','%'.$oe.'%');
			}

			$to_search_cond->where('to_email',$official_email_array);

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
				// ->addCondition('read_by_employee_id',null)
				->addCondition($to_search_cond)
				->setOrder('created_at','desc')
				->setLimit(1)
				->fieldQuery('created_at');
		});

		$customer->addExpression('total_email')->set(function($m,$q)use($official_email_array){
			$to_search_cond = $q->orExpr();

			foreach ($official_email_array as $oe) {
				$to_search_cond->where('cc','like','%'.$oe.'%');
			}

			$to_search_cond->where('to_email',$official_email_array);

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
				// ->addCondition('read_by_employee_id',null)
				->addCondition($to_search_cond)
				->count();
		});

		$customer_crud=$left_col->add('CRUD',array('grid_class'=>'xHR/Grid_MailParty','allow_add'=>false,'allow_edit'=>false,'allow_del'=>false));
		$customer->_dsql()->order(array('unread desc','last_email_on desc'));
		
		$customer_crud->setModel($customer);
		if(!$customer_crud->isEditing()){
			
			$customer_crud->grid->addMethod('init_anchor',function($g,$f){
				$g->columns[$f]['tdparam'] .= 'style="overflow:hidden;   display:inline-block;  text-overflow: ellipsis; white-space: nowrap;"';
			});

			$customer_crud->grid->addMethod('format_anchor',function($g,$f)use($right_col){
						$html = '';
						$html .= '<a style="text-decoration:none;color:gray;" title="'.$g->model['customer_name'].'" href="javascript:void(0)" onclick="'.$right_col->js()->reload(array('customer_id'=>$g->model->id)).'">'.$g->model['customer_name'].'</a>';
						$html .= '</div>';
						
						$html .= '<div class="atk-move-right">';
						//unread
						if($g->model['unread'])
							$html .='<span class="label label-success"  title="Unread Emails">'.$g->model['unread'].'</span>';

						//Total Email
						$html .= '<span class="label label-default"  title="Total Emails">'.$g->model['unread'].'</span></div>';

					$html .= '</div>';
					$g->current_row_html[$f]=$html;
				});
			$customer_crud->grid->addFormatter('customer_name','anchor,wrap');
		}


//SUPPLIER SECTION--------------------------------------------------------------------------------------------------------------------------
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
		

//Emails--------------------------------------------------------------------------------------
		$email = $this->add('xCRM/Model_Email');
		$email->getElement('subject')->caption('Emails');
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
		$mail_crud->setModel($emails,array(),array('subject','to_email','from_email','message','from','id','from_id','direction','task_id','task_status','from_name','cc','bcc'));
		$mg=$mail_crud->grid;
		
		if(!$mail_crud->isEditing()){
			$mg->addColumn('reply');

			$mg->addMethod('format_subject',function($g,$f)use($message_vp){
				$task_html = "";
				if($g->model['task_id'] and $g->model['status'] !='cancelled')
					$task_html = $this->taskHtml($g->model['task_status']);

				//Read Or Unread Emails
				if(!$g->model['read_by_employee_id'])
					$g->setTDParam('subject','class','atk-text-bold');
				else
					$g->setTDParam('subject','class','atk-text-normal');
				
				//Check for Email is Incomening or OutGoing
				$snr = "";
				$from = "";
				if($g->model['direction']=="received"){
					$g->setTDParam('subject','style','box-shadow:3px 0px 0px 0px green inset;');
					$snr .= '<span class="atk-swatch-green glyphicon glyphicon-import" title="Received E-Mail"></span>';
					
					//Form Email
					$from.= '<div class="atk-col-2" title="'.$g->model['from_email'].'" style="overflow:hidden;   display:inline-block;  text-overflow: ellipsis; white-space: nowrap;">';
					$from.= $snr;
					if($g->model->fromMemberName())
						$from.=$g->model->fromMemberName().'<br/>';
					if($g->model['from_name'])
						$from.=$g->model['from_name'].'<br/>';
					$from.= $g->model['from_email'].'</div>';

				}elseif($g->model['direction']=="sent"){
					$g->setTDParam('subject','style','box-shadow: 3px 0px 0px 0px red inset;');
					$snr .= '<span class="atk-swatch-red glyphicon glyphicon-export" title="Sent E-Mail"></span>';
					
					//To Email if Sent
					$from = " ";
					$from.= '<div class="atk-col-2" title="'.$g->model['to_email'].'" style="overflow:hidden;   display:inline-block;  text-overflow: ellipsis; white-space: nowrap;">';
					$from.= $snr;
					if($g->model->toMemberName())
						$from.=$g->model->toMemberName().'<br/>';
					$from.= $g->model['to_email'].'</div>';
				}

				$str = '<div  class="atk-row">';
				//From Email
				$str.= $from;
				//Subject
				$str.= '<div class="atk-col-7" style="overflow:hidden; display:inline-block;  text-overflow: ellipsis; white-space: nowrap;" >'.$task_html.'<a href="javascript:void(0)" onclick="'.$g->js(null,$this->js()->_selectorThis()->closest('td')->removeClass('atk-text-bold'))->univ()->frameURL('E-mail',$g->api->url($message_vp->getURL(),array('xcrm_email_id'=>$g->model->id))).'">'.$g->current_row[$f].'</a> - ';
				//Message
				$str.= substr(strip_tags($g->model['message']),0,50).'</div>';
				//Attachments
				if($g->model->attachment()->count()->getOne())
					$str.= '<div class="atk-col-1"><i class="icon-attach"></i></div>';
				else
					$str.= '<div class="atk-col-1 text-right"></div>';
				//Date Fields
				$str.= '<div class="atk-col-2 atk-size-micro">'.$g->add('xDate')->diff(Carbon::now(),$g->model['created_at']).'<br/>'.$g->model['created_at'].'</div>';
	
				$str.= '</div>';
				
				$g->current_row_html[$f] = $str;
			});
			$mg->addFormatter('subject','subject');

			//REPLY FORMATTER
			$mg->addMethod('format_reply',function($g,$f)use($reply_vp){
				$reply_html = '<a href="javascript:void(0)" onclick="'.$g->js()->univ()->frameURL('E-mail Reply',$g->api->url($reply_vp->getURL(),array('xcrm_email_id'=>$g->model->id))).'"><i class="icon-reply"></i></a>';
				$g->current_row_html[$f] = $reply_html;
			});
			$mg->addFormatter('reply','reply');

			$mg->removeColumn('to_email');
			$mg->removeColumn('from_email');
			$mg->removeColumn('from_name');
			$mg->removeColumn('cc');
			$mg->removeColumn('bcc');
			$mg->removeColumn('message');
			$mg->removeColumn('id');
			$mg->removeColumn('from_id');
			$mg->removeColumn('from');
			$mg->removeColumn('direction');
			$mg->removeColumn('task_id');
			$mg->removeColumn('task_status');

			$f=$mail_crud->grid->add('Form',null,'grid_buttons');
			$field=$f->addField('Hidden','selected_emails','');
			$f->template->del('form_buttons');
			$mail_crud->grid->addSelectable($field);

			$mail_crud->grid->addButton(array('','icon'=>'trash'))
				->js('click',array($f->js()->submit(),$mail_crud->grid->js()->find('tr input:checked')->closest('tr')->remove()));
			;

			if($f->isSubmitted()){
				$ids = json_decode($f['selected_emails'],true);
				$this->add('xCRM/Model_Email')
					->addCondition('id',$ids)
					->each(function($obj){
						$obj->forceDelete();
					});

				$f->js()->univ()->successMessage('Done')->execute();
			}

			$mg->addQuickSearch(array('from_email','to_email','cc','bcc','subject','message'),null,'xCRM/Filter_xMail');

		}

		

		$mail_crud->add('xHR/Controller_Acl');

		$reload_btn = $mail_crud->addButton('FETCH');
		if( !($reload_btn instanceof \Dummy) and $reload_btn->isClicked()){
			$this->add('xCRM/Model_Email')->fetchDepartment($this->api->current_department);
			$this->js()->univ()->successMessage('Fetch Successfully')->execute();
		}

		// $this->js(true)->_selector('*')->xtooltip();
	}

	function taskHtml($status){		
		//'processing','processed','completed','cancelled','rejected'		
		$class= "atk-effect-danger";
		$title= "Task";
		switch ($status) {
			case 'assigned':
				$title = "Task Assigned";
				$class = "atk-effect-danger";
			break;
			case 'processing':
				$title = "Task Processing";
				$class = 'atk-effect-warning'; 
			break;
			
			case 'processed':
				$title = "Task Processed";
				$class = 'atk-effect-success'; 
			break;

			case 'completed':
				$title = "Task Completed";
				$class = ''; 
			break;
			case 'rejected':
				$title = "Task Rejected by Employee";
				$class = 'atk-effect-danger'; 
			break;
			case 'cancelled':
				$title = "Task Cancelled by Employee";
				$class = ''; 
			break;
		}
		return '<span title="'.$title.'" class="icon-text-width '.$class.'"> </span>';
	}


}