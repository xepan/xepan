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
        $this->status_field = $this->addField('Dropdown', 'category', '')->setEmptyText('Any Item Category')->setModel($category_model);
        $this->status_field = $this->addField('Dropdown', 'type', '')->setEmptyText('Any Item Type')->setValueList(array('is_saleable'=>'Saleable','is_purchasable'=>'Purchasable'));

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
        
        $and->where($or);
        $q->having($and);
    }
}
