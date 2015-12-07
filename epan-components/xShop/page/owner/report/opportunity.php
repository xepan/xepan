<?PHP

class page_xShop_page_owner_report_opportunity extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$leads=$this->add('xMarketingCampaign/Model_Lead');
		$customer=$this->add('xShop/Model_Customer');
		$opportunity=$this->add('xShop/Model_Opportunity');
		// $status=$opportunity->getElement('status');
		$form=$this->add('Form');
		$form->addField('autocomplete/Basic','lead')->setModel($leads);
		$form->addField('autocomplete/Basic','customer')->setModel($customer);
		$form->addField('Dropdown','status')->setValueList(['active'=>'active','dead'=>'dead','converted'=>'converted'])->setEmptyText('Please Select');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get Opportunity');
		
		$grid=$this->add('Grid');

		$this->app->stickyGET('filter');
		$this->app->stickyGET('lead');
		$this->app->stickyGET('customer');
		$this->app->stickyGET('status');
		$this->app->stickyGET('from_date');
		$this->app->stickyGET('to_date');
		if($_GET['filter']){

			if($_GET['lead']){
				$opportunity->addCondition('lead_id',$_GET['lead']);
			}
			if($_GET['customer']){
				$opportunity->addCondition('customer_id',$_GET['customer']);
			}
			if($_GET['status']){
				$opportunity->addCondition('status',$_GET['status']);
			}
			if($_GET['from_date']){
				$opportunity->addCondition('created_at','>',$_GET['from_date']);
			}

			if($_GET['to_date']){
				$opportunity->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
		
		}else
			$opportunity->addCondition('id',-1);


		// $transaction_row_model->add('Controller_Acl');
		$grid->setModel($opportunity);

		$grid->addPaginator(100);
		$grid->addSno();

		// $js=array(
		// 	$this->js()->_selector('.mymenu')->parent()->parent()->toggle(),
		// 	$this->js()->_selector('#header')->toggle(),
		// 	$this->js()->_selector('#footer')->toggle(),
		// 	$this->js()->_selector('ul.ui-tabs-nav')->toggle(),
		// 	$this->js()->_selector('.atk-form')->toggle(),
		// 	);

		// $grid->js('click',$js);


		if($form->isSubmitted()){

			$grid->js()->reload(array('lead'=>$form['lead'],
									  'customer'=>$form['customer'],
									  'status'=>$form['status'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1))->execute();

		}		
		
	}
}