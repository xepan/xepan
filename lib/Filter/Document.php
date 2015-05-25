<?php


class Filter_Document extends \Filter_Base
{

    function init()
    {
        parent::init();

        //Category
        $this->search_field = $this->addField('Line', 'q', '')->setAttr('placeholder','Search')->setNoSave();
        // $this->type_field = $this->addField('Dropdown', 'category', '')->setEmptyText('All NewsLetter Category')->setNoSave()->setModel('Model_GenericDocumentCategory');
        $this->doc_cat_field = $this->addField('MultiSelect', 'category', '')->setModel('Model_GenericDocumentCategory');

        // $this->doc_cat_field->setAttr('multiple','multiple');
        // $this->doc_cat_field->selectnemu_options=array('maxWidth'=>200);

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
        $doc_cat= $this->get('category');
        // $status = $this->get('status');

        if(!$v AND !$doc_cat /*AND !$status*/) {
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

        if($doc_cat)
            $and->where('generic_doc_category_id',$doc_cat);

        // if($status)
        //     $and->where('is_active',$status=='active'?1:0);
        
        $and->where($or);
        $q->having($and);
    }
}
