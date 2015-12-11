<?php
/**
 * Page class
 */
class page_xShop_page_owner_report_order extends page_xShop_page_owner_main{
    // public ='';

    /**
     * Initialize the page
     *
     * @return void
     */
    function init(){
        parent::init();
        $customer=$this->add('xShop/Model_Customer');

        $form = $this->add('Form');
        $form->addField('autocomplete/Basic','customer')->setModel($customer);
        $form->addField('DatePicker','from_date');
        $form->addField('DatePicker','to_date');
        $form->addSubmit('Get Report');

        $col = $this->add('Columns');
        $col_1 = $col->addColumn(4);
        $col_2 = $col->addColumn(4);
        $col_3 = $col->addColumn(4);
        $col_4 = $col->addColumn(4);
        $col_5 = $col->addColumn(4);
        $col_6 = $col->addColumn(4);

        //Today total Old total_old_Order
        $order=$this->add('xShop/Model_Order');
        $order->addCondition('status','<>','draft');
 
        $total_old_order = $this->add('xShop/Model_Order');
        $total_old_order->addCondition('status','<>','draft');
        $total_old_order->addCondition('status','<>','completed');
 
        $approved_order = $this->add('xShop/Model_Order_Approved');
        $running_order = $this->add('xShop/Model_Order');
        $running_order->addCondition('status','<>',array('draft','completed','submitted','cancel','redesign'));
        $old_complete_order = $this->add('xShop/Model_Order_Completed');
        $new_complete_order = $this->add('xShop/Model_Order_Completed');
        $complete_order = $this->add('xShop/Model_Order_Completed');
        
        $grid=$this->add('xShop/Grid_Order');
        
        $from_date ='1970-01-01';
        $to_date = $this->api->today;
        $member_id='';
        
        $from_date = $this->app->stickyGET('from_date');
        $to_date = $this->app->stickyGET('to_date');
        $member_id=$this->app->stickyGET('customer');
        if($_GET['filter']){
            if($_GET['from_date']){
                $order->addCondition('created_at','>',$from_date);
                $total_old_order->addCondition('created_at','>=',$from_date);
                $approved_order->addCondition('created_at','>=',$from_date);
                $running_order->addCondition('created_at','>=',$from_date);
                $old_complete_order->addCondition('created_at','>=',$from_date);
                $new_complete_order->addCondition('created_at','>=',$from_date);
            }
            if($_GET['to_date']){

                $order->addCondition('created_at','<=',$this->api->nextDate($to_date));
                $total_old_order->addCondition('created_at','<',$this->api->nextDate($to_date));
                $approved_order->addCondition('created_at','<',$this->api->nextDate($this->api->today));
                $running_order->addCondition('created_at','<',$this->api->nextDate($to_date));
                $old_complete_order->addCondition('created_at','<',$this->api->nextDate($to_date));
                $new_complete_order->addCondition('created_at',$this->api->nextDate($this->api->today));
            }
            if($_GET['customer']){
                $order->addCondition('member_id',$member_id);
                $total_old_order->addCondition('member_id',$member_id);
                $approved_order->addCondition('member_id',$member_id);
                $running_order->addCondition('member_id',$member_id);
                $old_complete_order->addCondition('member_id',$member_id);
                $new_complete_order->addCondition('member_id',$member_id);
                
            }

        }else{
            $order->addCondition('id',-1);
        }
        $old_order_view = $col_1->add('View_Warning');
        $new_order_view = $col_2->add('View_Success');
        $runnning_order_view = $col_3->add('View_Info');
        $old_complete_order_view = $col_4->add('View_Error');
        $new_complete_order_view = $col_5->add('View_Info');
        $complete_order_view = $col_6->add('View_Success');
        
        $old_total_old_order_count=$total_old_order->count()->getOne();
        $old_order_view->set('Total Old Order.:'. $old_total_old_order_count."rand = ".rand(0,9999));   
        
        $new_order_count=$approved_order->count()->getOne();
        $new_order_view->set('Total New Order.:'. $new_order_count);   

        $running_order_count=$running_order->count()->getOne();
        $runnning_order_view->set('Total Running Order.: '. $running_order_count);
    
        $old_complete_order_count=$old_complete_order->count()->getOne();
        $old_complete_order_view->set('Old Complete Order.: '. $old_complete_order_count);

        $new_complete_order_count=$new_complete_order->count()->getOne();
        $new_complete_order_view->set('New Complete Order.: '. $new_complete_order_count);
        
        $complete_order->addCondition('member_id',$member_id);
        $complete_order_count=$complete_order->count()->getOne();
        $complete_order_view->set('Total Complete Order.: '. $complete_order_count);
        $grid->setModel($order);//,array('status','created_by','created_at','currency','member','name','net_amount','delivery_date','orderitem_count'));

        $grid->addPaginator(100);
        $grid->addSno();    
         
        $print_all_btn=$grid->addButton('print')->set('Print All');

        $print_all_btn->OnClick(function($print_all_btn)use($grid,$from_date,$to_date,$member_id){
            return $this->js()->univ()->newWindow($this->api->url('xShop_page_owner_printsaleorder',array('from_date'=>$from_date,'to_date'=>$to_date,'member_id'=>$member_id,'printAll'=>1,'sale_performa'=>1)))->execute();
        });
            

        if($form->isSubmitted()){
            $grid->js(null,$col->js()->reload())->reload(
                                array('from_date'=>$form['from_date']?:0,
                                    'to_date'=>$form['to_date']?:0,
                                    'customer'=>$form['customer'],
                                    'filter'=>1)
                                )->execute();
        }



    }
}