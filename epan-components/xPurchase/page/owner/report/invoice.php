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
        $order_id=$this->app->stickyGET('order');
        $supplier_id=$this->app->stickyGET('supplier');
        $status=$this->app->stickyGET('status');
        $from_date=$this->app->stickyGET('from_date');
        $to_date=$this->app->stickyGET('to_date');

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
		
		$print_all_btn=$grid->addButton('print')->set('Print All');

        $print_all_btn->OnClick(function($print_all_btn)use($grid,$from_date,$to_date,$supplier_id,$order_id,$status){
            return $this->js()->univ()->newWindow($this->api->url('xPurchase_page_owner_printpurchaseinvoice',array('from_date'=>$from_date,'to_date'=>$to_date,'supplier_id'=>$supplier_id,'order_id'=>$order_id,'status'=>$status,'printAll'=>1)))->execute();
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