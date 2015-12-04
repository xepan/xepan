<?php

namespace xShop;

class Filter_Blog extends \Filter_Base
{

    function init()
    {
        parent::init();

        //Category
        $application_id=$this->api->recall('xshop_application_id');
        $category_model = $this->add('xShop/Model_BlogCategory');
        // $category_model->addCondition('application_id',$application_id); 
        // $category_model->setOrder('id','desc');
        
        $this->search_field = $this->addField('Line', 'q', '')->setAttr('placeholder','Search')->setNoSave();
        $this->status_field = $this->addField('Dropdown', 'status', '')->setEmptyText('Any Status')->setValueList(array('active'=>'Active','inactive'=>'InActive'))->setNoSave();
        $this->category_field = $this->addField('Dropdown', 'category', '')->setEmptyText('Any Item Category')->setModel($category_model);
        // $this->type_field = $this->addField('MultiSelect', 'type', '')
        //                             ->setValueList(
        //                                     array('is_saleable'=>'Saleable',
        //                                         'is_purchasable'=>'Purchasable',
        //                                         'mantain_inventory'=>'Mantain Inventory',
        //                                         'allow_negative_stock'=>'Negative Stock',
        //                                         'is_productionable'=>'Productionable',
        //                                         'website_display'=>'Website Display',
        //                                         'is_designable'=>'Designable',
        //                                         'is_template'=>'Template',
        //                                         'enquiry_allow'=>'Allow Enquiry',
        //                                         'show_price'=>'Show Price',
        //                                         'is_visible_sold'=>'Item Remains Visible After Sold',
        //                                         'enquiry_send_to_admin'=>'Enquiry Send To Admin',
        //                                         'allow_comments'=>'Allow Comments',
        //                                         'qty_from_set_only'=>'Qty From Set Only'
        //                                         )
        //                                 );

        // $this->type_field->setAttr('multiple','multiple');
        // $this->type_field->selectnemu_options=array('maxWidth'=>200);

    }

    /**
     * Process received filtering parameters after init phase
     *
     * @return void
     */
    function postInit()
    {
        parent::postInit();
        
        $v = trim($this->get('q'));
        $category= $this->get('category');
        
        $status = $this->get('status');
        // $type = $this->type_field->get();

        if(!($v OR $status OR $category)) {
            return;
        }

        if($this->view->model->hasMethod('addConditionLike')){
            return $this->view->model->addConditionLike($v, $this->fields);
        }
        if($this->view->model) {
            if($category)
                $this->view->model->join('xshop_category_item.item_id',null,null,'ic');
            $q = $this->view->model->_dsql();
        } else {
            $q = $this->view->dq;
        }
        
        $and = $q->andExpr();

        $or = $q->orExpr();
        foreach($this->fields as $field) {
               $or->where($field, 'like', '%'.$v.'%');
        }

        if($category){
            $q->where('ic.category_id',$category);
        }

        if($status)
            $and->where('is_publish',$status=='active'?1:0);
        
        if($type){
            foreach (explode(",",$type) as $types) {
                $and->where($types,1);
            }
        }

        $and->where($or);
        $q->having($and);
    }
}
