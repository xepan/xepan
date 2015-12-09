<?PHP

class page_xShop_page_owner_report_customer extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$customer=$this->add('xShop/Model_Customer');
		$form=$this->add('Form');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get Report');


		$grid=$this->add('xShop/Grid_Customer');

		if($_GET['filter']){
			if($_GET['from_date']){
				$customer->addCondition('created_at','>',$_GET['from_date']);
			}

			if($_GET['to_date']){
				$customer->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
		
		}else{
			// $customer->addCondition('id',-1);
		}
		$grid->setModel($customer,array('organization_name','customer_name','customer_email',
										'mobile_number','created_at','address','city','state',
										'country','pincode','user_account_activation','is_active'));

		$grid->addPaginator(100);
		$grid->addSno();
		$grid->removeColumn('customer_name');
		$grid->removeColumn('customer_email');

		if($form->isSubmitted()){
			$grid->js()->reload(array('from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1)
								)->execute();
		}
		
	}
}