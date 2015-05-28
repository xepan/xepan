<?php

namespace xMarketingCampaign;

class Filter_Lead extends \Filter_Base
{

    function init()
    {
        parent::init();

        $this->search_field = $this->addField('Line', 'q', '')->setAttr('placeholder','Search')->setNoSave();
        // $this->status_field = $this->addField('Dropdown', 'status', '')->setEmptyText('Any Status')->setValueList(array('active'=>'Active','inactive'=>'InActive'))->setNoSave();
        $this->cat_field = $this->addField('MultiSelect', 'category', '');
        $this->cat_field->setModel('xMarketingCampaign/Model_LeadCategory');

        $this->cat_field->setAttr('multiple','multiple');
        $this->cat_field->selectnemu_options=array('maxWidth'=>200);
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
        $newcat= $this->get('category');
        // $status = $this->get('status');

        if(!$v AND !$newcat /*AND !$status*/) {
            return;
        }

        if($this->view->model->hasMethod('addConditionLike')){
            return $this->view->model->addConditionLike($v, $this->fields);
        }
        if($this->view->model) {
            $this->view->model->leftJoin('xenquirynsubscription_subscatass.subscriber_id')
                                ->addField('category_id');
            $q = $this->view->model->_dsql();
        } else {
            $q = $this->view->dq;
        }
        
        $and = $q->andExpr();

        $or = $q->orExpr();
        foreach($this->fields as $field) {
            $or->where($field, 'like', '%'.$v.'%');
        }

        if($newcat){
	        $q->where('category_id',$newcat);
        }

        // if($status)
        //     $and->where('is_active',$status=='active'?1:0);
        
        $and->where($or);
        $q->having($and);
    }
}
