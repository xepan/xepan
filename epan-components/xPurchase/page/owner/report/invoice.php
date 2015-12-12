<?PHP

class page_xPurchase_page_owner_report_invoice extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();
		$supplier=$this->add('xPurchase/Model_Supplier');
		$order=$this->add('xPurchase/Model_PurchaseOrder');
		$invoice=$this->add('xPurchase/Model_PurchaseInvoice');

		$form = $this->add('Form');
		$form->addField('autocomplete/Basic','order')->setModel($order);
		$form->addField('autocomplete/Basic','supplier')->setModel($supplier);
		$form->addField('Dropdown','status')->setValueList(array('approved'=>'approved','canceled'=>'canceled','completed'=>'completed','processed'=>'processed'))->setEmptyText('Please Select');
        $form->addField('DatePicker','from_date');
        $form->addField('DatePicker','to_date');
        $form->addSubmit('Get Report');

        $grid=$this->add('xPurchase/Grid_Invoice');
        $this->app->stickyGET('filter');
        $this->app->stickyGET('order');
        $this->app->stickyGET('supplier');
        $this->app->stickyGET('status');
        $this->app->stickyGET('from_date');
        $this->app->stickyGET('to_date');

        if($_GET['filter']){
        	if($_GET['order']){
        		$invoice->addCondition('purchase_order_id',$_GET['order']);
        	}
        	if($_GET['supplier']){
        		$invoice->addCondition('supplier_id',$_GET['supplier']);
        	}
        	if($_GET['status']){
        		$invoice->addCondition('status',$_GET['status']);
        	}
        	if($_GET['from_date']){
				$invoice->addCondition('created_at','>',$_GET['from_date']);
			}

			if($_GET['to_date']){
				$invoice->addCondition('created_at','<=',$this->api->nextDate($_GET['to_date']));
			}
        }else
        	$invoice->addCondition('id',-1);

        $grid->setModel($invoice);

        //if($grid->hasColumn('narration')) $grid->removeColumn('narration');

		$grid->addPaginator(100);
		$grid->addSno();
		$print=$grid->addButton('Print');

		$print->onClick(function()use ($print){

			// $print->js()->univ()->

		});

		if($form->isSubmitted()){

			$grid->js()->reload(array('order'=>$form['order'],
									  'customer'=>$form['supplier'],
									  'status'=>$form['status'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1))->execute();

		}			

		
	}
}