<?php

class page_xShop_page_owner_order_detail extends page_xShop_page_owner_main{
    function init(){
		parent::init();
        
        $di = $this->api->stickyGET('department_id');
        $order_id = $this->api->stickyGET('xshop_orders_id');

        $container = $this->add('View');
        $container->addClass('atk-section atk-box atk-effect-info atk-padding-large atk-shapre-rounded');

        // $this->add('PageHelp',array('page'=>'order_details'));
        
        $order = $this->add('xShop/Model_Order')->load($order_id);

        $crud_actions = array('form_class'=>'xShop/Form_OrderItem');
       
        if($order['status']!='draft'){
        	$crud_actions=array('form_class'=>'xShop/Form_OrderItem');
        }
        
        
        $order_detail=$this->add('xShop/Model_OrderDetails');
        $order_detail->addCondition('order_id',$order_id);
        $crud = $container->add('CRUD');

        $crud->setModel($order_detail,array('item_id','qty','unit','rate','amount','status','custom_fields'),array('id','item','qty','unit','rate','amount','status'));
        
        if(!$crud->isEditing()){
            $grid = $crud->grid;
            $grid->addMethod('format_status',function($g,$f){
                $g->current_row[$f] = $g->model->getCurrentStatus();
            });
            $grid->addColumn('status','status');
            // $grid->addColumn('expander','attachment',array('page'=>'xShop_page_owner_attachment','descr'=>'Attachments'));
        }

        if($crud->isEditing('add') or $crud->isEditing('edit')){
            $item_field = $crud->form->getElement('item_id');
            $f= $item_field->other_field;
            $custom_fields_field = $crud->form->getElement('custom_fields');
            // $custom_fields_field->js(true)->hide();
            
            $btn = $item_field->other_field->belowField()->add('Button')->set('CustomFields');
            $btn->js('click',$this->js()->univ()->frameURL('Custome Field Values',array($this->api->url('xShop_page_owner_order_customfields',array('orderitem_id'=>$crud->id,'custom_field_name'=>$crud->form->getElement('custom_fields')->name)),"selected_item_id"=>$item_field->js()->val(),'current_json'=>$custom_fields_field->js()->val())));
        }

        $crud->add('xHR/Controller_Acl',array('document'=>'xShop\Order_'. ucwords($order['status']),'show_acl_btn'=>false,'override'=>array('can_view'=>'All','can_see_activities'=>'No')));
        // $crud->add('Controller_FormBeautifier');
	}
}