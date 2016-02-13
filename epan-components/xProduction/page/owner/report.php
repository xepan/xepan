<?php
class page_xProduction_page_owner_report extends page_xProduction_page_owner_main {
	public $title="Jobcard Report";
	function init(){
		parent::init();
        
        $filter = $this->api->stickyGET('filter');
        $from_date = $this->api->stickyGET('from_date');
        $to_date = $this->api->stickyGET('to_date');
        $member_id=$this->api->stickyGET('customer');
        
        
        $form = $this->add('Form');
        $customer=$this->add('xShop/Model_Customer');
        $form->addField('autocomplete/Basic','customer')->setModel($customer);
        $form->addField('DatePicker','from_date');
        $form->addField('DatePicker','to_date');
        $form->addSubmit('Get Report');
        

        $order=$this->add('xShop/Model_Order');            
        $order->addCondition('member_id',$member_id);
        $order->tryLoadAny();

        $v = $this->add('View');
        $view = $v->add('xProduction/View_Lister_JobcardOrder');
        $view->setModel($order);
        //order
            // orderDetails
                //jobcards
        
        foreach ($order as $o) {
            $jobcard_item=$view->add('xProduction/View_Lister_JobcardOrderItem');
            // $ods = $o->ref('xShop/OrderDetails');
            $order_detail=$v->add('xShop/Model_OrderDetails');
            $order_detail->addCondition('order_id',$o->id);
            $order_detail->tryLoadAny();
            
            foreach ($order_detail as $od) {
                // $od_job=$od->refSQL('xProduction/JobCard');
                $jobcard_model=$v->add('xProduction/Model_JobCard');
                $jobcard_model->addCondition('orderitem_id',$od->id);

                $jobcard_item->setModel($jobcard_model);
                // $view->template->trySet('order_item',$jobcard_item);

            }                        
        }        


        


        if($form->isSubmitted()){
            $v->js()->reload(
                            array( 
                                'from_date'=>$form['from_date']?:0,
                                'to_date'=>$form['to_date']?:0,
                                'customer'=>$form['customer'],
                                'filter'=>1
                                )
                )->execute();
        }
    }
}