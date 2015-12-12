<?PHP

class page_xPurchase_page_owner_report_supplier extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$supplier=$this->add('xPurchase/Model_Supplier');

		$form=$this->add('Form');
		$form->addField('DatePicker','from_date');
		$form->addField('DatePicker','to_date');
		$form->addSubmit('Get Report');


		$grid=$this->add('xPurchase/Grid_Supplier');

		if($_GET['filter']){
			if($_GET['from_date']){
				$supplier->addCondition('created_at','>',$_GET['from_date']);
			}

			if($_GET['to_date']){
				$supplier->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
		
		}else{
			 $supplier->addCondition('id',-1);
		}
		
		$grid->setModel($supplier);
		$grid->addPaginator(100);
		$grid->addSno();
		
		if($form->isSubmitted()){
			$grid->js()->reload(array('from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1)
								)->execute();
		}
		
	}
}