<?php
/**
 * Page class
 */
class page_xShop_page_owner_report extends page_xShop_page_owner_main{
    // public ='';

    /**
     * Initialize the page
     *
     * @return void
     */
    function init(){
        parent::init();
        $form = $this->add('Form');
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
        $total_old_order = $this->add('xShop/Model_Order');
        $approved_order = $this->add('xShop/Model_Order_Approved');
        $running_order = $this->add('xShop/Model_Order');
        $old_complete_order = $this->add('xShop/Model_Order_Completed');
        $new_complete_order = $this->add('xShop/Model_Order_Completed');
        $complete_order = $this->add('xShop/Model_Order_Completed');
        
        $old_order_view = $col_1->add('View_Warning');
        $new_order_view = $col_2->add('View_Success');
        $runnning_order_view = $col_3->add('View_Info');
        $old_complete_order_view = $col_4->add('View_Error');
        $new_complete_order_view = $col_5->add('View_Info');
        $complete_order_view = $col_6->add('View_Success');

        $from_date ='1970-01-01';
        $to_date = $this->api->today;
        
        if($_GET['from_date'])
            $from_date = $this->api->stickyGET('from_date');
        if($_GET['to_date'])
            $to_date = $this->api->stickyGET('to_date');


            $total_old_order->addCondition('created_at','>=',$from_date);
            $total_old_order->addCondition('created_at','<',$this->api->nextDate($to_date));
            $total_old_order->addCondition('status','<>','draft');
            $total_old_order->addCondition('status','<>','completed');
          
            $approved_order->addCondition('created_at','>=',$from_date);
            $approved_order->addCondition('created_at','<',$this->api->nextDate($this->api->today));

            $running_order->addCondition('created_at','>=',$from_date);
            $running_order->addCondition('created_at','<',$this->api->nextDate($to_date));
            $running_order->addCondition('status','<>',array('draft','completed','submitted','cancel','redesign'));
            
            $old_complete_order->addCondition('created_at','>=',$from_date);
            $old_complete_order->addCondition('created_at','<',$this->api->nextDate($to_date));

            $new_complete_order->addCondition('created_at','>=',$from_date);
            $new_complete_order->addCondition('created_at',$this->api->nextDate($this->api->today));


            $old_total_old_order_count=$total_old_order->count()->getOne();
            $old_order_view->set('Total Old Order.:'. $old_total_old_order_count);   
            
            $new_order_count=$approved_order->count()->getOne();
            $new_order_view->set('Total New Order.:'. $new_order_count);   

            $running_order_count=$running_order->count()->getOne();
            $runnning_order_view->set('Total Running Order.: '. $running_order_count);
        
            $old_complete_order_count=$old_complete_order->count()->getOne();
            $old_complete_order_view->set('Old Complete Order.: '. $old_complete_order_count);

            $new_complete_order_count=$new_complete_order->count()->getOne();
            $new_complete_order_view->set('New Complete Order.: '. $new_complete_order_count);
        
            $complete_order_count=$complete_order->count()->getOne();
            $complete_order_view->set('Total Complete Order.: '. $complete_order_count);
        
        if($form->isSubmitted()){
            $col->js()->reload(
                                array('from_date'=>$form['from_date']?:0,
                                    'to_date'=>$form['to_date']?:0)
                                )->execute();
        }



    }
}