<?php
namespace xCRM;
class Grid_Email extends \Grid{
	function init(){
		parent::init();

		$this->message_vp = $this->add('VirtualPage')->set(function($p){
			$email_id = $p->api->stickyGET('xcrm_email_id');
			$m = $p->add('xCRM/Model_Email')->tryLoad($email_id);
			//Mark Read Email
			$m->markRead();
			$email_view=$p->add('xHR/View_Email');
			$email_view->setModel($m);
				return true;

		});


		$this->reply_vp = $this->add('VirtualPage')->set(function($p){
			$email_id = $p->api->stickyGET('xcrm_email_id');
			$p->add('xCRM/View_EmailReply',array('email_id'=>$email_id));
		});

		// $this->task_vp = $this->add('VirtualPage')->set(function($p){
		// 	$p->add('View')->set('Create task from here');
		// });

		$this->compose_vp = $this->add('VirtualPage')->set(function($p){
			$p->add('View')->set('Compose your Email here');
		});

		$this->addPaginator($ipp=50);
		
	}

	function setModel($model,$fields=array()){
		parent::setmodel($model,$fields);

		$fields = $model->getActualFields();
		$this->addQuickSearch($fields,null,'xCRM/Filter_xMail');
	}

	function format_subject(){
		$task_html = "";
		if($this->model['task_id'] and $this->model['status'] !='cancelled')
			$task_html = $this->taskHtml($this->model['task_status']);

		//Read Or Unread Emails
		if(!$this->model['read_by_employee_id'])
			$this->setTDParam('subject','class','atk-text-bold');
		else
			$this->setTDParam('subject','class','atk-text-normal');
		
		//Check for Email is Incomeing or OutGoing
		$snr = "";//send and receive icon
		$from = "";

		if($this->model['direction']=="received"){
			$this->setTDParam('subject','style','box-shadow:3px 0px 0px 0px green inset;');
			$snr .= '<span class="atk-swatch-green glyphicon glyphicon-import" title="Received E-Mail"></span>';
			
			//Form Email
			$from.= '<div class="atk-col-2" title="'.$this->model['from_email'].'" style="overflow:hidden;   display:inline-block;  text-overflow: ellipsis; white-space: nowrap;">';
			$from.= $snr;
			$from_member_name = $this->model->fromMemberName();
			if($from_member_name){
				//Filter Emails when click on it
				$param_name = $this->model['from']?strtolower($this->model['from'].'_id'):'';
				$js = $this->js()->reload(array($param_name=>$this->model['from_id'],'associate_filter'=>1,'member_name'=>$from_member_name,'member_type'=>$this->model['from'],'param'=>$param_name));
				$from.='<a class="xepan-xmail-name-filter" onclick="'.$js.'">'.$from_member_name.'</a><br/>';
			}
			if($this->model['from_name'])
				$from.=$this->model['from_name'].'<br/>';
			$from.= $this->model['from_email'].'</div>';

		}elseif($this->model['direction']=="sent"){
			//IN This CASE FROM IS Actually your staff.. from whom tis email was sent
			$this->setTDParam('subject','style','box-shadow: 3px 0px 0px 0px red inset;');
			$snr .= '<span class="atk-swatch-red glyphicon glyphicon-export" title="Send E-Mail"></span>';
			
			//To Email if Sent
			$from = " ";
			$from.= '<div class="atk-col-2" title="'.$this->model['to_email'].'" style="overflow:hidden;   display:inline-block;  text-overflow: ellipsis; white-space: nowrap;">';
			$from.= $snr;
			$to_member_name = $this->model->toMemberName();
			if($to_member_name){
				$param_name = $this->model['to']?strtolower($this->model['to'].'_id'):'';
				$js = $this->js()->reload(array($param_name=>$this->model['to_id'],'associate_filter'=>1,'member_name'=>$to_member_name,'member_type'=>$this->model['to'],'param'=>$param_name));
				$from.='<a class="xepan-xmail-name-filter" onclick="'.$js.'">'.$to_member_name.'</a><br/>';
				// $from.=$to_member_name.'<br/>';
			}
			$from.= $this->model['to_email'];
			$from.= "<div class='atk-text-dimmed'> -- from : ".$this->model['from_detail'].'</div></div>';
		}

		$str = '<div  class="atk-row xepan-padding">';
		//From Email
		$str.= $from;
		//Subject
		$str.= '<div class="atk-col-7" style="overflow:hidden; display:inline-block;  text-overflow: ellipsis; white-space: nowrap;" >'.$task_html.'<a href="javascript:void(0)" onclick="'.$this->js(null,$this->js()->_selectorThis()->closest('td')->removeClass('atk-text-bold'))->univ()->frameURL('E-mail',$this->api->url($this->message_vp->getURL(),array('xcrm_email_id'=>$this->model->id))).'">'.$this->model['subject'].'</a> - ';
		//Message
		$str.= substr(strip_tags($this->model['message']),0,50).'</div>';
		//Attachments
		if($this->model->attachment()->count()->getOne())
			$str.= '<div class="atk-col-1"><i class="icon-attach"></i></div>';
		else
			$str.= '<div class="atk-col-1 text-right"></div>';
		//Date Fields
		$str.= '<div class="atk-col-2 atk-size-micro">'.$this->add('xDate')->diff(\Carbon::now(),$this->model['created_at']).'<br/>'.$this->model['created_at'];
		if($this->model['read_by_employee'])
			$str .= "<div class='atk-text-dimmed'>read by: ".$this->model['read_by_employee']."</div>";
		$str .='</div>';
		// End Date Field
		$str.= '</div>';
		
		$this->current_row_html['subject'] = $str;
	}

