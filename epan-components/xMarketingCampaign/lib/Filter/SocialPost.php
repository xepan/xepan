<?php

namespace xMarketingCampaign;

class Filter_SocialPost extends \Filter_Base
{

    function init()
    {
        parent::init();

        $this->search_field = $this->addField('Line', 'q', '')->setAttr('placeholder','Search')->setNoSave();
        $this->type_field = $this->addField('Dropdown', 'category', '')->setEmptyText('All Socail Post Category')->setNoSave()->setModel('xMarketingCampaign/SocialPostCategory');
        // $this->status_field = $this->addField('Dropdown', 'status', '')->setEmptyText('Any Status')->setValueList(array('active'=>'Active','inactive'=>'InActive'))->setNoSave();

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
        $subcat= $this->get('category');
        // $status = $this->get('status');

        if(!$v AND !$subcat /*AND !$status*/) {
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

        if($subcat)
	        $and->where('category_id',$subcat);

        // if($status)
        //     $and->where('is_active',$status=='active'?1:0);
        
        $and->where($or);
        $q->having($and);
    }
}