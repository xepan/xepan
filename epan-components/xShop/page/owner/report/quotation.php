<?PHP

class page_xShop_page_owner_report_quotation extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$leads=$this->add('xMarketingCampaign/Model_Lead');
		$customer=$this->add('xShop/Model_Customer');
		$opportunity=$this->add('xShop/Model_Opportunity');
		$quotation=$this->add('xShop/Model_Quotation');

		$form=$this->add('Form');
		$form->addField('autocomplete/Basic','lead')->setModel($leads);
		$form->addField('autocomplete/Basic','customer')->setModel($customer);
		$form->addField('autocomplete/Basic','opportunity')->setModel($opportunity);
		$form->addField('Dropdown','status')->setValueList(array('draft'=>'draft','approved'=>'approved','redesign'=>'redesign','submitted'=>'submitted','cancelled'=>'cancelled'))->setEmptyText('Please Select');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');

		$form->addSubmit('Get Quotation');

		$grid=$this->add('Grid');

		$this->app->stickyGET('filter');
		$this->app->stickyGET('lead');
		$this->app->stickyGET('customer');
		$this->app->stickyGET('opportunity');
		$this->app->stickyGET('status');
		$this->app->stickyGET('from_date');
		$this->app->stickyGET('to_date');
		if($_GET['filter']){

			if($_GET['lead']){
				$quotation->addCondition('lead_id',$_GET['lead']);
			}
			if($_GET['customer']){
				$quotation->addCondition('customer_id',$_GET['customer']);
			}
			if($_GET['opportunity']){
				$quotation->addCondition('opportunity_id',$_GET['opportunity']);
			}
			if($_GET['status']){
				$quotation->addCondition('status',$_GET['status']);
			}
			if($_GET['from_date']){
				$quotation->addCondition('created_at','>',$_GET['from_date']);
			}

			if($_GET['to_date']){
				$quotation->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
		
		}else
			$quotation->addCondition('id',-1);


		$grid->setModel($quotation);

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
									  'opportunity'=>$form['opportunity'],
									  'status'=>$form['status'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1))->execute();

		}	
	}
}