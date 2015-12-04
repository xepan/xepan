<?php

namespace xCRM;


class Filter_xMail extends \Filter_Base{

	function init(){
		parent::init();
		$this->search_field = $this->addField('Line', 'q', '')->setAttr('placeholder','Search')->setNoSave();
	}

	function postInit()
    {
        parent::postInit();
        
        $v = trim($this->get('q'));

        if(!($v)) {
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


        $and->where($or);
        $q->having($and);
    }
}