	function format_reply(){
		$reply_html = '<a href="javascript:void(0)" onclick="'.$this->js()->univ()->frameURL('E-mail Reply',$this->api->url($this->reply_vp->getURL(),array('xcrm_email_id'=>$this->model->id))).'"><i class="icon-reply"></i></a>';

		$this->current_row_html['reply'] = $reply_html;
	}

	function format_task(){
		$task_html = '<a href="javascript:void(0)" onclick="'.$this->js()->univ()->frameURL('Create Task',$this->api->url($this->task_vp->getURL(),array('xcrm_email_id'=>$this->model->id))).'"><i class="icon-pencil"></i></a>';

		$this->current_row_html['task'] = $task_html;
	}
	
	function recursiveRender(){

			$this->addFormatter('subject','subject');
			
			//REPLY FORMATTER
			// $this->addColumn('task');
			// $this->addFormatter('task','task');

			$this->addColumn('reply');
			$this->addFormatter('reply','reply');

			$this->removeColumn('to_email');
			$this->removeColumn('from_email');
			$this->removeColumn('from_name');
			$this->removeColumn('cc');
			$this->removeColumn('bcc');
			$this->removeColumn('message');
			$this->removeColumn('id');
			$this->removeColumn('from_id');
			$this->removeColumn('from');
			$this->removeColumn('direction');
			$this->removeColumn('task_id');
			$this->removeColumn('task_status');
			$this->removeColumn('to');
			$this->removeColumn('to_id');
			$this->removeColumn('from_detail');
			$this->removeColumn('read_by_employee');

			// Compose Button
			$this->addButton(array('Compose','icon'=>'plus'))
				->js('click',$this->js()->univ()->frameURL('Compose E-mail',$this->api->url($this->compose_vp->getURL())))
			;

			// Delete Email Form
			$f=$this->add('Form',null,'grid_buttons');
			$field=$f->addField('Hidden','selected_emails','');
			$f->template->del('form_buttons');
			$this->addSelectable($field);

			$this->addButton(array('','icon'=>'trash'))
				->js('click',array($f->js()->submit(),$this->js()->find('tr input:checked')->closest('tr')->remove()));
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

			//Filter Box 
			if($this->api->stickyGET('associate_filter')){
				$filter_box = $this->add('View_Box',null,'grid_buttons')->addClass('atk-swatch-yellow col-md-2');
				$filter_box->set($this->api->stickyGET('member_type').': '.$this->api->stickyGET('member_name'));
				$param = $this->api->stickyGET('param');
				$self= $this;
				$close = $filter_box->add('Icon',null,'Button')			
		            ->addComponents(array('size'=>'mega'))
		            ->set('cancel-1')
		            ->addStyle(array('cursor'=>'pointer'))
		            ->on('click',$this->js()->reload(['associate_filter'=>0,$param=>0]));
			}


			// Mark Read Email Form
			$f=$this->add('Form',null,'grid_buttons');
			$field=$f->addField('Hidden','selected_emails','');
			$f->template->del('form_buttons');
			$this->addSelectable($field,'<center>Select<br>All/None</center>');

			$this->addButton(array('','icon'=>'ok'))
				->js('click',array($f->js()->submit(),$this->js()->find('tr input:checked')->closest('tr')->find('td.atk-text-bold')->removeClass('atk-text-bold')));
			;

			if($f->isSubmitted()){
				$ids = json_decode($f['selected_emails'],true);
				$this->add('xCRM/Model_Email')
					->addCondition('id',$ids)
					->each(function($obj){
						$obj->markRead();
					});

				$f->js()->univ()->successMessage('Marked as read')->execute();
			}



		$reload_btn = $this->addButton('FETCH');
		if( !($reload_btn instanceof \Dummy) and $reload_btn->isClicked()){
			$this->add('xCRM/Model_Email')->fetchDepartment($this->api->current_department);
			$this->js()->univ()->successMessage('Fetch Successfully')->execute();
		}
		parent::recursiveRender();
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

	function render(){
		$this->js('click',
			$this->js()->
			IF($this->js()->hasClass('all'))
				->removeClass('all')->addClass('none')->atk4_checkboxes('unselect_all')
			->ELSE()
				->removeClass('none')->addClass('all')->atk4_checkboxes('select_all')
			->ENDIF()
			)
		->_selector('th:contains("Select")');
		parent::render();
	}
}