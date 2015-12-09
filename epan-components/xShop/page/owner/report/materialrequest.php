<?PHP

class page_xShop_page_owner_report_materialrequest extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$materialrequest=$this->add('xStore/Model_MaterialRequest');
		$materialrequest->addCondition('from_department_id'$_GET['department_id']);
		$form=$this->add('Form');
		$form->addField('Dropdown','status')->setValueList(array('approved'=>'approved','assigned'=>'assigned','processing'=>'processing','processed'=>'processed','forwarded'=>'forwarded',
															'completed'=>'completed','cancelled'=>'cancelled','return'=>'return'));
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get Report');

		$grid=$this->add('Grid');

		// $this->app->stickyGET('filter');
		$this->app->stickyGET('status');
		$this->app->stickyGET('from_date');
		$this->app->stickyGET('to_date');

		if($_GET['status']){
			$materialrequest->addCondition('status',$_GET['status']);
		}
		if($_GET['from_date']){
				$materialrequest->addCondition('created_at','>',$_GET['from_date']);
			}

		if($_GET['to_date']){
			$materialrequest->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
		}

		$grid->setModel($materialrequest);

		if($form->isSubmitted()){
			$grid->js()->reload(array('status'=>$form['status'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0))->execute();
		}



		
	}
}