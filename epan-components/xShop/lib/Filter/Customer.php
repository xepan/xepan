<?php

namespace xShop;

class Filter_Customer extends \Filter_Base
{

    function init()
    {
        parent::init();

        $this->search_field = $this->addField('Line', 'q', '')->setAttr('placeholder','Search')->setNoSave();
        $this->status_field = $this->addField('Dropdown', 'is_active', '')->setEmptyText('Any Status')->setValueList(array('active'=>'Active','inactive'=>'InActive'))->setNoSave();
        // $this->cus_field = $this->addField('MultiSelect', 'customer', '');
        // $this->cus_field->setModel('xShop/Model_Customer');

        // $this->cus_field->setAttr('multiple','multiple');
        // $this->cus_field->selectnemu_options=array('maxWidth'=>200);

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
        // $customer= $this->get('customer');
        $status = $this->get('is_active');

        if(!$v /*AND !$customer*/ AND !$status) {
            return;
        }

        if($this->view->model->hasMethod('addConditionLike')){
            return $this->view->model->addConditionLike($v, $this->fields);
        }
        if($this->view->model) {
            $q = $this->view->model->_dsql();
        } else {
            $q = $this->view->dq;
        }
        
        $and = $q->andExpr();

        $or = $q->orExpr();
        foreach($this->fields as $field) {
            $or->where($field, 'like', '%'.$v.'%');
        }

        // if($customer)
	       //  $and->where('id',$customer);

        if($status)
            $and->where('is_active',$status);
        
        $and->where($or);
        $q->having($and);
    }
}
