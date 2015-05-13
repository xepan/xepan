<?php

namespace xShop;

class Filter_Item extends \Filter_Base
{

    function init()
    {
        parent::init();

        //Category
        $application_id=$this->api->recall('xshop_application_id');
        $category_model = $this->add('xShop/Model_Category');
        $category_model->addCondition('application_id',$application_id); 
        $category_model->setOrder('id','desc');
        
        $this->search_field = $this->addField('Line', 'q', '')->setAttr('placeholder','Search')->setNoSave();
        $this->status_field = $this->addField('Dropdown', 'status', '')->setEmptyText('Any Status')->setValueList(array('active'=>'Active','inactive'=>'InActive'))->setNoSave();
        $this->category_field = $this->addField('Dropdown', 'category', '')->setEmptyText('Any Item Category')->setModel($category_model);
        $this->type_field = $this->addField('MultiSelect', 'type', '')
                                    ->setValueList(
                                            array('is_saleable'=>'Saleable',
                                                'is_purchasable'=>'Purchasable',
                                                'mantain_inventory'=>'Mantain Inventory',
                                                'allow_negative_stock'=>'Negative Stock',
                                                'is_productionable'=>'Productionable',
                                                'website_display'=>'Website Display',
                                                'is_designable'=>'Designable',
                                                'is_template'=>'Template',
                                                'enquiry_allow'=>'Allow Enquiry',
                                                'show_price'=>'Show Price',
                                                'is_visible_sold'=>'Item Remains Visible After Sold',
                                                'enquiry_send_to_admin'=>'Enquiry Send To Admin',
                                                'allow_comments'=>'Allow Comments',
                                                'qty_from_set_only'=>'Qty From Set Only'
                                                )
                                        );

        $this->type_field->setAttr('multiple','multiple');
        $this->type_field->selectnemu_options=array('maxWidth'=>200);

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
        
        foreach ($_POST[$this->type_field->name] as $x) {
            echo $x ."<br/>";
        }
        
        $status = $this->get('status');

        // if($this->api->isAjaxOutput())
        //     throw new \Exception($type, 1);
        

        if(!$v AND !$status AND !$category) {
            return;
        }

        if($this->view->model->hasMethod('addConditionLike')){
            return $this->view->model->addConditionLike($v, $this->fields);
        }
        if($this->view->model) {
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

            // foreach ($type as $type) {
            //     // $and->where($type)
            // }
        }
        
        $and->where($or);
        $q->having($and);
    }
}
