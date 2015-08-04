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
        
        $order_detail=$this->add('xShop/Model_OrderDetails');
        $order_detail->addCondition('order_id',$order_id);
        $crud = $container->add('CRUD');

        $crud->js('reload',array(
                    $crud->js()->_selector('.order-grid')
                    ->atk4_grid('highlightRow',$order_id),
                    $crud->js()->univ()->successMessage('Done')
                    )
            );

        $order_detail->getElement('item_id')->display(array('form'=>'xShop/Item'));

        $crud->setModel($order_detail,array('item_id','qty','rate','amount','status','custom_fields','tax_id','apply_tax','narration'),array('item','item_name','custom_fields','qty','unit','rate','unit','amount','status','tax_per_sum','tax_amount','texted_amount'));
        
        if(!$crud->isEditing()){
            $grid = $crud->grid;
            $grid->addMethod('format_status',function($g,$f){
                $g->current_row[$f] = $g->model->getCurrentStatus();
            });
            $grid->addColumn('status','status');
            $grid->removeColumn('item');
            $grid->removeColumn('custom_fields');
            $grid->removeColumn('tax_id');

            $export_ = $grid->addColumn('Button','ExportDesign','Export Design');
            if($_GET['ExportDesign']){
               // xShop_page_designer_pdf&department_id=4&xshop_orders_id=1124&item_id=not-available&item_member_design_id=0&cut_page=0                                                                                                         
                $grid->js()->univ()->newWindow($this->api->url('xShop_page_designer_pdf',array('item_id'=>'not-available','item_member_design_id'=>$order_detail->itemMemberDesignId(),'xsnb_design_template'=>false,'cut_page'=>0)))->execute();
            }
            // $grid->addColumn('expander','attachment',array('page'=>'xShop_page_owner_attachment','descr'=>'Attachments'));
        }

        if($crud->isEditing('add') or $crud->isEditing('edit')){
            $item_field = $crud->form->getElement('item_id');
            $item_field->custom_field_element = 'custom_fields';
            $item_field->qty_effected_custom_fields_only = false;
        }

        $crud->add('xShop/Controller_getRate');

        $crud->add('xHR/Controller_Acl',array('document'=>'xShop\Order_'. ucwords($order['status']),'show_acl_btn'=>false,'override'=>array('can_view'=>'All','can_see_activities'=>'No')));
        // $crud->add('Controller_FormBeautifier');
	}
}