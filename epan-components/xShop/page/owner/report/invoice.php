<?PHP

class page_xShop_page_owner_report_invoice extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$customer=$this->add('xShop/Model_Customer');
		$order=$this->add('xShop/Model_Order');
		$invoice=$this->add('xShop/Model_SalesInvoice');
		$form = $this->add('Form');
		$form->addField('autocomplete/Basic','order')->setModel($order);
		$form->addField('autocomplete/Basic','customer')->setModel($customer);
		$form->addField('Dropdown','status')->setValueList(array('approved'=>'approved','canceled'=>'canceled','completed'=>'completed','processed'=>'processed'))->setEmptyText('Please Select');
        $form->addField('DatePicker','from_date');
        $form->addField('DatePicker','to_date');
        $form->addSubmit('Get Report');

        $grid=$this->add('xShop/Grid_Invoice');

        $this->app->stickyGET('filter');
        $order_id=$this->app->stickyGET('order');
        $customer_id=$this->app->stickyGET('customer');
        $status=$this->app->stickyGET('status');
        $from_date=$this->app->stickyGET('from_date');
        $to_date=$this->app->stickyGET('to_date');

        if($_GET['filter']){
        	if($_GET['order']){
        		$invoice->addCondition('sales_order_id',$_GET['order']);
        	}
        	if($_GET['customer']){
        		$invoice->addCondition('customer_id',$_GET['customer']);
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

        if($grid->hasColumn('narration')) $grid->removeColumn('narration');

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

		$print_all_btn=$grid->addButton('print')->set('Print All');

        $print_all_btn->OnClick(function($print_all_btn)use($grid,$from_date,$to_date,$customer_id,$order_id,$status){
            return $this->js()->univ()->newWindow($this->api->url('xShop_page_owner_printsaleinvoice',array('from_date'=>$from_date,'to_date'=>$to_date,'customer_id'=>$customer_id,'order_id'=>$order_id,'status'=>$status,'printAll'=>1)))->execute();
        });


		if($form->isSubmitted()){

			$grid->js()->reload(array('order'=>$form['order'],
									  'customer'=>$form['customer'],
									  'status'=>$form['status'],
									  'from_date'=>$form['from_date']?:0,
									  'to_date'=>$form['to_date']?:0,
									  'filter'=>1))->execute();

		}			

		
	}
}