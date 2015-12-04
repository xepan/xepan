<?php

namespace xShop;

class Filter_Affiliate extends \Filter_Base
{

    function init()
    {
        parent::init();

        //Type
        $application_id=$this->api->recall('xshop_application_id');
        $aff_type = $this->add('xShop/Model_AffiliateType');
        $aff_type->addCondition('application_id',$application_id); 
        $aff_type->setOrder('id','desc');
        
        $this->search_field = $this->addField('Line', 'q', '')->setAttr('placeholder','Search')->setNoSave();
        $this->status = $this->addField('Dropdown', 'Status', '')->setEmptyText('Any Status')->setValueList(array('active'=>'Active','inactive'=>'InActive'));
        $this->type_field = $this->addField('Dropdown', 'type', '')->setEmptyText('Any Affiliate Type')->setModel($aff_type);

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
        $type= $this->get('type');
        
        $status = $this->get('status');

        if(!($v OR $status OR $type)) {
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

        if($status)
            $and->where('is_active',$status=='active'?1:0);
        
        if($type){
            $and->where('affiliatetype_id',$type);
        }

        $and->where($or);
        $q->having($and);
    }
}
