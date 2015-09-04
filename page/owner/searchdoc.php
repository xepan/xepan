<?php

class page_owner_searchdoc extends page_base_owner{
	
	function page_index(){

		$document = "Any || xShop/Customer";
		$term = "";

		// sensitize term like add + befrore order, customer etc

		$structure_array =[
			'xShop/Customer'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'customer/supplier/employee', /*will get name in by of producer of document*/
					'to' =>'customer/supplier/employee', /*will get name in by of producer of document*/
					'date' =>'created_at', /*will get name in by of producer of document*/
					'status' =>'status', /*will get name in by of producer of document*/
					'document_model' =>'xShop/Customer', /*will get name in by of producer of document*/
					'id' =>'id', /*will get name in by of producer of document*/
				]
			],
			'DocumentName2'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'customer/supplier/employee', /*will get name in by of producer of document*/
					'to' =>'customer/supplier/employee', /*will get name in by of producer of document*/
					'date' =>'created_at', /*will get name in by of producer of document*/
					'status' =>'status', /*will get name in by of producer of document*/
					'document_model' =>'xShop/Customer', /*will get name in by of producer of document*/
					'id' =>'id', /*will get name in by of producer of document*/
				]
			]
		];

		$data=[];
		foreach ($structure_array as $model=>$structure) {
			if($document!='Any' && $document !=$model) continue;
				$m=$this->add($model);
				$m->addExpression('relevance')->set('MATCH('.$structure['search_field'].') AGAINST ("'.$term.'") IN NATURAL LANGUAGE');
				$m->setOrder($m->dsql()->expr('[0]',$m->getElement('relevance')),'DESC');
				if($document =='Any')
					$m->setLimit(5);
				else
					$m->setLimit(15);

				$m->getRows();
				$m_data=[];
				foreach ($m as $tm) {
					$m_data['relevance'] = $m['relevance'];
					foreach ($structure['return_fields'] as $standard => $model_field) {
						$m_data[$standard] = $m[$model_field];
					}
				}

				$data[] = $m_data;
		}

		// Sort this $data array by its all relevance
		// take first 15 records
		// json echo ..
		// baat khatam

        echo json_encode($data);
        exit;

	}

	function page_display(){
		$this->add('View_Success')->set($_GET['key']);
	}
}