<?php

class page_owner_documents_shared extends page_base_owner{
	function init(){
		parent::init();

		$this->add('View_Info')->set('Shared Document');

		$model=$this->add('Model_Document_SharedDocument');
		$model->addCondition(
			$model->dsql()->expr(
				"IFNULL([0],[1]) > [2]",
				[$model->getElement('share_till'),$this->api->today,$this->api->nextDate($this->api->today)]
				)
			);

		$crud=$this->add('CRUD',array('grid_class'=>'Grid_GenericDocument','allow_del'=>false));
		$crud->setModel($model);
	}
}